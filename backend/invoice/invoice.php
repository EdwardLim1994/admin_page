<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //

switch ($postType) {
	case ("searchRow"):

		if (isset($_POST["search"])) {
			//$_POST['pageNum'] = 1; // comment when commit

			// Prepare a select statement
			$recordsPerPage= 20;
	 		$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

	 		$stmt = $mysqli->prepare("SELECT invoice_id, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount FROM invoice_header WHERE in_account REGEXP ? OR in_name REGEXP ?");
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
		$stmt = $mysqli->prepare("SELECT COUNT(invoice_id) FROM invoice_header;");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;

	case ("searchRowCount"):

		if (isset($_POST["search"])) {
			$stmt = $mysqli->prepare("SELECT COUNT(invoice_id) FROM invoice_header WHERE in_account REGEXP ? OR in_name REGEXP ? ");
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("ss", $_POST["search"], $_POST["search"]);
				
			$stmt->execute();
			$row = $stmt->get_result()->fetch_row();
			$rowTotal = $row[0];
			echo json_encode($rowTotal);
			$stmt->close();
		}
		break;
	
	case ("viewHeader"):
		//$_POST['pageNum'] = 1;// comment this after commit

	 	$recordsPerPage= 20;
	 	$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT invoice_id, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, payment FROM invoice_header ORDER BY id desc limit $recordsPerPage OFFSET $offsetValue"); 

		$stmt->execute();
		$result = $stmt->get_result();

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$jsonArray[] = $row;
			};
			//$_SESSION["currPageInvoice"] = $_POST['pageNum'];
			echo json_encode($jsonArray);
           
		} else {
			echo "No Result";
		}
		$stmt->close();
		break;

	case ("viewDetail"):
		
		$stmt = $mysqli->prepare("SELECT invoice_detail_id, invoice_id_header, item_id, item_no, description, quantity, uom, price, discount, amount, base_cost FROM invoice_detail WHERE invoice_id_header = ? ");
	 	$stmt->bind_param("s", $_POST["invoice_id"]);
		$stmt->execute();
		$result = $stmt->get_result();
	
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$jsonArray[] = $row;
			};;
			echo json_encode($jsonArray);
			   
		} else {
			echo "No Result";
		}
		$stmt->close();
		break;

	case ("add"):

		// check isset for all post variable
		$countSetAdd = 0;
		$postVariable = array('in_account','in_name','invoice_num','invoice_date','invoice_remark','doc_no','due_date','subtotal_ex','discount_header','total_amount',
        'item_id','item_no','description','quantity','uom','price','discount','amount','base_cost');

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

			// assign array data into variable
			$item_id = $_POST['item_id'];
			$item_no = $_POST['item_no'];
			$description = $_POST['description'];
			$quantity = $_POST['quantity'];
			$uom = $_POST['uom'];
			$price = $_POST['price'];
			$discount = $_POST['discount'];
			$amount = $_POST['amount'];
			$base_cost = $_POST['base_cost'];

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			$date_id = date("Ymd");
			$time_id = date("His");
			$creation_user = $_SESSION["username"];
			//$creation_user = "admin"; // comment this when submit
			$mode = "Add";

			$itemCount = count($item_no);
		
			// create invoice id 
			$invoice_id = "iv" . $date_id . $time_id;

			//create outstanding variable
			$outstanding = $_POST['total_amount'];

			//set default value for payment
			$payment = 0.00;

			//query insert data into invoice_header table - 16 field
			$stmt = $mysqli->prepare("INSERT INTO invoice_header (invoice_id, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssssdddddsss", $invoice_id, $_POST['in_account'], $_POST['in_name'], $_POST['invoice_num'], $_POST['invoice_date'], $_POST['invoice_remark'], $_POST['doc_no'], $_POST['due_date'], $_POST['subtotal_ex'], $_POST['discount_header'], $_POST['total_amount'], $outstanding, $payment, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			// query to store item data into invoice_detail table - 13 field
			$stmtlog = $mysqli->prepare("INSERT INTO invoice_detail (invoice_id_header, item_id, item_no, description, quantity, uom, price, discount, amount, base_cost, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for($i = 0; $i < $itemCount; $i++){
                $stmtlog->bind_param("sissisddddsss", $invoice_id, $item_id[$i], $item_no[$i], $description[$i], $quantity[$i], $uom[$i], $price[$i], $discount[$i], $amount[$i], $base_cost[$i], $creation_date, $creation_time, $creation_user);
			    $stmtlog->execute();
            }
			$stmtlog->close();

            //query insert data into invoice_header_log table - 17 field
			$stmt = $mysqli->prepare("INSERT INTO invoice_header_log (invoice_id_log, mode, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssssdddddsss", $invoice_id, $mode, $_POST['in_account'], $_POST['in_name'], $_POST['invoice_num'], $_POST['invoice_date'], $_POST['invoice_remark'], $_POST['doc_no'], $_POST['due_date'], $_POST['subtotal_ex'], $_POST['discount_header'], $_POST['total_amount'], $outstanding, $payment, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

            // query to store item data into invoice_detail_log table - 14 field
			$stmtlog = $mysqli->prepare("INSERT INTO invoice_detail_log (mode, invoice_id_header_log, item_id, item_no, description, quantity, uom, price, discount, amount, base_cost, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for($i = 0; $i < $itemCount; $i++){
                $stmtlog->bind_param("ssissisddddsss", $mode, $invoice_id, $item_id[$i], $item_no[$i], $description[$i], $quantity[$i], $uom[$i], $price[$i], $discount[$i], $amount[$i], $base_cost[$i], $creation_date, $creation_time, $creation_user);
			    $stmtlog->execute();
            }
			$stmtlog->close();

			echo"success add";
			//header("location: ../../invoiceMaintenance.php?success=item added");

		}else{
			echo "Some input field is not set.";
		}
		break;

	case ("update"):

		// check isset for all post variable
		$countSetUpdate = 0;
		$postVariable = array('invoice_id','in_account','in_name','invoice_num','invoice_date','invoice_remark','doc_no','due_date','subtotal_ex','discount_header','total_amount',
        'item_id','item_no','description','quantity','uom','price','discount','amount','base_cost');

		foreach ($postVariable as $variable_name) {
			if(isset($_POST[$variable_name])){
				$countSetUpdate++;
			}else{
				$countSetUpdate--;
			}
		}

		// if all post variable is set, update data into database
		if($countSetUpdate == count($postVariable)){

			// assign array data into variable
			$item_id = $_POST['item_id'];
			$item_no = $_POST['item_no'];
			$description = $_POST['description'];
			$quantity = $_POST['quantity'];
			$uom = $_POST['uom'];
			$price = $_POST['price'];
			$discount = $_POST['discount'];
			$amount = $_POST['amount'];
			$base_cost = $_POST['base_cost'];

			//$outstanding = $_POST['total_amount'];
			//$payment = 0.00;

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			
			$modify_user = $_SESSION["username"];
			$creation_user = $_SESSION["username"];
			//$modify_user = "admin";
			//$creation_user = "admin"; // comment this when submit
			$mode = "Update";

			$itemCount = count($item_no);

			//fetch old invoice_header data 
			$stmt = $mysqli->prepare("SELECT payment FROM invoice_header WHERE invoice_id = ?");
			$stmt->bind_param("s", $_POST['invoice_id']);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows == 1) {
				$stmt->bind_result( $old_payment);
				$stmt->fetch();
				$stmt->close();
			} else {
				echo "invoice_id not found";
			}

			$newOutstanding = (double)$_POST['total_amount'] - (double)$old_payment;

			//update query for invoice_header tabel - 17 fields
			$stmt = $mysqli->prepare("UPDATE invoice_header SET invoice_id = ?, in_account = ?, in_name = ?, invoice_num = ?, invoice_date = ?, invoice_remark = ?, doc_no = ?, due_date = ?, subtotal_ex = ?, discount_header = ?, total_amount = ?, outstanding = ?, payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE invoice_id = ?");
			$stmt->bind_param("ssssssssdddddssss", $_POST['invoice_id'], $_POST['in_account'], $_POST['in_name'], $_POST['invoice_num'], $_POST['invoice_date'], $_POST['invoice_remark'], $_POST['doc_no'], $_POST['due_date'], $_POST['subtotal_ex'], $_POST['discount_header'], $_POST['total_amount'], $newOutstanding, $old_payment, $modify_date, $modify_time, $modify_user, $_POST['invoice_id']);
			$stmt->execute();
			$stmt->close();

			//query to delete old invoice_detail for specific invoice_id
			$stmt = $mysqli->prepare("DELETE FROM invoice_detail WHERE invoice_id_header = ?");
			$stmt->bind_param("s", $_POST["invoice_id"]);
			$stmt->execute();
			$stmt->close();

			// query to store item data into invoice_detail table - 16 field
			$stmtlog = $mysqli->prepare("INSERT INTO invoice_detail (invoice_id_header, item_id, item_no, description, quantity, uom, price, discount, amount, base_cost, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for($i = 0; $i < $itemCount; $i++){
                $stmtlog->bind_param("sissisddddssssss", $_POST['invoice_id'], $item_id[$i], $item_no[$i], $description[$i], $quantity[$i], $uom[$i], $price[$i], $discount[$i], $amount[$i], $base_cost[$i], $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $modify_user);
			    $stmtlog->execute();
            }
			$stmtlog->close();

			//query to fetch creation data from invoice_header table
			$stmt = $mysqli->prepare("SELECT creation_date, creation_time, creation_user FROM invoice_header WHERE invoice_id = ?");
			$stmt->bind_param("s", $_POST["invoice_id"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($header_creation_date, $header_creation_time, $header_creation_user);
			$stmt->fetch();
			$stmt->close();

			//query insert data into invoice_header_log table - 19 field
			$stmt = $mysqli->prepare("INSERT INTO invoice_header_log (invoice_id_log, mode, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssssdddddssssss", $_POST['invoice_id'], $mode, $_POST['in_account'], $_POST['in_name'], $_POST['invoice_num'], $_POST['invoice_date'], $_POST['invoice_remark'], $_POST['doc_no'], $_POST['due_date'], $_POST['subtotal_ex'], $_POST['discount_header'], $_POST['total_amount'], $newOutstanding, $old_payment, $header_creation_date, $header_creation_time, $header_creation_user, $modify_date, $modify_time, $modify_user);
			$stmt->execute();
			$stmt->close();

			// query to store item data into invoice_detail_log table - 17 field
			$stmtlog = $mysqli->prepare("INSERT INTO invoice_detail_log (mode, invoice_id_header_log, item_id, item_no, description, quantity, uom, price, discount, amount, base_cost, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			for($i = 0; $i < $itemCount; $i++){
                $stmtlog->bind_param("ssissisddddssssss", $mode,  $_POST['invoice_id'], $item_id[$i], $item_no[$i], $description[$i], $quantity[$i], $uom[$i], $price[$i], $discount[$i], $amount[$i], $base_cost[$i], $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $modify_user);
			    $stmtlog->execute();
            }
			$stmtlog->close();

			echo "success edit";
			//header("location: ../../invoiceMaintenance.php?success=item edited");

		}else{
			echo "Some input field is not set.";
		}
		break;

	case ("deleteHeader"):

		if (isset($_POST["invoice_id"])) {

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin"; // comment this when submit
			$mode = "Delete";

			// query for fetch selected invoice data from invoice_detail table - 13 fields
			$stmt = $mysqli->prepare("SELECT item_id, item_no, description, quantity, uom, price, discount, amount, base_cost, creation_date, creation_time, creation_user FROM invoice_detail WHERE invoice_id_header = ?");
			$stmt->bind_param("s", $_POST['invoice_id']);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0) {
				$stmt->bind_result( $item_id, $item_no, $description, $quantity, $uom, $price, $discount, $amount, $base_cost, $creation_date, $creation_time, $creation_user);
				while ($stmt->fetch()) {
					$itemArr[] = ['item_id' => $item_id, 'item_no' => $item_no, 'description' => $description, 'quantity' => $quantity, 'uom' => $uom, 'price' => $price, 'discount' => $discount, 'amount' => $amount, 'base_cost' => $base_cost, 'creation_date' => $creation_date, 'creation_time' => $creation_time, 'creation_user' => $creation_user];
				}
				$stmt->close();

				$countArray = count($itemArr);

				// query to store item detail data into invoice_detail_log table - 17 field
				$stmtlog = $mysqli->prepare("INSERT INTO invoice_detail_log (mode, invoice_id_header_log, item_id, item_no, description, quantity, uom, price, discount, amount, base_cost, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				for($y=0; $y<$countArray; $y++){
					$stmtlog->bind_param("ssissisddddssssss", $mode, $_POST['invoice_id'], $itemArr[$y]["item_id"], $itemArr[$y]["item_no"], $itemArr[$y]["description"], $itemArr[$y]["quantity"], $itemArr[$y]["uom"], $itemArr[$y]["price"], $itemArr[$y]["discount"], $itemArr[$y]["amount"], $itemArr[$y]["base_cost"], $itemArr[$y]["creation_date"], $itemArr[$y]["creation_time"], $itemArr[$y]["creation_user"], $modify_date, $modify_time, $modify_user);
					$stmtlog->execute();
				}
				$stmtlog->close();
			
				//echo "success delete in log";
				//header("location: ../../invoiceMaintenance.php?success=item deleted");
			} else {
				//echo "id log not found";
				//header("location: ../../invoiceMaintenance.php?failed=id no found");
			}		

			// query for fetch selected invoice data from invoice_header table - 15 fields
			$stmt = $mysqli->prepare("SELECT in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user FROM invoice_header WHERE invoice_id = ?");
			$stmt->bind_param("s", $_POST['invoice_id']);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows == 1) {

				// query to get item data based on customer_id
				$stmt->bind_result($in_account, $in_name, $invoice_num, $invoice_date, $invoice_remark, $doc_no, $due_date, $subtotal_ex, $discount_header, $total_amount, $header_outstanding, $header_payment, $creation_date, $creation_time, $creation_user);
				$stmt->fetch();
				$stmt->close();

				// query to insert update log to invoice_header_log table - 20 fields
				$stmtlog = $mysqli->prepare("INSERT INTO invoice_header_log ( invoice_id_log, mode, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmtlog->bind_param("sssssssssdddddssssss",$_POST['invoice_id'], $mode, $in_account, $in_name, $invoice_num, $invoice_date, $invoice_remark, $doc_no, $due_date, $subtotal_ex, $discount_header, $total_amount, $header_outstanding, $header_payment, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $modify_user);
				$stmtlog->execute();
				$stmtlog->close();

				// query to delete data from invoice_header table
				$stmt = $mysqli->prepare("DELETE FROM invoice_header WHERE invoice_id = ?");
				$stmt->bind_param("s", $_POST["invoice_id"]);
				$stmt->execute();
				$stmt->close();

				// query to delete data from invoice_detail table - because cannot use foreign key feature
				$stmt = $mysqli->prepare("DELETE FROM invoice_detail WHERE invoice_id_header = ?");
				$stmt->bind_param("s", $_POST["invoice_id"]);
				$stmt->execute();
				$stmt->close();

				echo "success delete";
				//header("location: ../../invoiceMaintenance.php?success=item deleted");
			} else {
				echo "id not found";
				//header("location: ../../invoiceMaintenance.php?failed=id no found");
			}

		}else{
			echo "Some input field is not set.";
		}
		break;
}

mysqli_close($mysqli);
