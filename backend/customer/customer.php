<?php

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
			//$_POST['pageNum'] = 1;

			// Prepare a select statement
			$recordsPerPage= 20;
	 		$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

	 		$stmt = $mysqli->prepare("SELECT customer_id, customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, gender, dob, race, religion, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, control_ac, accounting_account FROM customers WHERE customer_account REGEXP ? OR name REGEXP ?");
	 		$stmt->bind_param("ss", $_POST["search"], $_POST["search"]);

	 		$stmt->execute();
	 		$result = $stmt->get_result();
	 		// Check number of rows in the result set
			if ($result->num_rows > 0) {
				// Fetch result rows as an associative array
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$jsonArray[] = $row;
				}
					echo json_encode($jsonArray);
			} else {
                    echo "No result";
			}
			$stmt->close();
		}
		break;

	case ("countRow"):

		//calculate total row of data
		$stmt = $mysqli->prepare("SELECT COUNT(customer_id) FROM customers;");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;

	case ("searchRowCount"):

		if (isset($_POST["search"])) {
			$stmt = $mysqli->prepare("SELECT COUNT(customer_id) FROM customers WHERE customer_account REGEXP ? OR name REGEXP ? ");
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("ss", $_POST["search"], $_POST["search"]);
				
			$stmt->execute();
			$row = $stmt->get_result()->fetch_row();
			$rowTotal = $row[0];
			echo json_encode($rowTotal);
			$stmt->close();
		}
		break;


	case ("view"):
		//$_POST['pageNum'] = 1;

	 	$recordsPerPage= 20;
	 	$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT customer_id, customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, gender, dob, race, religion, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, control_ac, accounting_account FROM customers order by customer_id desc limit $recordsPerPage OFFSET $offsetValue"); 
		
		$stmt->execute();
		$result = $stmt->get_result();

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$jsonArray[] = $row;
			};
			$_SESSION["currPageCust"] = $_POST['pageNum'];
			echo json_encode($jsonArray);
           
		} else {
			echo "No Result";
		}
		$stmt->close();
		break;

	case ("add"):

		// check isset for all post variable
		$countSetAdd = 0;
		$postVariable = array('customer_account', 'name', 'reg_num', 'outstanding', 'points', 'status', 'address', 'postcode', 'state', 'salutation', 'email', 'website', 'biz_nature', 'salesperson', 'category', 'city', 'country', 'attention', 'introducer', 'reg_date', 'expiry_date', 'telephone1', 'telephone2', 'fax', 'handphone', 'skype', 'nric', 'gender', 'dob', 'race', 'religion', 'info1', 'info2', 'info3', 'info4', 'info5', 'info6', 'info7', 'info8', 'info9', 'info10', 'control_ac', 'accounting_account');

		foreach ($postVariable as $variable_name) {
			if(isset($_POST[$variable_name])){
				$countSetAdd++;
			}else{
				$countSetAdd--;
				//echo $variable_name. "not set<br>";
			}
		}

		// if all post variable is set, insert data into database
		if($countSetAdd == count($postVariable)){
			
			date_default_timezone_set("Asia/Kuala_Lumpur");
			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			$creation_user = $_SESSION["username"];
			//$creation_user = "admin"; // comment this when submit
			$mode = "Add";

			// find if there are existing item
			$stmtCheck = $mysqli->prepare("SELECT count(1) FROM customers WHERE customer_account = ?");
			$stmtCheck->bind_param("s", $_POST['customer_account']);
			$stmtCheck->execute();
			$stmtCheck->bind_result($found);
			$stmtCheck->fetch();
			if ($found) {

				//echo "item already exist";
				header("location: ../../customerMaintenance.php?failed=item already exist");
				$stmtCheck->close();
			} else {

				$stmtCheck->close();

				//query insert data into customers table

				$stmt = $mysqli->prepare("INSERT INTO customers (customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, gender, dob, race, religion, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, control_ac, accounting_account, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssiisssssssssssssssssssssssssssssssssssssssss", $_POST['customer_account'], $_POST['name'], $_POST['reg_num'], $_POST['outstanding'], $_POST['points'], $_POST['status'], $_POST['address'], $_POST['postcode'], $_POST['state'], $_POST['salutation'], $_POST['email'], $_POST['website'], $_POST['biz_nature'], $_POST['salesperson'], $_POST['category'], $_POST['city'], $_POST['country'], $_POST['attention'], $_POST['introducer'], $_POST['reg_date'], $_POST['expiry_date'], $_POST['telephone1'], $_POST['telephone2'], $_POST['fax'], $_POST['handphone'], $_POST['skype'], $_POST['nric'], $_POST['gender'], $_POST['dob'], $_POST['race'], $_POST['religion'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $_POST['control_ac'], $_POST['accounting_account'], $creation_date, $creation_time, $creation_user);

				$stmt->execute();
				$stmt->close();

				// query to store information into itemlog table
				$stmtlog = $mysqli->prepare("INSERT INTO customerlog (mode, customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, gender, dob, race, religion, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, control_ac, accounting_account, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmtlog->bind_param("ssssiisssssssssssssssssssssssssssssssssssssssss", $mode, $_POST['customer_account'], $_POST['name'], $_POST['reg_num'], $_POST['outstanding'], $_POST['points'], $_POST['status'], $_POST['address'], $_POST['postcode'], $_POST['state'], $_POST['salutation'], $_POST['email'], $_POST['website'], $_POST['biz_nature'], $_POST['salesperson'], $_POST['category'], $_POST['city'], $_POST['country'], $_POST['attention'], $_POST['introducer'], $_POST['reg_date'], $_POST['expiry_date'], $_POST['telephone1'], $_POST['telephone2'], $_POST['fax'], $_POST['handphone'], $_POST['skype'], $_POST['nric'], $_POST['gender'], $_POST['dob'], $_POST['race'], $_POST['religion'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $_POST['control_ac'], $_POST['accounting_account'], $creation_date, $creation_time, $creation_user);

				$stmtlog->execute();
				$stmtlog->close();

				//echo"success add";
				header("location: ../../customerMaintenance.php?success=item added");
			} 

		}else{
			echo "Some input field is not set.";
		}
		break;

	case ("update"):

		// check isset for all post variable
		$countSetUpdate = 0;
		$postVariable = array('customer_id', 'customer_account', 'name', 'reg_num', 'outstanding', 'points', 'status', 'address', 'postcode', 'state', 'salutation', 'email', 'website', 'biz_nature', 'salesperson', 'category', 'city', 'country', 'attention', 'introducer', 'reg_date', 'expiry_date', 'telephone1', 'telephone2', 'fax', 'handphone', 'skype', 'nric', 'gender', 'dob', 'race', 'religion', 'info1', 'info2', 'info3', 'info4', 'info5', 'info6', 'info7', 'info8', 'info9', 'info10', 'control_ac', 'accounting_account');

		foreach ($postVariable as $variable_name) {
			if(isset($_POST[$variable_name])){
				$countSetUpdate++;
			}else{
				$countSetUpdate--;
			}
		}

		// if all post variable is set, update data into database
		if($countSetUpdate == count($postVariable)){

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin"; // comment this when submit
			$mode = "Update";

			$stmt = $mysqli->prepare("UPDATE customers SET customer_account = ?, name = ?, reg_num = ?, outstanding = ?, points = ?, status = ?, address = ?, postcode = ?, state = ?, salutation = ?, email = ?, website = ?, biz_nature = ?, salesperson = ?, category = ?, city = ?, country = ?, attention = ?, introducer = ?, reg_date = ?, expiry_date = ?, telephone1 = ?, telephone2 = ?, fax = ?, handphone = ?, skype = ?, nric = ?, gender = ?, dob = ?, race = ?, religion = ?, info1 = ?, info2 = ?, info3 = ?, info4 = ?, info5 = ?, info6 = ?, info7 = ?, info8 = ?, info9 = ?, info10 = ?, control_ac = ?, accounting_account = ?, modified_date = ?, modified_time = ?, modified_user = ? wHERE customer_id = ?");
			$stmt->bind_param("sssiisssssssssssssssssssssssssssssssssssssssssi", $_POST['customer_account'], $_POST['name'], $_POST['reg_num'], $_POST['outstanding'], $_POST['points'], $_POST['status'], $_POST['address'], $_POST['postcode'], $_POST['state'], $_POST['salutation'], $_POST['email'], $_POST['website'], $_POST['biz_nature'], $_POST['salesperson'], $_POST['category'], $_POST['city'], $_POST['country'], $_POST['attention'], $_POST['introducer'], $_POST['reg_date'], $_POST['expiry_date'], $_POST['telephone1'], $_POST['telephone2'], $_POST['fax'], $_POST['handphone'], $_POST['skype'], $_POST['nric'], $_POST['gender'], $_POST['dob'], $_POST['race'], $_POST['religion'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $_POST['control_ac'], $_POST['accounting_account'], $modify_date,  $modify_time,  $modify_user, $_POST['customer_id']);
			$stmt->execute();
			$stmt->close();

			//query to fetch selected data from customer table

			$stmt = $mysqli->prepare("SELECT creation_date, creation_time, creation_user FROM customers WHERE customer_id = ?");
			$stmt->bind_param("i", $_POST["customer_id"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($creation_date, $creation_time, $creation_user);
			$stmt->fetch();
			$stmt->close();

			// query to insert update log to customerlog table
			$stmtlog = $mysqli->prepare("INSERT INTO customerlog ( mode, customer_id, customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, gender, dob, race, religion, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, control_ac, accounting_account, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("sisssiissssssssssssssssssssssssssssssssssssssssssss", $mode, $_POST['customer_id'], $_POST['customer_account'], $_POST['name'], $_POST['reg_num'], $_POST['outstanding'], $_POST['points'], $_POST['status'], $_POST['address'], $_POST['postcode'], $_POST['state'], $_POST['salutation'], $_POST['email'], $_POST['website'], $_POST['biz_nature'], $_POST['salesperson'], $_POST['category'], $_POST['city'], $_POST['country'], $_POST['attention'], $_POST['introducer'], $_POST['reg_date'], $_POST['expiry_date'], $_POST['telephone1'], $_POST['telephone2'], $_POST['fax'], $_POST['handphone'], $_POST['skype'], $_POST['nric'], $_POST['gender'], $_POST['dob'], $_POST['race'], $_POST['religion'], $_POST['info1'], $_POST['info2'], $_POST['info3'], $_POST['info4'], $_POST['info5'], $_POST['info6'], $_POST['info7'], $_POST['info8'], $_POST['info9'], $_POST['info10'], $_POST['control_ac'], $_POST['accounting_account'], $creation_date, $creation_time, $creation_user, $modify_date,  $modify_time, $modify_user);

			$stmtlog->execute();
			$stmtlog->close();
			//echo "success edit";
			header("location: ../../customerMaintenance.php?success=item edited");

		}else{
			echo "Some input field is not set.";
		}
		break;

	case ("delete"):

		if (isset($_POST["customer_id"])) {

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin"; // comment this when submit
			$mode = "Delete";

			// query for fetch selected item data from customers table

			$stmt = $mysqli->prepare("SELECT customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, gender, dob, race, religion, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, control_ac, accounting_account, creation_date, creation_time, creation_user FROM customers WHERE customer_id = ?");
			$stmt->bind_param("i", $_POST['customer_id']);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows == 1) {

				// query to get item data based on customer_id
				$stmt->bind_result($customer_account, $name, $reg_num, $outstanding, $points, $status, $address, $postcode, $state, $salutation, $email, $website, $biz_nature, $salesperson, $category, $city, $country, $attention, $introducer, $reg_date, $expiry_date, $telephone1, $telephone2, $fax, $handphone, $skype, $nric, $gender, $dob, $race, $religion, $info1, $info2, $info3, $info4, $info5, $info6, $info7, $info8, $info9, $info10, $control_ac, $accounting_account, $creation_date, $creation_time, $creation_use);
				$stmt->fetch();
				$stmt->close();

				// query to insert update log to customerlog table
				$stmtlog = $mysqli->prepare("INSERT INTO customerlog ( mode, customer_id, customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, gender, dob, race, religion, info1, info2, info3, info4, info5, info6, info7, info8, info9, info10, control_ac, accounting_account, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmtlog->bind_param("sisssiissssssssssssssssssssssssssssssssssssssssssss", $mode, $_POST['customer_id'], $customer_account, $name, $reg_num, $outstanding, $points, $status, $address, $postcode, $state, $salutation, $email, $website, $biz_nature, $salesperson, $category, $city, $country, $attention, $introducer, $reg_date, $expiry_date, $telephone1, $telephone2, $fax, $handphone, $skype, $nric, $gender, $dob, $race, $religion, $info1, $info2, $info3, $info4, $info5, $info6, $info7, $info8, $info9, $info10, $control_ac, $accounting_account, $creation_date, $creation_time, $creation_use, $modify_date, $modify_time, $modify_user);

				$stmtlog->execute();
				$stmtlog->close();

				// query to delete data from items table

				$stmt = $mysqli->prepare("DELETE FROM customers WHERE customer_id = ?");
				$stmt->bind_param("i", $_POST["customer_id"]);
				$stmt->execute();
				$stmt->close();

				//echo "success delete";
				header("location: ../../customerMaintenance.php?success=item deleted");
			} else {
				//echo "id not found";
				header("location: ../../customerMaintenance.php?failed=id no found");
			}
		}else{
			echo "Some input field is not set.";
		}
		break;
}

mysqli_close($mysqli);
