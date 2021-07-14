<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //

switch ($postType) {

	//show payment header list for all customer
	case("viewPaymentHeader"):

		//$_POST['pageNum'] = 1;// comment this after commit
		$recordsPerPage= 20;
		$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT payment_id, payment_identifier, customer_account, customer_name, payment_date, payment_mode, payment_salesperson, payment_remark, total_payment_amount FROM payment_header ORDER BY payment_id desc limit $recordsPerPage OFFSET $offsetValue"); 
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
	
	case("viewPaymentDetail"):
			
		if (isset($_POST["payment_identifier"])) {
			
			$stmt = $mysqli->prepare("SELECT payment_detail_id, invoice_id, amount_pay, payment_status FROM payment_detail WHERE payment_identifier = ? ORDER BY payment_detail_id asc"); 
			$stmt->bind_param("s", $_POST["payment_identifier"]);
			$stmt->execute();
			$result = $stmt->get_result();
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$paymentBodyArray[] = $row;
				};
				echo json_encode($paymentBodyArray);
				
			} else {
				echo "No Result";
			}
			$stmt->close();
		}
		break;

	case ("countRow"):
        $stmt = $mysqli->prepare("SELECT COUNT(payment_id) FROM payment_header");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
        break;

	//Count total row of selected customer when view payment history by customer
	case ("countRowSelectedCustomer"):

		if (isset($_POST["customer_account"])) {
			$customer_name = $_POST['customer_account'];
			$stmt = $mysqli->prepare("SELECT COUNT(payment_id) FROM payment_header WHERE customer_account = '$customer_name'"); 
			$row = $stmt->get_result()->fetch_row();
			$rowTotal = $row[0];
			echo json_encode($rowTotal);
			$stmt->close();

		}
		break;

	// case for view payment history for specific customer
	case ("paymentHistory"):

		if (isset($_POST["customer_account"])) {

			//$_POST['pageNum'] = 1;// comment this after commit
			$recordsPerPage= 20;
			$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;
	
			$stmt = $mysqli->prepare("SELECT payment_id, payment_identifier, customer_account, customer_name, payment_date, payment_mode, payment_salesperson, payment_remark, total_payment_amount FROM payment_header WHERE customer_account = ? ORDER BY payment_id desc limit $recordsPerPage OFFSET $offsetValue"); 
			$stmt->bind_param("s", $_POST["customer_account"]);
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

	case ("updatePayment"):
		// check isset for all post variable
		$countSet = 0;
		$postVariable = array('payment_identifier', 'customer_account', 'customer_name', 'payment_id', 'payment_mode', 'payment_date', 'payment_remark', 'payment_salesperson','total_payment_amount', 'id', 'invoice_id', 'total_amount', 'outstanding', 'payment', 'payment_status');

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
			$id = $_POST['id'];
			$new_invoice_id = $_POST['invoice_id'];
			$total_amount = $_POST['total_amount'];
			$outstanding = $_POST['outstanding'];
			$payment = $_POST['payment'];
			$payment_status = $_POST['payment_status'];

			$payment_identifier = $_POST['payment_identifier'];
			$customer_account = $_POST['customer_account'];
			$customer_name = $_POST['customer_name'];
			$payment_id = $_POST['payment_id'];
			$payment_date = $_POST['payment_date'];
			$payment_mode = $_POST['payment_mode'];
			$payment_remark = $_POST['payment_remark'];
			$payment_salesperson = $_POST['payment_salesperson'];
			$total_payment_amount = $_POST['total_payment_amount'];

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$date_id = date("Ymd");
			$time_id = date("His");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin";
			$mode = "Update Payment";

			//count how many payment transaction
			$itemCount = count($payment);

			echo $itemCount;
			// $countOldArray = 0;

			// //fetch old payment detail data from payment detail table
			// $stmt = $mysqli->prepare("SELECT invoice_id, amount_pay FROM payment_detail WHERE payment_identifier = ?");
			// $stmt->bind_param("s", $payment_identifier);
			// $stmt->execute();
			// $stmt->store_result();
			// if ($stmt->num_rows > 0) {
			// 	$stmt->bind_result( $invoice_id, $amount_pay);
			// 	while ($stmt->fetch()) {
			// 		$paymentOldArray[] = ['invoice_id' => $invoice_id, 'amount_pay' => $amount_pay];
			// 	}
			// 	$countOldArray = count($paymentOldArray);
			// 	$stmt->close();

			// } else {
			// 	echo "payment detail not found";
			// }	

			// for($x = 0; $x < $countOldArray; $x++){
			// 	//query to fetch  data from invoice_header table
			// 	$stmt = $mysqli->prepare("SELECT outstanding, payment FROM invoice_header WHERE invoice_id = ?");
			// 	$stmt->bind_param("s", $paymentOldArray[$x]["invoice_id"]);
			// 	$stmt->execute();
			// 	$stmt->store_result();
			// 	$stmt->bind_result($header_outstanding, $header_payment);
			// 	$stmt->fetch();
			// 	$stmt->close();

			// 	$newOutstanding = (double)$header_outstanding + (double)$paymentOldArray[$x]["amount_pay"]; 
			// 	$newPayment = (double)$header_payment - (double)$paymentOldArray[$x]["amount_pay"]; 

			// 	//update value of outstanding and payment in payment_header table
			// 	$stmt = $mysqli->prepare("UPDATE invoice_header SET outstanding = ?, payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE invoice_id = ?");
			// 	$stmt->bind_param("ddssss", $newOutstanding, $newPayment, $modify_date, $modify_time, $modify_user, $paymentOldArray[$x]["invoice_id"]);
			// 	$stmt->execute();
			// 	$stmt->close();

			// }

			// //query delete data from payment_detail table for old data
			// $stmt = $mysqli->prepare("DELETE FROM payment_detail WHERE payment_identifier = ?");
			// $stmt->bind_param("s", $payment_identifier);
			// $stmt->execute();
			// $stmt->close();

			// //update payment_header
			// $stmt = $mysqli->prepare("UPDATE payment_header SET payment_identifier = ?, payment_date = ?, payment_mode = ?, payment_salesperson = ?, payment_remark = ?, total_payment_amount = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE payment_id = ?");
			// $stmt->bind_param("sssssdsssi", $payment_identifier, $payment_date, $payment_mode, $payment_salesperson, $payment_remark, $total_payment_amount, $modify_date, $modify_time, $modify_user, $payment_id);
			// $stmt->execute();
			// $stmt->close();

			// //query to update invoice header when payment is done
			// for($i = 0; $i < $itemCount; $i++){

			// 	$stmt = $mysqli->prepare("UPDATE invoice_header SET outstanding = ?, payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE id = ?");
			// 	$stmt->bind_param("ddsssi", $outstanding[$i], $payment[$i], $modify_date, $modify_time, $modify_user, $id[$i]);
			// 	$stmt->execute();
			// 	$stmt->close();

			// 	//query to fetch  data from invoice_header table - 10 field
			// 	$stmt = $mysqli->prepare("SELECT creation_date, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, creation_time, creation_user FROM invoice_header WHERE id = ?");
			// 	$stmt->bind_param("i", $id[$i]);
			// 	$stmt->execute();
			// 	$stmt->store_result();
			// 	$stmt->bind_result($header_creation_date, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $header_creation_time, $header_creation_user);
			// 	$stmt->fetch();
			// 	$stmt->close();

			// 	//query insert data into payment_detail table - 4 field
			// 	$stmt = $mysqli->prepare("INSERT INTO payment_detail (payment_identifier, invoice_id, amount_pay, payment_status) VALUES (?, ?, ?, ?)");
			// 	$stmt->bind_param("ssds", $payment_identifier, $new_invoice_id[$i], $payment[$i], $payment_status[$i]);
			// 	$stmt->execute();
			// 	$stmt->close();

			// 	//query insert data into invoice_header_log table - 20 field
			// 	$stmt = $mysqli->prepare("INSERT INTO invoice_header_log (invoice_id_log, mode, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			// 	$stmt->bind_param("sssssssssdddddssssss", $new_invoice_id[$i], $mode, $customer_account, $customer_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $total_amount[$i], $outstanding[$i], $payment[$i], $header_creation_date, $header_creation_time, $header_creation_user, $modify_date, $modify_time, $modify_user);
			// 	$stmt->execute();
			// 	$stmt->close();
				
			// }

			// echo"success update payment";
			//header("location: ../../paymentMaintenance.php?success=payment updated");

		}else{
			echo "Some input field is not set.";
		}
		break;

	case ("deletePayment"):
		// check isset for all post variable
		$countSet = 0;
		$postVariable = array('payment_id', 'payment_identifier');

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
			$payment_id = $_POST['payment_id'];
			$payment_identifier = $_POST['payment_identifier'];

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");
			$modify_user = $_SESSION["username"];
			//$modify_user = "admin";
			$mode = "Delete Payment";
			$countArray = 0;

			//fetch data from payment_detail table based on payment_identifier
			$stmt = $mysqli->prepare("SELECT invoice_id, amount_pay FROM payment_detail WHERE payment_identifier = ?");
			$stmt->bind_param("s", $payment_identifier);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0) {
				$stmt->bind_result( $invoice_id, $amount_pay);
				while ($stmt->fetch()) {
					$paymentDetailArray[] = ['invoice_id' => $invoice_id, 'amount_pay' => $amount_pay];
				}
				$stmt->close();

				$countArray = count($paymentDetailArray);
			} else {
				echo "payment detail not found";
			}	

			for($i = 0; $i < $countArray; $i++){
				//query to fetch  data from invoice_header table
				$stmt = $mysqli->prepare("SELECT creation_date, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_time, creation_user FROM invoice_header WHERE invoice_id = ?");
				$stmt->bind_param("s", $paymentDetailArray[$i]["invoice_id"]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($header_creation_date, $header_in_account, $header_in_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $header_total_amount, $header_outstanding, $header_payment, $header_creation_time, $header_creation_user);
				$stmt->fetch();
				$stmt->close();

				$newOutstanding = (double)$header_outstanding + (double)$paymentDetailArray[$i]["amount_pay"]; 
				$newPayment = (double)$header_payment - (double)$paymentDetailArray[$i]["amount_pay"]; 

				//update value of outstanding and payment in invoice_header table
				$stmt = $mysqli->prepare("UPDATE invoice_header SET outstanding = ?, payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE invoice_id = ?");
				$stmt->bind_param("ddssss", $newOutstanding, $newPayment, $modify_date, $modify_time, $modify_user, $paymentDetailArray[$i]["invoice_id"]);
				$stmt->execute();
				$stmt->close();

				//query insert data into invoice_header_log table - 20 field
				$stmt = $mysqli->prepare("INSERT INTO invoice_header_log (invoice_id_log, mode, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount, outstanding, payment, creation_date, creation_time, creation_user, modified_date, modified_time, modified_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssssssssdddddssssss", $paymentDetailArray[$i]["invoice_id"], $mode, $header_in_account, $header_in_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $header_total_amount, $header_outstanding, $header_payment, $header_creation_date, $header_creation_time, $header_creation_user, $modify_date, $modify_time, $modify_user);
				$stmt->execute();
				$stmt->close();
			}

			//query delete data from payment_header table 
			$stmt = $mysqli->prepare("DELETE FROM payment_header WHERE payment_id = ?");
			$stmt->bind_param("i", $payment_id);
			$stmt->execute();
			$stmt->close();

			//query delete data from payment_detail table 
			$stmt = $mysqli->prepare("DELETE FROM payment_detail WHERE payment_identifier = ?");
			$stmt->bind_param("s", $payment_identifier);
			$stmt->execute();
			$stmt->close();

			echo"success delete payment";
			//header("location: ../../paymentMaintenance.php?success=payment deleted");

		}else{
			echo "Some input field is not set.";
		}
		break;

	case ("viewInvoiceOutstanding"):
		if (isset($_POST["customer_account"])) {
			//$_POST['pageNum'] = 1;// comment this after commit

			$recordsPerPage= 20;
			$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

			$stmt = $mysqli->prepare("SELECT id, invoice_id, doc_no, creation_date, invoice_num,  invoice_date, due_date, total_amount, outstanding, payment FROM invoice_header WHERE in_account = ? AND outstanding > 0 ORDER BY id desc limit $recordsPerPage OFFSET $offsetValue"); 
			$stmt->bind_param("s", $_POST["customer_account"]);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
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
		if (isset($_POST["customer_account"])) {
			//$_POST['pageNum'] = 1;// comment this after commit

			$recordsPerPage= 20;
			$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

			$stmt = $mysqli->prepare("SELECT id, invoice_id, doc_no, creation_date, invoice_num,  invoice_date, due_date, total_amount, outstanding, payment FROM invoice_header WHERE in_account = ? ORDER BY id desc limit $recordsPerPage OFFSET $offsetValue"); 
			$stmt->bind_param("s", $_POST["customer_account"]);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
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
		$postVariable = array('customer_account', 'customer_name', 'payment_mode', 'payment_date', 'payment_remark', 'payment_salesperson','total_payment_amount', 'id', 'invoice_id', 'total_amount', 'outstanding', 'payment', 'payment_status');

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
			$id = $_POST['id'];
			$invoice_id = $_POST['invoice_id'];
			$total_amount = $_POST['total_amount'];
			$outstanding = $_POST['outstanding'];
			$payment = $_POST['payment'];
			$payment_status = $_POST['payment_status'];

			$customer_account = $_POST['customer_account'];
			$customer_name = $_POST['customer_name'];
			$payment_date = $_POST['payment_date'];
			$payment_mode = $_POST['payment_mode'];
			$payment_remark = $_POST['payment_remark'];
			$payment_salesperson = $_POST['payment_salesperson'];
			$total_payment_amount = $_POST['total_payment_amount'];

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

			//query insert data into payment_header table - 11 field
			//outside loop because it only save once
			$stmt = $mysqli->prepare("INSERT INTO payment_header (payment_identifier, customer_account, customer_name, payment_date, payment_mode, payment_salesperson, payment_remark, total_payment_amount, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssdsss", $payment_identifier[0], $customer_account, $customer_name, $payment_date, $payment_mode, $payment_salesperson, $payment_remark, $total_payment_amount, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			//query to update invoice header when payment is done
			for($i = 0; $i < $itemCount; $i++){
				$stmt = $mysqli->prepare("UPDATE invoice_header SET outstanding = ?, payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE id = ?");
				$stmt->bind_param("ddsssi", $outstanding[$i], $payment[$i], $modify_date, $modify_time, $modify_user, $id[$i]);
				$stmt->execute();
				$stmt->close();

				//query to fetch  data from invoice_header table
				$stmt = $mysqli->prepare("SELECT creation_date, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, creation_time, creation_user FROM invoice_header WHERE id = ?");
				$stmt->bind_param("i", $id[$i]);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($header_creation_date, $header_in_account, $header_in_name, $header_invoice_num, $header_invoice_date, $header_invoice_remark, $header_doc_no, $header_due_date, $header_subtotal_ex, $discount_header, $header_creation_time, $header_creation_user);
				$stmt->fetch();
				$stmt->close();

				//query insert data into payment_detail table - 4 field
				$stmt = $mysqli->prepare("INSERT INTO payment_detail (payment_identifier, invoice_id, amount_pay, payment_status) VALUES (?, ?, ?, ?)");
				$stmt->bind_param("ssds", $payment_identifier[0], $invoice_id[$i], $payment[$i], $payment_status[$i]);
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

	case ("viewInvoiceHeader"):
		if (isset($_POST["selected_id"])) {
			$stmt = $mysqli->prepare("SELECT invoice_id, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount FROM invoice_header where invoice_id = ?"); 
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