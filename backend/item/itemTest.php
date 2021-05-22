<?php
//$_POST = json_decode(file_get_contents("php://input"), true);  //###### comment ni time submit - shafie 
require_once("../login/dbConfig.php");
//require_once("dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType =  $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //

switch ($postType) {

	case ("searchRow"):

		if (isset($_POST["search"])) {
			// Prepare a select statement

			$sql = "SELECT item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10 FROM items WHERE item_no REGEXP ? OR description REGEXP ?";

			if ($stmt = $mysqli->prepare($sql)) {
				// Bind variables to the prepared statement as parameters
				$stmt->bind_param("ss", $_POST["search"], $_POST["search"]);

				// Set parameters
				$param_term = $_REQUEST["search"] . '%';

				// Attempt to execute the prepared statement
				if ($stmt->execute()) {
					$result = $stmt->get_result();

					// Check number of rows in the result set
					if ($result->num_rows > 0) {
						// Fetch result rows as an associative array
						while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
							$jsonArray[] = $row;
						}
						echo json_encode($jsonArray);
					} else {
						//echo "<p>No matches found</p>";
						//header("location: ../../itemMaintenance.php?failed=No match found");
						echo "0 results";
						//header("location: itemNotify.php?failed=No match found");
					}
				} else {
					//echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
					//header("location: ../../itemMaintenance.php?failed=Cannot execute Sql");
					echo "sqlfailed";
					//header("location: itemNotify.php?failed=Cannot execute Sql");
				}
			}

			// Close statement
			$stmt->close();
		}
		break;

	case ("countRow"):

		//calculate total row of data
		$stmt = $mysqli->prepare("SELECT COUNT(item_id) FROM items;");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;


	case ("view"):

		//$recordsPerPage= 500;
		//$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

		//$stmt = $mysqli->prepare("SELECT item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10 FROM items order by item_id desc limit 500 OFFSET $offsetValue"); 
		$stmt = $mysqli->prepare("SELECT item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10 FROM items order by item_id desc limit 50");
		$stmt->execute();
		$result = $stmt->get_result();

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$jsonArray[] = $row;
			};
			echo json_encode($jsonArray);
		} else {
			echo "0 results";
			// header("location: ../../itemMaintenance.php?failed=Zero result");
			//header("location: itemNotify.php?failed=Zero result");
		}
		$stmt->close();
		break;

	case ("add"):
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$creation_date = date("Y-m-d");
		$creation_time = date("H:i:s");
		//$creation_user = $_SESSION["username"];
		$creation_user = "admin"; // comment this when submit
		$mode = "Add";

		// find if there are existing item
		$stmtCheck = $mysqli->prepare("SELECT count(1) FROM items WHERE item_no = ?");
		$stmtCheck->bind_param("s", $_POST['item_no']);
		$stmtCheck->execute();
		$stmtCheck->bind_result($found);
		$stmtCheck->fetch();
		if ($found) {

			//echo "item already exist";
			//header("location: ../../itemMaintenance.php?failed=item already exist");
			header("location: itemNotify.php?failed=item already exist");
			$stmtCheck->close();
		} else {

			$stmtCheck->close();
			if (isset($_FILES["imgUpload"]['name'])  && $_FILES["imgUpload"]['name'] != "") {
				// rename image name
				$imgName = $_FILES["imgUpload"]["name"];
				$imgName = $creation_date . time() . rand(100000, 999999) . strtolower($imgName);
				$target_dir = "itemUpload/";
				$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);

				// Select file type
				$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

				// Valid file extensions
				$extensions_arr = array("jpg", "jpeg", "png");

				// Check extension
				if (in_array($imageFileType, $extensions_arr)) {

					//query insert data into items table
					// have 34 field
					$stmt = $mysqli->prepare("INSERT INTO items (item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("sissssssssiiiiiiisssssssssssssssss", $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $imgName, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $creation_date,  $creation_time,  $creation_user);

					$stmt->execute();
					$stmt->close();

					// Upload image into upload folder
					move_uploaded_file($_FILES['imgUpload']['tmp_name'], $target_dir . $imgName);

					// query to store information into itemlog table
					//have 35 field
					$stmtlog = $mysqli->prepare("INSERT INTO itemlog (mode, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$stmtlog->bind_param("ssissssssssiiiiiiisssssssssssssssss", $mode, $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $imgName, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $creation_date,  $creation_time, $creation_user);

					$stmtlog->execute();
					$stmtlog->close();

					//echo "Success";
					header("location: ../../itemMaintenance.php?success=item added");
					//header("location: itemNotify.php?success=item added");
				} else {
					//echo "Your image must in format 'jpg', 'jpeg' or 'png' ";
					header("location: ../../itemMaintenance.php?failed=wrong image format");
					//header("location: itemNotify.php?failed=wrong image format");
				}
			} else {		// else for checking present of file

				//query insert data into items table without upload pic
				//have 34 field
				$itemImage = "";
				$stmt = $mysqli->prepare("INSERT INTO items (item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sissssssssiiiiiiisssssssssssssssss", $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $imgName, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $creation_date,  $creation_time,  $creation_user);

				$stmt->execute();
				$stmt->close();

				// query to store information into itemlog table
				$stmtlog = $mysqli->prepare("INSERT INTO itemlog (mode, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmtlog->bind_param("ssissssssssiiiiiiisssssssssssssssss", $mode, $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $imgName, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $creation_date,  $creation_time, $creation_user);

				$stmtlog->execute();
				$stmtlog->close();

				//echo"success";
				header("location: ../../itemMaintenance.php?success=item added");
				//header("location: itemNotify.php?success=item added");
			}
		}

		break;

	case ("update"):
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$modify_date = date("Y-m-d");
		$modify_time = date("H:i:s");
		//$modify_user = $_SESSION["username"];
		$modify_user = "admin"; // comment this when submit
		$mode = "Update";

		// find if there are existing item
		/*$stmtCheck = $mysqli->prepare("SELECT count(1) FROM items WHERE item_no = ?");
		$stmtCheck->bind_param("s", $_POST['item_no']);
		$stmtCheck->execute();
		$stmtCheck->bind_result($found);
		$stmtCheck->fetch();
		if ($found)
		{
	    	echo "Item already exist";
	    	//header("location: ../../itemMaintenance.php?failed=item already exist");
	    	$stmtCheck->close();

	    }else{
	    	$stmtCheck->close();*/

		if (isset($_FILES["imgUpload"]['name']) && $_FILES["imgUpload"]['name'] != "") {

			$stmt = $mysqli->prepare("SELECT item_picture, creation_date, creation_time, creation_user FROM items WHERE item_id = ?");
			$stmt->bind_param("i", $_POST["item_id"]);
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
					$target_dir = "itemUpload/";
					$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);

					// Select file type
					$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

					// Valid file extensions
					$extensions_arr = array("jpg", "jpeg", "png");

					if (in_array($imageFileType, $extensions_arr)) {

						//update data into items table 
						//have 35 field
						$stmt = $mysqli->prepare("UPDATE items SET item_no = ?, doc_key = ?, description = ?, description2 = ?, description3 = ?, master_vendor = ?, vendor_item = ?, item_type = ?, category = ?, item_group = ?, unit_cost = ?, selling_price1 = ?, qty_hand = ?, qty_hold = ?, qty_available = ?, qty_reorder_available = ?, qty_max = ?, vendor = ?, vendor_company = ?, item_picture = ?, plu = ?, info1 = ?, info2 = ?, info3 = ?, info4 = ?, info5 = ?, info6 = ?, info7 = ?, info8 = ?, info9 = ?, info10 = ?, modified_date = ?, modified_time = ?, modified_user = ? wHERE item_id = ?");
						$stmt->bind_param("sissssssssiiiiiiisssssssssssssssssi", $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $imgName, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $modify_date,  $modify_time,  $modify_user, $_POST['item_id']);
						$stmt->execute();
						$stmt->close();

						// query to insert update log to itemlog table
						$stmtlog = $mysqli->prepare("INSERT INTO itemlog ( mode, item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$stmtlog->bind_param("sisissssssssiiiiiiissssssssssssssssssss", $mode, $_POST['item_id'], $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $imgName, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $creation_date, $creation_time, $creation_user, $modify_date,  $modify_time, $modify_user);

						$stmtlog->execute();
						$stmtlog->close();

						// Upload image into upload folder
						move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_dir . $imgName);

						//echo "update success";
						header("location: ../../itemMaintenance.php?success=item edited");
						//header("location: itemNotify.php?success=item edited");
					} else {
						//echo "wrong format";
						header("location: ../../itemMaintenance.php?failed=wrong image format");
						//header("location: itemNotify.php?failed=wrong image format");
					}
				} else {

					// remove image in folder
					unlink("itemUpload/" . $previous_img);

					// rename image name
					$imgName = $_FILES["imgUpload"]["name"];
					$imgName = $modify_date . time() . rand(100000, 999999) . strtolower($imgName);
					$target_dir = "itemUpload/";
					$target_file = $target_dir . basename($_FILES["imgUpload"]["name"]);

					// Select file type
					$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

					// Valid file extensions
					$extensions_arr = array("jpg", "jpeg", "png");

					if (in_array($imageFileType, $extensions_arr)) {

						//update data into items table
						$stmt = $mysqli->prepare("UPDATE items SET item_no = ?, doc_key = ?, description = ?, description2 = ?, description3 = ?, master_vendor = ?, vendor_item = ?, item_type = ?, category = ?, item_group = ?, unit_cost = ?, selling_price1 = ?, qty_hand = ?, qty_hold = ?, qty_available = ?, qty_reorder_available = ?, qty_max = ?, vendor = ?, vendor_company = ?, item_picture = ?, plu = ?, info1 = ?, info2 = ?, info3 = ?, info4 = ?, info5 = ?, info6 = ?, info7 = ?, info8 = ?, info9 = ?, info10 = ?, modified_date = ?, modified_time = ?, modified_user = ? wHERE item_id = ?");
						$stmt->bind_param("sissssssssiiiiiiisssssssssssssssssi", $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $imgName, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $modify_date,  $modify_time,  $modify_user, $_POST['item_id']);
						$stmt->execute();
						$stmt->close();

						// query to insert update log to itemlog table
						$stmtlog = $mysqli->prepare("INSERT INTO itemlog ( mode, item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
						$stmtlog->bind_param("sisissssssssiiiiiiissssssssssssssssssss", $mode, $_POST['item_id'], $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $imgName, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $creation_date, $creation_time, $creation_user, $modify_date,  $modify_time, $modify_user);

						$stmtlog->execute();
						$stmtlog->close();

						// Upload image into upload folder
						move_uploaded_file($_FILES["imgUpload"]["tmp_name"], $target_dir . $imgName);

						//echo"success";
						header("location: ../../itemMaintenance.php?success=item edited");
						//header("location: itemNotify.php?success=item edited");
					} else {
						//echo "wrong format";
						header("location: ../../itemMaintenance.php?failed=wrong image format");
						//header("location: itemNotify.php?failed=wrong image format");
					}
				}
			} else {
				//echo "No image data for selectd ID";
				//header("location: ../../itemMaintenance.php?failed=no image found");
				header("location: itemNotify.php?failed=no image found");
			}
		} else {

			$stmt = $mysqli->prepare("UPDATE items SET item_no = ?, doc_key = ?, description = ?, description2 = ?, description3 = ?, master_vendor = ?, vendor_item = ?, item_type = ?, category = ?, item_group = ?, unit_cost = ?, selling_price1 = ?, qty_hand = ?, qty_hold = ?, qty_available = ?, qty_reorder_available = ?, qty_max = ?, vendor = ?, vendor_company = ?, plu = ?, info1 = ?, info2 = ?, info3 = ?, info4 = ?, info5 = ?, info6 = ?, info7 = ?, info8 = ?, info9 = ?, info10 = ?, modified_date = ?, modified_time = ?, modified_user = ? wHERE item_id = ?");
			$stmt->bind_param("sissssssssiiiiiiissssssssssssssssi",  $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $modify_date,  $modify_time,  $modify_user, $_POST['item_id']);
			$stmt->execute();
			$stmt->close();

			//query to fetch selected data from items table

			$stmt = $mysqli->prepare("SELECT item_picture, creation_date, creation_time, creation_user FROM items WHERE item_id = ?");
			$stmt->bind_param("i", $_POST["item_id"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($item_picture, $creation_date, $creation_time, $creation_user);
			$stmt->fetch();
			$stmt->close();

			// query to insert update log to itemlog table
			$stmtlog = $mysqli->prepare("INSERT INTO itemlog ( mode, item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("sisissssssssiiiiiiissssssssssssssssssss", $mode, $_POST['item_id'], $_POST['item_no'], $_POST['doc_key'], $_POST['description'], $_POST['description2'], $_POST['description3'], $_POST['master_vendor'], $_POST['vendor_item'], $_POST['item_type'], $_POST['category'], $_POST['item_group'], $_POST['unit_cost'], $_POST['selling_price1'], $_POST['qty_hand'], $_POST['qty_hold'], $_POST['qty_available'], $_POST['qty_reorder_available'], $_POST['qty_max'], $_POST['vendor'], $_POST['vendor_company'], $item_picture, $_POST['plu'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $creation_date, $creation_time, $creation_user, $modify_date,  $modify_time, $modify_user);

			$stmtlog->execute();
			$stmtlog->close();
			//echo "success";
			header("location: ../../itemMaintenance.php?success=item edited");
			//header("location: itemNotify.php?success=item edited");
		}
		//}
		break;

	case ("delete"):
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$modify_date = date("Y-m-d");
		$modify_time = date("H:i:s");
		//$modify_user = $_SESSION["username"];
		$modify_user = "admin"; // comment this when submit
		$mode = "Delete";

		// query for fetch selected item data from items table

		$stmt = $mysqli->prepare("SELECT item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user FROM items WHERE item_id = ?");
		$stmt->bind_param("i", $_POST['item_id']);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows == 1) {

			// query to get item data based on item_id
			// has 35 field
			$stmt->bind_result($item_no, $doc_key, $description, $description2, $description3, $master_vendor, $vendor_item, $item_type, $category, $item_group, $unit_cost, $selling_price1, $qty_hand, $qty_hold, $qty_available, $qty_reorder_available, $qty_max, $vendor, $vendor_company, $item_picture, $plu, $info1, $info2, $info3, $info4, $info5, $info6, $info7, $info8, $info9, $info10, $creation_date, $creation_time, $creation_user);
			$stmt->fetch();
			$stmt->close();

			print_r($creation_user);

			if ($item_picture != "") {
				// remove image from upload folder
				unlink("itemUpload/" . $item_picture);
			}

			// query to insert update log to itemlog table
			$stmtlog = $mysqli->prepare("INSERT INTO itemlog ( mode, item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("sisissssssssiiiiiiissssssssssssssssssss", $mode, $_POST['item_id'], $item_no, $doc_key, $description, $description2, $description3, $master_vendor, $vendor_item, $item_type, $category, $item_group, $unit_cost, $selling_price1, $qty_hand, $qty_hold, $qty_available, $qty_reorder_available, $qty_max, $vendor, $vendor_company, $item_picture, $plu, $info1, $info2, $info3, $info4, $info5, $info6, $info7, $info8, $info9, $info10, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $modify_user);

			$stmtlog->execute();
			$stmtlog->close();

			// query to delete data from items table

			$stmt = $mysqli->prepare("DELETE FROM items WHERE item_id = ?");
			$stmt->bind_param("i", $_POST["item_id"]);
			$stmt->execute();
			$stmt->close();

			//echo "success delete";
			header("location: ../../itemMaintenance.php?success=item deleted");
			//header("location: itemNotify.php?success=item deleted");
		} else {
			//echo "id not found";
			header("location: ../../itemMaintenance.php?failed=id no found");
			//header("location: itemNotify.php?failed=id no found");
		}
		break;
}

mysqli_close($mysqli);
