<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

switch ($postType) {
	case ("searchRow"):

		if (isset($_POST["search"])) {
			//$_POST['pageNum'] = 1; // comment when commit

			// Prepare a select statement
			$recordsPerPage = 20;
			$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

			$stmt = $mysqli->prepare("SELECT id, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status FROM sale_header WHERE sale_id REGEXP ? OR customer_account REGEXP ? AND isOnHold = 0");
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
		$stmt = $mysqli->prepare("SELECT COUNT(id) FROM sale_header WHERE isOnHold = 0;");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;

	case ("searchRowCount"):

		if (isset($_POST["search"])) {
			$stmt = $mysqli->prepare("SELECT COUNT(id) FROM sale_header WHERE sale_id REGEXP ? OR customer_account REGEXP ? AND isOnHold = 0");
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("ss", $_POST["search"], $_POST["search"]);
			$stmt->execute();
			$row = $stmt->get_result()->fetch_row();
			$rowTotal = $row[0];
			echo json_encode($rowTotal);
			$stmt->close();
		}
		break;

	case ("viewSaleHeader"):
		//$_POST['pageNum'] = 1;// comment this after commit

		$recordsPerPage = 20;
		$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT id, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold, creation_time FROM sale_header WHERE isOnHold = 0 ORDER BY id desc limit $recordsPerPage OFFSET $offsetValue");
		$stmt->execute();
		$result = $stmt->get_result();

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$jsonArray[] = $row;
			};
			echo json_encode($jsonArray);
		} else {
			echo "No Result";
		}
		$stmt->close();
		break;

	// //Find the latest added sale order
	// case("findLatestSaleOrder"):
	// 	// SELECT * FROM sale_header ORDER BY id DESC LIMIT 1;

	// 	$stmt = $mysqli->prepare("SELECT sale_id, customer_name FROM sale_header WHERE isOnHold = 0 ORDER BY id DESC LIMIT 1");
	// 	$stmt->execute();
	// 	$result = $stmt->get_result();

	// 	if (mysqli_num_rows($result) > 0) {
	// 		while ($row = mysqli_fetch_assoc($result)) {
	// 			$jsonArray[] = $row;
	// 		};
	// 		echo json_encode($jsonArray);
	// 	} else {
	// 		echo "No Result";
	// 	}
	// 	$stmt->close();
	// 	break;
	
	case ("viewDetail"):

		if (isset($_POST["search"])) {
			$stmt = $mysqli->prepare("SELECT sale_detail_id, item_id, item_no, description, uom, qty, price, discount, amount FROM sale_detail WHERE sale_id_header = ? ORDER BY sale_detail_id asc");
			$stmt->bind_param("s", $_POST["search"]);
			$stmt->execute();
			$result = $stmt->get_result();

			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$jsonArray[] = $row;
				};
				echo json_encode($jsonArray);
			} else {
				echo "No Result";
			}
			$stmt->close();
		}
		break;

	case ("add"):

		// check isset for all post variable
		$countSetAdd = 0;
		$postVariable = array(
			'sale_salesperson', 'sale_subtotal', 'sale_discount_header', 'sale_total_amount',
			'item_id', 'item_no', 'description', 'uom', 'qty', 'price', 'discount', 'amount',
			'payment_method', 'sale_amount', 'sale_payment'
		);

		foreach ($postVariable as $variable_name) {
			if (isset($_POST[$variable_name])) {
				$countSetAdd++;
			} else {
				$countSetAdd--;
				//echo $variable_name. "not set<br>";
			}
		}

		// if all post variable is set, insert data into database
		if ($countSetAdd == count($postVariable)) {

			//assign array data into variable
			$item_id = $_POST['item_id'];
			$item_no = $_POST['item_no'];
			$description = $_POST['description'];
			$uom = $_POST['uom'];
			$qty = $_POST['qty'];
			$price = $_POST['price'];
			$discount = $_POST['discount'];
			$amount = $_POST['amount'];

			$sale_salesperson = $_POST['sale_salesperson'];
			$sale_subtotal = $_POST['sale_subtotal'];
			$sale_discount_header = $_POST['sale_discount_header'];
			$sale_total_amount = $_POST['sale_total_amount'];

			$payment_method = $_POST['payment_method'];
			$sale_amount = $_POST['sale_amount'];
			$sale_payment = $_POST['sale_payment'];
			$reference = $_POST["reference"] != "" ? $_POST["reference"] : "";

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$sale_payment_date = date("Y-m-d");
			$sale_payment_time = date("H:i:s");
			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			$date_id = date("Ymd");
			$time_id = date("His");
			$creation_user = $_SESSION["username"];
			//$creation_user = "admin"; // comment this when submit
			$mode = "Add";

			$itemCount = count($item_no);

			// create sale id 
			$sale_id = "SO" . $date_id . $time_id;
			// create variable for rest of the table
			$sale_date = date("Y-m-d");
			$customer_account = "CASH";
			$customer_name = "CASH";
			$sale_phone_num = " ";
			$payment_status = "Paid";
			$isOnHold = 0;

			//query insert data into sale_header table - 14 field
			$stmt = $mysqli->prepare("INSERT INTO sale_header (sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnhold, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssdddsisss", $sale_id, $customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $isOnHold, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			// query to store item data into sale_detail table - 12 field
			$stmt = $mysqli->prepare("INSERT INTO sale_detail (sale_id_header, item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for ($i = 0; $i < $itemCount; $i++) {
				$stmt->bind_param("sisssidddsss", $sale_id, $item_id[$i], $item_no[$i], $description[$i], $uom[$i], $qty[$i], $price[$i], $discount[$i], $amount[$i], $creation_date, $creation_time, $creation_user);
				$stmt->execute();
			}
			$stmt->close();

			//query insert data into sale_payment table - 11 field
			$stmt = $mysqli->prepare("INSERT INTO sale_payment (sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssddssss", $sale_id, $sale_payment_date, $sale_payment_time, $payment_method, $customer_name, $sale_amount, $sale_payment, $reference, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			//update query for item tabel - 2 fields (item deduction)
			for ($y = 0; $y < $itemCount; $y++) {
				//fetch item quantity from item table
				$stmt = $mysqli->prepare("SELECT qty_available FROM items WHERE item_id = ?");
				$stmt->bind_param("i", $item_id[$y]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($qty_available);
				$stmt->fetch();
				$stmt->close();

				$new_qty = (int) $qty_available - (int) $qty[$y];

				$stmt = $mysqli->prepare("UPDATE items SET qty_available = ? WHERE item_id = ?");
				$stmt->bind_param("ii", $new_qty, $item_id[$y]);
				$stmt->execute();
				$stmt->close();
			}

			//query insert data into sale_header_log table - 15 field
			$stmt = $mysqli->prepare("INSERT INTO sale_header_log ( mode, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssdddsisss", $mode, $sale_id, $customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $isOnHold, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			// query to store item data into sale_detail_log table - 13 field
			$stmtlog = $mysqli->prepare("INSERT INTO sale_detail_log ( mode, sale_id_header, item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for ($i = 0; $i < $itemCount; $i++) {
				$stmtlog->bind_param("ssisssidddsss", $mode, $sale_id, $item_id[$i], $item_no[$i], $description[$i], $uom[$i], $qty[$i], $price[$i], $discount[$i], $amount[$i], $creation_date, $creation_time, $creation_user);
				$stmtlog->execute();
			}
			$stmtlog->close();

			//query insert data into sale_payment_log table - 12 field
			$stmt = $mysqli->prepare("INSERT INTO sale_payment_log (mode, sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssddssss", $mode, $sale_id, $sale_payment_date, $sale_payment_time, $payment_method, $customer_name, $sale_amount, $sale_payment, $reference, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			echo "success add";
		} else {
			echo $countSetAdd .  count($postVariable);
			//echo "Some input field is not set.";
		}
		break;

	case ("update"):

		// check isset for all post variable
		$countSetUpdate = 0;
		$postVariable = array(
			'sale_id', 'customer_account', 'customer_name', 'sale_salesperson', 'sale_subtotal', 'sale_discount_header', 'sale_total_amount',
			'item_id', 'item_no', 'description', 'uom', 'qty', 'price', 'discount', 'amount', 
			"reference",'payment_method', 'sale_amount', 'sale_payment'
		);

		foreach ($postVariable as $variable_name) {
			if (isset($_POST[$variable_name])) {
				$countSetUpdate++;
			} else {
				$countSetUpdate--;
				//print_r($_POST[$variable_name]);
			}
		}

		// if all post variable is set, update data into database
		if ($countSetUpdate == count($postVariable)) {

			//assign array data into variable
			$item_id = $_POST['item_id'];
			$item_no = $_POST['item_no'];
			$description = $_POST['description'];
			$uom = $_POST['uom'];
			$qty = $_POST['qty'];
			$price = $_POST['price'];
			$discount = $_POST['discount'];
			$amount = $_POST['amount'];

			$customer_account = $_POST['customer_account'];
			$customer_name = $_POST['customer_name'];
			$sale_salesperson = $_POST['sale_salesperson'];
			$sale_subtotal = $_POST['sale_subtotal'];
			$sale_discount_header = $_POST['sale_discount_header'];
			$sale_total_amount = $_POST['sale_total_amount'];

			$payment_method = $_POST['payment_method'];
			$sale_amount = $_POST['sale_amount'];
			$sale_payment = $_POST['sale_payment'];
			$reference = $_POST["reference"] != "" ? $_POST["reference"] : "";

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			$creation_user = $_SESSION["username"];
			// $modify_user = "admin";
			// $creation_user = "admin"; // comment this when submit
			$mode = "Update";

			//new updated sale date
			$sale_date = date("Y-m-d");

			$itemCount = count($item_no);

			//update query for sale_header tabel - 10 fields
			$stmt = $mysqli->prepare("UPDATE sale_header SET customer_account = ?, customer_name = ?, sale_date = ?, sale_salesperson = ?, sale_subtotal = ?, sale_discount_header = ?, sale_total_amount = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE sale_id = ?");
			$stmt->bind_param("ssssdddssss", $customer_account, $customer_name, $sale_date, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $modify_date, $modify_time, $modify_user, $_POST['sale_id']);
			$stmt->execute();
			$stmt->close();

			// query to reset back qty_available on item table
			// fetch item info from sale_detail table
            $stmt = $mysqli->prepare("SELECT item_id, qty FROM sale_detail WHERE sale_id_header = ?");
            $stmt->bind_param("s", $_POST['sale_id']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($old_item_id, $old_qty);
                while ($stmt->fetch()) {
                    $itemOldArray[] = ['old_item_id' => $old_item_id, 'old_qty' => $old_qty];
                }
                $countOldArray = count($itemOldArray);
                $stmt->close();

            } else {
                echo "item detail not found";
				die;
            }

			for ($x = 0; $x < $countOldArray; $x++) {
				//fetch item quantity from item table
				$stmt = $mysqli->prepare("SELECT qty_available FROM items WHERE item_id = ?");
				$stmt->bind_param("i", $itemOldArray[$x]["old_item_id"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($qty_available);
				$stmt->fetch();
				$stmt->close();

				$reset_qty = (int) $qty_available + (int) $itemOldArray[$x]["old_qty"];


				$stmt = $mysqli->prepare("UPDATE items SET qty_available = ? WHERE item_id = ?");
				$stmt->bind_param("ii", $reset_qty, $itemOldArray[$x]["old_item_id"]);
				$stmt->execute();
				$stmt->close();

			}

			//query to delete old sale_detail for specific sale_id
			$stmt = $mysqli->prepare("DELETE FROM sale_detail WHERE sale_id_header = ?");
			$stmt->bind_param("s", $_POST["sale_id"]);
			$stmt->execute();
			$stmt->close();

			//query update data into sale_payment table - 8 field
			$stmt = $mysqli->prepare("UPDATE sale_payment SET payment_method = ?, sale_amount = ?, sale_payment = ?, reference = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE sale_id_header = ?");
			$stmt->bind_param("sddsssss", $payment_method, $sale_amount, $sale_payment, $reference, $modify_date, $modify_time, $modify_user, $_POST['sale_id']);
			$stmt->execute();
			$stmt->close();

			//query to fetch data from sale_header table
			$stmt = $mysqli->prepare("SELECT sale_phone_num, payment_status, isOnHold, creation_date, creation_time, creation_user FROM sale_header WHERE sale_id = ?");
			$stmt->bind_param("s", $_POST["sale_id"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($sale_phone_num, $payment_status, $isOnHold, $header_creation_date, $header_creation_time, $header_creation_user);
			$stmt->fetch();
			$stmt->close();

			//query insert data into sale_header_log table - 18 field
			$stmt = $mysqli->prepare("INSERT INTO sale_header_log ( mode, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssdddssssssss", $mode, $_POST["sale_id"], $customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $isOnHold, $header_creation_date, $header_creation_time, $header_creation_user, $modify_date, $modify_time, $modify_user);
			$stmt->execute();
			$stmt->close();

			//fetch sale_payment data
			$stmt = $mysqli->prepare("SELECT sale_payment_date, sale_payment_time, creation_date, creation_time, creation_user FROM sale_payment WHERE sale_id_header = ?");
			$stmt->bind_param("s", $_POST["sale_id"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($sale_payment_date, $sale_payment_time, $sale_creation_date, $sale_creation_time, $sale_creation_user);
			$stmt->fetch();
			$stmt->close();

			//query insert data into sale_payment_log table - 15 field
			$stmt = $mysqli->prepare("INSERT INTO sale_payment_log (mode, sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssddsssssss", $mode, $_POST["sale_id"], $sale_payment_date, $sale_payment_time, $payment_method, $customer_name, $sale_amount, $sale_payment, $reference, $sale_creation_date, $sale_creation_time, $sale_creation_user, $modify_date, $modify_time, $modify_user);
			$stmt->execute();
			$stmt->close();

			//update query for item tabel - 2 fields (item deduction)
			for ($y = 0; $y < $itemCount; $y++) {
				//fetch item quantity from database
				$stmt = $mysqli->prepare("SELECT qty_available FROM items WHERE item_id = ?");
				$stmt->bind_param("i", $item_id[$y]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($old_qty_available);
				$stmt->fetch();
				$stmt->close();

				$new_deduct_qty = (int) $old_qty_available - (int) $qty[$y];

				$stmt = $mysqli->prepare("UPDATE items SET qty_available = ? WHERE item_id = ?");
				$stmt->bind_param("ii", $new_deduct_qty, $item_id[$y]);
				$stmt->execute();
				$stmt->close();
			}

			// query to store item data into sale_detail table - 12 field
			$stmt = $mysqli->prepare("INSERT INTO sale_detail ( sale_id_header, item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user) VALUE (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for ( $z = 0; $z < $itemCount; $z++){
				$stmt->bind_param("sisssidddsss", $_POST["sale_id"], $item_id[$z], $item_no[$z], $description[$z], $uom[$z], $qty[$z], $price[$z], $discount[$z], $amount[$z], $creation_date, $creation_time, $creation_user);
				$stmt->execute();
			}
			$stmt->close();

			// query to store item data into sale_detail_log table - 16 field
			$stmtlog = $mysqli->prepare("INSERT INTO sale_detail_log ( mode, sale_id_header, item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for ($i = 0; $i < $itemCount; $i++) {
				$stmtlog->bind_param("ssisssidddssssss", $mode, $_POST["sale_id"], $item_id[$i], $item_no[$i], $description[$i], $uom[$i], $qty[$i], $price[$i], $discount[$i], $amount[$i], $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $modify_user);
				$stmtlog->execute();
			}
			$stmtlog->close();

			echo "success edit";
		} else {
			echo "Some input field is not set.";
		}
		break;

	// case ("deleteHeader"):

	// 	if (isset($_POST["sale_id"])) {

	// 		date_default_timezone_set("Asia/Kuala_Lumpur");
	// 		$modify_date = date("Y-m-d");
	// 		$modify_time = date("H:i:s");
	// 		$modify_user = $_SESSION["username"];
	// 		//$modify_user = "admin"; // comment this when submit
	// 		$mode = "Delete";

	// 		// query for fetch selected sale data from sale_detail table - 11 fields
	// 		$stmt = $mysqli->prepare("SELECT item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user FROM sale_detail WHERE sale_id_header = ?");
	// 		$stmt->bind_param("s", $_POST['sale_id']);
	// 		$stmt->execute();
	// 		$stmt->store_result();
	// 		if ($stmt->num_rows > 0) {
	// 			$stmt->bind_result($item_id, $item_no, $description, $uom, $qty, $price, $discount, $amount, $creation_date, $creation_time, $creation_user);
	// 			while ($stmt->fetch()) {
	// 				$itemArr[] = ['item_id' => $item_id, 'item_no' => $item_no, 'description' => $description, 'uom' => $uom, 'qty' => $qty, 'price' => $price, 'discount' => $discount, 'amount' => $amount, 'creation_date' => $creation_date, 'creation_time' => $creation_time, 'creation_user' => $creation_user];
	// 			}
	// 			$stmt->close();

	// 			$countArray = count($itemArr);

	// 			// query to store item detail data into sale_detail_log table - 16 field
	// 			$stmtlog = $mysqli->prepare("INSERT INTO sale_detail_log ( mode, sale_id_header, item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	// 			for ($y = 0; $y < $countArray; $y++) {
	// 				$stmtlog->bind_param("ssisssidddssssss", $mode, $_POST['sale_id'], $itemArr[$y]["item_id"], $itemArr[$y]["item_no"], $itemArr[$y]["description"], $itemArr[$y]["uom"], $itemArr[$y]["qty"], $itemArr[$y]["price"], $itemArr[$y]["discount"], $itemArr[$y]["amount"], $itemArr[$y]["creation_date"], $itemArr[$y]["creation_time"], $itemArr[$y]["creation_user"], $modify_date, $modify_time, $modify_user);
	// 				$stmtlog->execute();
	// 			}
	// 			$stmtlog->close();
	// 		} else {
	// 		}

	// 		// query for fetch selected sale data from sale_header table - 12 fields
	// 		$stmt = $mysqli->prepare("SELECT customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, creation_date, creation_time, creation_user FROM sale_header WHERE sale_id = ?");
	// 		$stmt->bind_param("s", $_POST['sale_id']);
	// 		$stmt->execute();
	// 		$stmt->store_result();
	// 		if ($stmt->num_rows == 1) {

	// 			// query to get item data based on customer_id
	// 			$stmt->bind_result($customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $creation_date, $creation_time, $creation_user);
	// 			$stmt->fetch();
	// 			$stmt->close();

	// 			//query insert data into sale_header_log table - 17 field
	// 			$stmt = $mysqli->prepare("INSERT INTO sale_header_log ( mode, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	// 			$stmt->bind_param("sssssssdddsssssss", $mode, $_POST["sale_id"], $customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $modify_user);
	// 			$stmt->execute();
	// 			$stmt->close();

	// 			// query to delete data from sale_header table
	// 			$stmt = $mysqli->prepare("DELETE FROM sale_header WHERE sale_id = ?");
	// 			$stmt->bind_param("s", $_POST["sale_id"]);
	// 			$stmt->execute();
	// 			$stmt->close();

	// 			// query to delete data from sale_detail table - because cannot use foreign key feature
	// 			$stmt = $mysqli->prepare("DELETE FROM sale_detail WHERE sale_id_header = ?");
	// 			$stmt->bind_param("s", $_POST["sale_id"]);
	// 			$stmt->execute();
	// 			$stmt->close();

	// 			echo "success delete";
	// 		} else {
	// 			echo "id not found";
	// 		}
	// 	} else {
	// 		echo "Some input field is not set.";
	// 	}
	// 	break;
}

mysqli_close($mysqli);
