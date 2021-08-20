<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

switch ($postType) {

	case ("countRow"):

		//calculate total row of data
		$stmt = $mysqli->prepare("SELECT COUNT(id) FROM sale_header WHERE isOnHold = 1;");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;

	//Retrieve onhold sale order
	case("viewSaleHeaderOnHold"):
		//$_POST['pageNum'] = 1; // comment when commit

		$recordsPerPage = 20;
		$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT id, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold FROM sale_header WHERE isOnHold = 1 ORDER BY id desc limit $recordsPerPage OFFSET $offsetValue");
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
    
    case ("payOnHold"):
        
        // check isset for all post variable
		$countSetAdd = 0;
		$postVariable = array(
            'item_id', 'qty',
            'customer_name', 'sale_id', 'payment_method', 'sale_amount', 'sale_payment'
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

            // assign array data into variable
			$item_id = $_POST['item_id'];
            $qty = $_POST['qty'];

			$customer_name = $_POST['customer_name'];
			$sale_id_header = $_POST['sale_id'];
			$payment_method = $_POST['payment_method'];
			$sale_amount = $_POST['sale_amount'];
			$sale_payment = $_POST['sale_payment'];

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			$creation_user = $_SESSION["username"];
			//$creation_user = "admin"; // comment this when submit
			$mode = "Add";

			// create variable for rest of the table
			$sale_payment_date = date("Y-m-d");
			$sale_payment_time = date("H:i:s");
			$payment_status = "Paid";
			$reference = $_POST["reference"] != "" ? $_POST["reference"] : "";
            $isOnHold = 0;

            $itemCount = count($item_id);

			//query insert data into sale_payment table - 11 field
			$stmt = $mysqli->prepare("INSERT INTO sale_payment (sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssddssss", $sale_id_header, $sale_payment_date, $sale_payment_time, $payment_method, $customer_name, $sale_amount, $sale_payment, $reference, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			//query to update payment_status in sale_header table  <- set isOnHold to 0 whenever it is 1 or 0
			$stmt = $mysqli->prepare("UPDATE sale_header SET payment_status = ?, isOnHold = ? WHERE sale_id = ?");
			$stmt->bind_param("sis", $payment_status, $isOnHold, $sale_id_header);
			$stmt->execute();
			$stmt->close();

			//query to fetch sale header data
			$stmt = $mysqli->prepare("SELECT customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, creation_date, creation_time, creation_user FROM sale_header WHERE sale_id = ?");
			$stmt->bind_param("s", $sale_id_header);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $header_creation_date, $header_creation_time, $header_creation_user);
			$stmt->fetch();
			$stmt->close();

			//query insert data into sale_header_log table - 18 field
			$stmt = $mysqli->prepare("INSERT INTO sale_header_log ( mode, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssdddssssssss", $mode, $sale_id_header, $customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $isOnHold, $header_creation_date, $header_creation_time, $header_creation_user, $modify_date, $modify_time, $modify_user);
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

			//query insert data into sale_payment_log table - 12 field
			$stmt = $mysqli->prepare("INSERT INTO sale_payment_log (mode, sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssddssss", $mode, $sale_id_header, $sale_payment_date, $sale_payment_time, $payment_method, $customer_name, $sale_amount, $sale_payment, $reference, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			echo "success add payment for on-hold sale order";
		} else {
			//echo "Some input field is not set.";
			echo $countSetAdd;
		}
		break;

	case ("add"):

		// // check isset for all post variable
		// $countSetAdd = 0;
		// $postVariable = array(
		// 	'sale_salesperson', 'sale_subtotal', 'sale_discount_header', 'sale_total_amount',
		// 	'item_id', 'item_no', 'description', 'uom', 'qty', 'price', 'discount', 'amount',
		// );

		// foreach ($postVariable as $variable_name) {
		// 	if (isset($_POST[$variable_name])) {
		// 		$countSetAdd++;
		// 	} else {
		// 		$countSetAdd--;
		// 		//echo $variable_name. "not set<br>";
		// 	}
		// }

		// // if all post variable is set, insert data into database
		// if ($countSetAdd == count($postVariable)) {

			// assign array data into variable
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

			date_default_timezone_set("Asia/Kuala_Lumpur");
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
			$payment_status = "UnPaid";
			$isOnHold = 1;

			//query insert data into sale_header table - 14 field
			$stmt = $mysqli->prepare("INSERT INTO sale_header (sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
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

			//query insert data into sale_header_log table - 15 field
			$stmtlog = $mysqli->prepare("INSERT INTO sale_header_log ( mode, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("sssssssdddsisss", $mode, $sale_id, $customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $isOnHold, $creation_date, $creation_time, $creation_user);
			$stmtlog->execute();
			$stmtlog->close();

			// query to store item data into sale_detail_log table - 13 field
			$stmtlog = $mysqli->prepare("INSERT INTO sale_detail_log ( mode, sale_id_header, item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for ($i = 0; $i < $itemCount; $i++) {
				$stmtlog->bind_param("ssisssidddsss", $mode, $sale_id, $item_id[$i], $item_no[$i], $description[$i], $uom[$i], $qty[$i], $price[$i], $discount[$i], $amount[$i], $creation_date, $creation_time, $creation_user);
				$stmtlog->execute();
			}
			$stmtlog->close();

			echo "success add";
		// } else {
		// 	echo "Some input field is not set.";
		// }
		break;

	case ("update"):

		// check isset for all post variable
		$countSetUpdate = 0;
		$postVariable = array(
			'sale_id', 'customer_account', 'customer_name', 'sale_salesperson', 'sale_subtotal', 'sale_discount_header', 'sale_total_amount',
			'item_id', 'item_no', 'description', 'uom', 'qty', 'price', 'discount', 'amount',
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

			// assign array data into variable
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

			//query to delete old sale_detail for specific sale_id
			$stmt = $mysqli->prepare("DELETE FROM sale_detail WHERE sale_id_header = ?");
			$stmt->bind_param("s", $_POST["sale_id"]);
			$stmt->execute();
			$stmt->close();

			// query to store item data into sale_detail table - 15 field
			$stmtlog = $mysqli->prepare("INSERT INTO sale_detail (sale_id_header, item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for ($i = 0; $i < $itemCount; $i++) {
				$stmtlog->bind_param("sisssidddssssss", $_POST["sale_id"], $item_id[$i], $item_no[$i], $description[$i], $uom[$i], $qty[$i], $price[$i], $discount[$i], $amount[$i], $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $modify_user);
				$stmtlog->execute();
			}
			$stmtlog->close();

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

	case ("delete"):

		if (isset($_POST["sale_id"])) {

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin"; // comment this when submit
			$mode = "Delete";

			// query for fetch selected sale data from sale_detail table - 11 fields
			$stmt = $mysqli->prepare("SELECT item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user FROM sale_detail WHERE sale_id_header = ?");
			$stmt->bind_param("s", $_POST['sale_id']);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0) {
				$stmt->bind_result($item_id, $item_no, $description, $uom, $qty, $price, $discount, $amount, $creation_date, $creation_time, $creation_user);
				while ($stmt->fetch()) {
					$itemArr[] = ['item_id' => $item_id, 'item_no' => $item_no, 'description' => $description, 'uom' => $uom, 'qty' => $qty, 'price' => $price, 'discount' => $discount, 'amount' => $amount, 'creation_date' => $creation_date, 'creation_time' => $creation_time, 'creation_user' => $creation_user];
				}
				$stmt->close();

				$countArray = count($itemArr);

				// query to store item detail data into sale_detail_log table - 16 field
				$stmtlog = $mysqli->prepare("INSERT INTO sale_detail_log ( mode, sale_id_header, item_id, item_no, description, uom, qty, price, discount, amount, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				for ($y = 0; $y < $countArray; $y++) {
					$stmtlog->bind_param("ssisssidddssssss", $mode, $_POST['sale_id'], $itemArr[$y]["item_id"], $itemArr[$y]["item_no"], $itemArr[$y]["description"], $itemArr[$y]["uom"], $itemArr[$y]["qty"], $itemArr[$y]["price"], $itemArr[$y]["discount"], $itemArr[$y]["amount"], $itemArr[$y]["creation_date"], $itemArr[$y]["creation_time"], $itemArr[$y]["creation_user"], $modify_date, $modify_time, $modify_user);
					$stmtlog->execute();
				}
				$stmtlog->close();
			} else {
			}

			// query for fetch selected sale data from sale_header table - 13 fields
			$stmt = $mysqli->prepare("SELECT customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold, creation_date, creation_time, creation_user FROM sale_header WHERE sale_id = ?");
			$stmt->bind_param("s", $_POST['sale_id']);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows == 1) {

				$stmt->bind_result($customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $isOnHold, $creation_date, $creation_time, $creation_user);
				$stmt->fetch();
				$stmt->close();

				//query insert data into sale_header_log table - 18 field
				$stmt = $mysqli->prepare("INSERT INTO sale_header_log ( mode, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status, isOnHold, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssssssdddssssssss", $mode, $_POST["sale_id"], $customer_account, $customer_name, $sale_date, $sale_phone_num, $sale_salesperson, $sale_subtotal, $sale_discount_header, $sale_total_amount, $payment_status, $isOnHold, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $modify_user);
				$stmt->execute();
				$stmt->close();

				// query to delete data from sale_header table
				$stmt = $mysqli->prepare("DELETE FROM sale_header WHERE sale_id = ?");
				$stmt->bind_param("s", $_POST["sale_id"]);
				$stmt->execute();
				$stmt->close();

				// query to delete data from sale_detail table - because cannot use foreign key feature
				$stmt = $mysqli->prepare("DELETE FROM sale_detail WHERE sale_id_header = ?");
				$stmt->bind_param("s", $_POST["sale_id"]);
				$stmt->execute();
				$stmt->close();

				echo "success delete";
			} else {
				echo "id not found";
			}
		} else {
			echo "Some input field is not set.";
		}
		break;
}

mysqli_close($mysqli);
