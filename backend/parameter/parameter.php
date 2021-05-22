<?php
//$_POST = json_decode(file_get_contents("php://input"), true);  //###### comment ni time submit - shafie 
require_once("../login/dbConfig.php");
//require_once("dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType =  $_POST["postType"];
//var_dump($_POST);

// SQL for view all parameter data //

switch ($postType) {
	case ("view"):
		$stmt = $mysqli->prepare("SELECT parameter_id, para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image FROM parameter order by parameter_id desc");
		$stmt->execute();
		$result = $stmt->get_result();

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$jsonArray[] = $row;
			};
			echo json_encode($jsonArray);
		} else {
			echo "0 results";
		}
		$stmt->close();
		break;
	case ("add"):
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$creation_date = date("Y-m-d");
		$creation_time = date("H:i:s");
		$creation_user = $_SESSION["username"];
		//$creation_user = "admin"; // comment this when submit
		$mode = "Add";

		if ($_FILES["imgUpload"]['name'] != "") {
			// rename image name
			$imgName = $_FILES["imgUpload"]["name"];
			$imgName = $creation_date . time() . rand(100000, 999999) . strtolower($imgName);
			$target_dir = "upload/";
			$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);

			// Select file type
			$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

			// Valid file extensions
			$extensions_arr = array("jpg", "jpeg", "png");

			// Check extension
			if (in_array($imageFileType, $extensions_arr)) {

				//query insert data into parameter table
				$stmt = $mysqli->prepare("INSERT INTO parameter (para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("ssssssssiissss", $_POST['para_code'],  $_POST['para_description'],  $_POST['para_description2'],  $_POST['para_description3'] ,$_POST['start_date'],  $_POST['end_date'],  $_POST['start_time'],  $_POST['end_time'],  $_POST['quantity'],  $_POST['amount'],  $imgName,  $creation_date,  $creation_time,  $creation_user);
	
				$stmt->execute();
				$stmt->close();

				// Upload image into upload folder
				move_uploaded_file($_FILES['imgUpload']['tmp_name'], $target_dir . $imgName);

				// query to store information into parameterlog table
				$stmtlog = $mysqli->prepare("INSERT INTO parameterlog ( mode, para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmtlog->bind_param("sssssssssiissss", $mode, $_POST['para_code'],  $_POST['para_description'],  $_POST['para_description2'],  $_POST['para_description3'], $_POST['start_date'],  $_POST['end_date'],  $_POST['start_time'],  $_POST['end_time'],  $_POST['quantity'],  $_POST['amount'],  $imgName,  $creation_date,  $creation_time,  $creation_user);
	
				$stmtlog->execute();
				$stmtlog->close();

				//echo "Success";
				header("location: ../../parameterMaintenance.php?success=parameter added");
			} else {
				//echo "Your image must in format "jpg", "jpeg" or "png" ";
				header("location: ../../parameterMaintenance.php?failed=wrong image format");
			}
		} else {		// elso for checking present of file

			//query insert data into parameter table
			$para_image = "";
			$stmt = $mysqli->prepare("INSERT INTO parameter (para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssssiissss", $_POST['para_code'],  $_POST['para_description'], $_POST['para_description2'], $_POST['para_description3'], $_POST['start_date'],  $_POST['end_date'],  $_POST['start_time'],  $_POST['end_time'],  $_POST['quantity'],  $_POST['amount'],  $para_image,  $creation_date,  $creation_time,  $creation_user);
	
			$stmt->execute();
			$stmt->close();

			$stmtlog = $mysqli->prepare("INSERT INTO parameterlog ( mode, para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("sssssssssiissss", $mode, $_POST['para_code'],  $_POST['para_description'], $_POST['para_description2'], $_POST['para_description3'], $_POST['start_date'],  $_POST['end_date'],  $_POST['start_time'],  $_POST['end_time'],  $_POST['quantity'],  $_POST['amount'],  $para_image,  $creation_date,  $creation_time,  $creation_user);
	
			$stmtlog->execute();
			$stmtlog->close();

			header("location: ../../parameterMaintenance.php?success=parameter added");
		}
		break;
	case ("update"):
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$modify_date = date("Y-m-d");
		$modify_time = date("H:i:s");
		$modify_user = $_SESSION["username"];
		//$modify_user = "admin"; // comment this when submit
		$mode = "Update";

		if ($_FILES["imgUpload"]['name'] = "") {

			$stmt = $mysqli->prepare("SELECT para_image, creation_date, creation_time, creation_user FROM parameter WHERE parameter_id = ?");
			$stmt->bind_param("i", $_POST["parameter_id"]);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows == 1) {
				// Bind result variables
				$stmt->bind_result($previous_img, $creation_date, $creation_time, $creation_user);

				$stmt->fetch();
				$stmt->close();

				if ($previous_img == "") {

					// rename image name
					$imgName = $_FILES["imgUpload"]["name"];
					$imgName = $modify_date . time() . rand(100000, 999999) . strtolower($imgName);
					$target_dir = "upload/";
					$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);

					// Select file type
					$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

					// Valid file extensions
					$extensions_arr = array("jpg", "jpeg", "png");

					if (in_array($imageFileType, $extensions_arr)) {

						//update data into parameter table
						$stmt = $mysqli->prepare("UPDATE parameter SET para_code = ?, para_description = ?, para_description2 = ?, para_description3= ?,  start_date = ?, end_date= ?, start_time =?, end_time = ?, quantity = ?, amount = ?, para_image = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE parameter_id = ?");
						$stmt->bind_param("ssssssssiisssss", $_POST['para_code'], $_POST['para_description'], $_POST['para_description2'], $_POST['para_description3'], $_POST['start_date'], $_POST['end_date'], $_POST['start_time'], $_POST['end_time'], $_POST['quantity'], $_POST['amount'], $imgName, $modify_date, $modify_time, $modify_user, $_POST['parameter_id']);
						$stmt->execute();
						$stmt->close();	

						// query to insert update log to parameterlog table
						$stmtlog = $mysqli->prepare("INSERT INTO parameterlog ( parameter_id, mode, para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$stmtlog->bind_param("isssssssssiisssssss", $_POST['parameter_id'], $mode, $_POST['para_code'], $_POST['para_description'], $_POST['para_description2'], $_POST['para_description3'], $_POST['start_date'],  $_POST['end_date'],  $_POST['start_time'],  $_POST['end_time'],  $_POST['quantity'],  $_POST['amount'],  $imgName,  $creation_date,  $creation_time,  $creation_user, $modify_date, $modify_time, $modify_user);
	
						$stmtlog->execute();
						$stmtlog->close();

						// Upload image into upload folder
						move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_dir . $imgName);

						header("location: ../../parameterMaintenance.php?success=parameter edited");
					} else {
						header("location: ../../parameterMaintenance.php?failed=wrong image format");
					}
				} else {

					// remove image in folder
					unlink("upload/" . $previous_img);

					// rename image name
					$imgName = $_FILES["imgUpload"]["name"];
					$imgName = $modify_date . time() . rand(100000, 999999) . strtolower($imgName);
					$target_dir = "upload/";
					$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);

					// Select file type
					$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

					// Valid file extensions
					$extensions_arr = array("jpg", "jpeg", "png");

					if (in_array($imageFileType, $extensions_arr)) {

						//update data into parameter table
						$stmt = $mysqli->prepare("UPDATE parameter SET para_code = ?, para_description = ?, para_description2 = ?, para_description3= ?, start_date = ?, end_date= ?, start_time =?, end_time = ?, quantity = ?, amount = ?, para_image = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE parameter_id = ?");
						$stmt->bind_param("ssssssssiisssss", $_POST['para_code'], $_POST['para_description'], $_POST['para_description2'], $_POST['para_description3'], $_POST['start_date'], $_POST['end_date'], $_POST['start_time'], $_POST['end_time'], $_POST['quantity'], $_POST['amount'], $imgName, $modify_date, $modify_time, $modify_user, $_POST['parameter_id']);
						$stmt->execute();
						$stmt->close();
	
						// query to insert update log to parameterlog table
						$stmtlog = $mysqli->prepare("INSERT INTO parameterlog ( parameter_id, mode, para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$stmtlog->bind_param("isssssssssiisssssss", $_POST['parameter_id'], $mode, $_POST['para_code'], $_POST['para_description'], $_POST['para_description2'], $_POST['para_description3'], $_POST['start_date'],  $_POST['end_date'],  $_POST['start_time'],  $_POST['end_time'],  $_POST['quantity'],  $_POST['amount'],  $imgName,  $creation_date,  $creation_time,  $creation_user, $modify_date, $modify_time, $modify_user);
	
						$stmtlog->execute();
						$stmtlog->close();

						// Upload image into upload folder
						move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_dir . $imgName);

						header("location: ../../parameterMaintenance.php?success=parameter edited");
					} else {
						header("location: ../../parameterMaintenance.php?failed=wrong image format");
					}
				}
			} else {
				//echo "No image data for selectd ID";
				header("location: ../../parameterMaintenance.php?failed=no image found");
			}
		} else {

			$stmt = $mysqli->prepare("UPDATE parameter SET para_code = ?, para_description = ?, para_description2 = ?, para_description3= ?, start_date = ?, end_date= ?, start_time =?, end_time = ?, quantity = ?, amount = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE parameter_id = ?");
			$stmt->bind_param("ssssssssiissss", $_POST['para_code'], $_POST['para_description'], $_POST['para_description2'], $_POST['para_description3'], $_POST['start_date'], $_POST['end_date'], $_POST['start_time'], $_POST['end_time'], $_POST['quantity'], $_POST['amount'], $modify_date, $modify_time, $modify_user, $_POST['parameter_id']);
			$stmt->execute();
			$stmt->close();	

			//query to fetch selected data from parameter table

			$stmt = $mysqli->prepare("SELECT para_image, creation_date, creation_time, creation_user FROM parameter WHERE parameter_id = ?");
			$stmt->bind_param("i", $_POST["parameter_id"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($para_image, $creation_date, $creation_time, $creation_user);
			$stmt->fetch();
			$stmt->close();

			// query to insert update log to parameterlog table
			$stmtlog = $mysqli->prepare("INSERT INTO parameterlog ( parameter_id, mode, para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("isssssssssiisssssss", $_POST['parameter_id'], $mode, $_POST['para_code'], $_POST['para_description'], $_POST['para_description2'], $_POST['para_description3'], $_POST['start_date'],  $_POST['end_date'],  $_POST['start_time'],  $_POST['end_time'],  $_POST['quantity'],  $_POST['amount'],  $para_image,  $creation_date,  $creation_time,  $creation_user, $modify_date, $modify_time, $modify_user);
	
			$stmtlog->execute();
			$stmtlog->close();

			header("location: ../../parameterMaintenance.php?success=parameter edited");
		}
		break;
	case ("delete"):
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$modify_date = date("Y-m-d");
		$modify_time = date("H:i:s");
		$modify_user = $_SESSION["username"];
		//$modify_user = "admin"; // comment this when submit
		$mode = "Delete";

		// query for fetch selected username data from user table

		$stmt = $mysqli->prepare("SELECT para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user FROM parameter WHERE parameter_id = ?");
		$stmt->bind_param("i", $_POST['parameter_id']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows == 1) {
	
			// query to get parameter data based on parameter_id
			$stmt->bind_result($para_code, $para_description, $para_description2, $para_description3, $start_date, $end_date, $start_time, $end_time, $quantity, $amount, $para_image, $creation_date, $creation_time, $creation_user);
			$stmt->fetch();
			$stmt->close();

			if ($para_image != "") {
				// remove image from upload folder
				unlink("upload/" . $para_image);
			}

			// query to insert update log to parameterlog table
			$stmtlog = $mysqli->prepare("INSERT INTO parameterlog ( parameter_id, mode, para_code, para_description, para_description2, para_description3, start_date, end_date, start_time, end_time, quantity, amount, para_image, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("isssssssssiisssssss", $_POST['parameter_id'], $mode, $para_code, $para_description, $para_description2, $para_description3, $start_date,  $end_date,  $start_time,  $end_time,  $quantity,  $amount,  $para_image,  $creation_date,  $creation_time,  $creation_user, $modify_date, $modify_time, $modify_user);
	
			$stmtlog->execute();
			$stmtlog->close();

			// query to delete data from user table

			$stmt = $mysqli->prepare("DELETE FROM parameter WHERE parameter_id = ?");
			$stmt->bind_param("i", $_POST["parameter_id"]);
			$stmt->execute();
			$stmt->close();

			header("location: ../../parameterMaintenance.php?success=parameter deleted");
		} else {
			header("location: ../../parameterMaintenance.php?failed=id no found");
		}
		break;
}

mysqli_close($mysqli);
