<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //

switch ($postType) {

	// case for view payment history for specific customer
	case ("paymentHistory"):

		if (isset($_POST["customer_account"])) {

		//$_POST['pageNum'] = 1;// comment this after commit

		$recordsPerPage= 20;
		$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

        $stmt = $mysqli->prepare("SELECT payment_identifier, payment_id, invoice_id, payment_date, payment_mode, invoice_amount, payment_amount, payment_remark, payment_salesperson, payment_status FROM payment WHERE customer_account = ?  ORDER BY payment_id desc limit $recordsPerPage OFFSET $offsetValue"); 
			$stmt->bind_param("s", $_POST["customer_account"]);
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

	case ("updatePayment"):
		// check isset for all post variable
		$countSet = 0;
		$postVariable = array('id', 'invoice_id', 'customer_account', 'payment_mode', 'payment_date', 'payment_remark', 'payment_salesperson', 'total_amount', 'outstanding', 'payment', 'payment_status', 'payment_identifier');

		foreach ($postVariable as $variable_name) {
			if(isset($_POST[$variable_name])){
				$countSet++;
			}else{
				$countSet--;
				//echo $variable_name. "not set<br>";
			}
		}

		// if all post variable is set, insert data into database
		if($countSet == count($postVariable)){

			// assign array data into variable
			$id = $_POST['id'];
			$invoice_id = $_POST['invoice_id'];
			$payment_mode = $_POST['payment_mode'];
			$total_amount = $_POST['total_amount'];
			$outstanding = $_POST['outstanding'];
			$payment = $_POST['payment'];
			$payment_status = $_POST['payment_status'];

			$customer_account = $_POST['customer_account'];
			$payment_identifier_old = $_POST['payment_identifier'];
			$payment_date = $_POST['payment_date'];
			$payment_remark = $_POST['payment_remark'];
			$payment_salesperson = $_POST['payment_salesperson'];

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			$date_id = date("Ymd");
			$time_id = date("His");
			$creation_user = $_SESSION["username"];
			//$creation_user = "admin"; // comment this when submit
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin";
			$mode = "Update Payment";

			//count how many payment transaction
			$itemCount = count($payment);
			//create payment_identifier 
			$payment_identifier[0] = "p" . $date_id . $time_id;

			//delete old payment based on old payment_identifier
			//query to fetch  data from payment table based on payment_identifier_old
			$stmt = $mysqli->prepare("SELECT invoice_id, payment_amount FROM payment WHERE payment_identifier = ?");
			$stmt->bind_param("s", $payment_identifier_old);
			$stmt->execute();
			$result = $stmt->get_result();
			// Check number of rows in the result set
			if ($result->num_rows > 0) {
				// Fetch result rows as an associative array
				while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$old_payment_data[] = $row;
				}
			} else {
				echo "No result";
			}
			$stmt->close();

			$rowTotal = count($old_payment_data);
			//echo $rowTotal;
			
			for($i = 0; $i < $rowTotal; $i++){
				//query to fetch  data from invoice_header table based on old_invoice_id
				$stmt = $mysqli->prepare("SELECT outstanding, payment FROM invoice_header WHERE invoice_id = ?");
				$stmt->bind_param("s", $old_payment_data[$i]['invoice_id']);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($old_outstanding, $old_payment);
				$stmt->fetch();
				$stmt->close();

				/*echo $old_payment_data[$i]['invoice_id'];
				echo "     ";
				echo $old_outstanding;
				echo "     ";

				echo $old_payment_data[$i]['payment_amount'];
				echo "     ";*/
				$latest_old_outstanding = (double)$old_outstanding + (double)$old_payment_data[$i]['payment_amount'];
				$latest_old_payment = (double)$old_payment - (double)$old_payment_data[$i]['payment_amount'];

				/*echo $latest_old_outstanding;
				echo "      ";
				echo $latest_old_payment;*/

				//query to change back the outstanding and payment value in invoice_header table
				$stmt = $mysqli->prepare("UPDATE invoice_header SET outstanding = ?, payment = ? WHERE invoice_id = ?");
				$stmt->bind_param("dds", $latest_old_outstanding, $latest_old_payment, $old_payment_data[$i]['invoice_id']);
				$stmt->execute();
				$stmt->close();

			}
			//query delete data from payment table 
			$stmt = $mysqli->prepare("DELETE FROM payment WHERE payment_identifier = ?");
			$stmt->bind_param("s", $payment_identifier_old);
			$stmt->execute();
			$stmt->close();

			//query to fetch  data from invoice_header table
			$stmt = $mysqli->prepare("SELECT in_name FROM invoice_header WHERE invoice_id = ?");
			$stmt->bind_param("s", $invoice_id[0]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($customer_name);
			$stmt->fetch();
			$stmt->close();

			//query to update invoice header when payment is done
			for($x = 0; $x < $itemCount; $x++){

				$stmt = $mysqli->prepare("UPDATE invoice_header SET total_amount = ?, outstanding = ?, payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE id = ?");
				$stmt->bind_param("dddsssi", $total_amount[$x], $outstanding[$x], $payment[$x], $modify_date, $modify_time, $modify_user, $id[$x]);
				$stmt->execute();
				$stmt->close();

				//query to fetch  data from invoice_header table
				$stmt = $mysqli->prepare("SELECT creation_date, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, creation_time, creation_user FROM invoice_header WHERE invoice_id = ?");
				$stmt->bind_param("s", $invoice_id[$x]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($header_creation_date, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $header_creation_time, $header_creation_user);
				$stmt->fetch();
				$stmt->close();

				//query insert data into payment table - 13 field
				$stmt = $mysqli->prepare("INSERT INTO payment (invoice_id, payment_date, payment_mode, invoice_amount, payment_amount, payment_remark, payment_salesperson, payment_status, payment_identifier, customer_account, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?)");
				$stmt->bind_param("sssddssssssss", $invoice_id[$x], $payment_date, $payment_mode, $total_amount[$x], $payment[$x], $payment_remark, $payment_salesperson, $payment_status[$x], $payment_identifier[0], $customer_account, $creation_date, $creation_time, $creation_user);
				$stmt->execute();
				$stmt->close();

				//query insert data into invoice_header_log table - 20 field
				$stmt = $mysqli->prepare("INSERT INTO invoice_header_log (invoice_id_log, mode, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssssssssdddddssssss", $invoice_id[$x], $mode, $customer_account, $customer_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $total_amount[$x], $outstanding[$x], $payment[$x], $header_creation_date, $header_creation_time, $header_creation_user, $modify_date, $modify_time, $modify_user);
				$stmt->execute();
				$stmt->close();
				
			}

			echo"success update payment";
			//header("location: ../../paymentMaintenance.php?success=payment added");

		}else{
			echo "Some input field is not set.";
		}
		
		break;

	case ("deletePayment"):
		// check isset for all post variable
		$countSet = 0;
		$postVariable = array('payment_identifier', 'invoice_id', 'payment_amount');

		foreach ($postVariable as $variable_name) {
			if(isset($_POST[$variable_name])){
				$countSet++;
			}else{
				$countSet--;
				echo $variable_name. "not set<br>";
			}
		}

		// if all post variable is set, insert data into database
		if($countSet == count($postVariable)){

			// assign array data into variable
			$payment_identifier = $_POST['payment_identifier'];
			$invoice_id = $_POST['invoice_id'];
			$payment_amount = $_POST['payment_amount'];

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin";
			$mode = "Delete Payment";

			//count how many payment transaction
			$itemCount = count($payment_amount);

			//query to update invoice header when payment is done
			for($i = 0; $i < $itemCount; $i++){

				//query to fetch  data from invoice_header table
				$stmt = $mysqli->prepare("SELECT creation_date, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_time, creation_user FROM invoice_header WHERE invoice_id = ?");
				$stmt->bind_param("s", $invoice_id[$i]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($header_creation_date, $header_in_account, $header_in_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $header_total_amount, $header_outstanding, $header_payment, $header_creation_time, $header_creation_user);
				$stmt->fetch();
				$stmt->close();

				$newOutstanding = (double)$header_outstanding + (double)$payment_amount[$i]; 
				$newPayment = (double)$header_payment - (double)$payment_amount[$i]; 

				$stmt = $mysqli->prepare("UPDATE invoice_header SET outstanding = ?, payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE invoice_id = ?");
				$stmt->bind_param("ddssss", $newOutstanding, $newPayment, $modify_date, $modify_time, $modify_user, $invoice_id[$i]);
				$stmt->execute();
				$stmt->close();

				//query insert data into invoice_header_log table - 20 field
				$stmt = $mysqli->prepare("INSERT INTO invoice_header_log (invoice_id_log, mode, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssssssssdddddssssss", $invoice_id[$i], $mode, $header_in_account, $header_in_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $header_total_amount, $header_outstanding, $header_payment, $header_creation_date, $header_creation_time, $header_creation_user, $modify_date, $modify_time, $modify_user);
				$stmt->execute();
				$stmt->close();
			}

			//query delete data from payment table 
			$stmt = $mysqli->prepare("DELETE FROM payment WHERE payment_identifier = ?");
			$stmt->bind_param("s", $payment_identifier[0]);
			$stmt->execute();
			$stmt->close();

			echo"success delete payment";
			//header("location: ../../paymentMaintenance.php?success=payment added");

		}else{
			echo "Some input field is not set.";
		}
		break;

	case ("viewInvoiceOutstanding"):
		if (isset($_POST["account_num"])) {
			//$_POST['pageNum'] = 1;// comment this after commit

			$recordsPerPage= 20;
			$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

			$stmt = $mysqli->prepare("SELECT id, invoice_id, invoice_date, due_date, total_amount, outstanding FROM invoice_header WHERE in_account = ? AND outstanding > 0 ORDER BY id limit $recordsPerPage OFFSET $offsetValue"); 
			$stmt->bind_param("s", $_POST["account_num"]);
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

	case ("viewInvoiceAll"):
		if (isset($_POST["account_num"])) {
			//$_POST['pageNum'] = 1;// comment this after commit

			$recordsPerPage= 20;
			$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

			$stmt = $mysqli->prepare("SELECT id, invoice_id, doc_no, creation_date, invoice_num,  invoice_date, due_date, total_amount, outstanding, payment FROM invoice_header WHERE in_account = ? ORDER BY id limit $recordsPerPage OFFSET $offsetValue"); 
			$stmt->bind_param("s", $_POST["account_num"]);
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

	case ("pay"):

		// check isset for all post variable
		$countSet = 0;
		$postVariable = array('id', 'invoice_id', 'payment_mode', 'payment_date', 'payment_remark', 'payment_salesperson', 'total_amount', 'outstanding', 'payment', 'payment_status');

		foreach ($postVariable as $variable_name) {
			if(isset($_POST[$variable_name])){
				$countSet++;
			}else{
				$countSet--;
				//echo $variable_name. "not set<br>";
			}
		}

		// if all post variable is set, insert data into database
		if($countSet == count($postVariable)){

			// assign array data into variable
			$id = $_POST['id'];
			$invoice_id = $_POST['invoice_id'];
			$payment_mode = $_POST['payment_mode'];
			$total_amount = $_POST['total_amount'];
			$outstanding = $_POST['outstanding'];
			$payment = $_POST['payment'];
			$payment_status = $_POST['payment_status'];

			$payment_date = $_POST['payment_date'];
			$payment_remark = $_POST['payment_remark'];
			$payment_salesperson = $_POST['payment_salesperson'];

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$creation_date = date("Y-m-d");
			$creation_time = date("H:i:s");
			$date_id = date("Ymd");
			$time_id = date("His");
			$creation_user = $_SESSION["username"];
			//$creation_user = "admin"; // comment this when submit
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin";
			$mode = "Pay";

			//count how many payment transaction
			$itemCount = count($payment);
			//create payment_identifier 
			$payment_identifier[0] = "p" . $date_id . $time_id;

			//query to update invoice header when payment is done
			for($i = 0; $i < $itemCount; $i++){
				$stmt = $mysqli->prepare("UPDATE invoice_header SET total_amount = ?, outstanding = ?, payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE id = ?");
				$stmt->bind_param("dddsssi", $total_amount[$i], $outstanding[$i], $payment[$i], $modify_date, $modify_time, $modify_user, $id[$i]);
				$stmt->execute();
				$stmt->close();

				//query to fetch  data from invoice_header table
				$stmt = $mysqli->prepare("SELECT creation_date, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, creation_time, creation_user FROM invoice_header WHERE invoice_id = ?");
				$stmt->bind_param("s", $invoice_id[$i]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($header_creation_date, $header_in_account, $header_in_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $header_creation_time, $header_creation_user);
				$stmt->fetch();
				$stmt->close();

				//query insert data into payment table - 13 field
				$stmt = $mysqli->prepare("INSERT INTO payment (invoice_id, payment_date, payment_mode, invoice_amount, payment_amount, payment_remark, payment_salesperson, payment_status, payment_identifier, customer_account, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?)");
				$stmt->bind_param("sssddssssssss", $invoice_id[$i], $payment_date, $payment_mode, $total_amount[$i], $payment[$i], $payment_remark, $payment_salesperson, $payment_status[$i], $payment_identifier[0], $header_in_account, $creation_date, $creation_time, $creation_user);
				$stmt->execute();
				$stmt->close();

				//query insert data into invoice_header_log table - 20 field
				$stmt = $mysqli->prepare("INSERT INTO invoice_header_log (invoice_id_log, mode, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssssssssdddddssssss", $invoice_id[$i], $mode, $header_in_account, $header_in_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $total_amount[$i], $outstanding[$i], $payment[$i], $header_creation_date, $header_creation_time, $header_creation_user, $modify_date, $modify_time, $modify_user);
				$stmt->execute();
				$stmt->close();
				
			}

			echo"success pay";
			//header("location: ../../paymentMaintenance.php?success=payment added");

		}else{
			echo "Some input field is not set.";
		}
		break;

	/*case ("viewPayment"):
		if (isset($_POST["selected_id_pay"])) {
			//echo $_POST["selected_id_pay"];

			$stmt = $mysqli->prepare("SELECT payment_id, invoice_id, payment_date, payment_mode, invoice_amount, payment_amount, payment_remark, payment_salesperson, payment_status FROM payment WHERE invoice_id = ?  ORDER BY payment_id desc"); 
			$stmt->bind_param("s", $_POST["selected_id_pay"]);
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

		break;*/

	case ("viewInvoiceHeader"):
		if (isset($_POST["selected_id"])) {
			$stmt = $mysqli->prepare("SELECT invoice_id, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount FROM invoice_header where id = ?"); 
			$stmt->bind_param("i", $_POST["selected_id"]);
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
		
	case ("viewInvoiceDetail"):
		if (isset($_POST["selected_id"])) {
			$stmt = $mysqli->prepare("SELECT invoice_detail_id, invoice_id_header, item_id, item_no, description, quantity, uom, price, discount, amount, base_cost FROM invoice_detail WHERE invoice_id_header = ? ");
	 		$stmt->bind_param("s", $_POST["selected_id"]);
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

};

mysqli_close($mysqli);
