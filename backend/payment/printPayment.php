<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //
switch ($postType) {

    case ("printPayment"):
		if (isset($_POST["payment_identifier"])) {

			$stmt = $mysqli->prepare("SELECT payment_identifier, customer_account, customer_name, payment_date, payment_mode, payment_salesperson, payment_remark, total_payment_amount FROM payment_header WHERE payment_identifier = ?"); 
			$stmt->bind_param("s", $_POST["payment_identifier"]);
			$stmt->execute();
			$result = $stmt->get_result();
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$paymentHeaderArray[] = $row;
				};
				//echo json_encode($paymentHeaderArray);
			
			} else {
				echo "No Result";
			}
			$stmt->close();

			//echo "<br>";
		
			$stmt = $mysqli->prepare("SELECT payment_detail_id, invoice_id, amount_pay FROM payment_detail WHERE payment_identifier = ? ORDER BY payment_detail_id asc"); 
			$stmt->bind_param("s", $_POST["payment_identifier"]);
			$stmt->execute();
			$result = $stmt->get_result();
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$paymentBodyArray[] = $row;
				};
				//echo json_encode($paymentBodyArray);
				
			} else {
				//echo "No Result";
			}
			$stmt->close();
			echo json_encode(array($paymentHeaderArray, $paymentBodyArray));
		}
		break;

}
