<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //
switch ($postType) {

    case ("printSalePayment"):
		if (isset($_POST["sale_payment_id"])) {

			$stmt = $mysqli->prepare("SELECT sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference FROM sale_payment WHERE sale_payment_id = ?"); 
			$stmt->bind_param("i", $_POST["sale_payment_id"]);
			$stmt->execute();
			$result = $stmt->get_result();
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$salePaymentHeaderArray[] = $row;
				};
				//echo json_encode($paymentHeaderArray);
			
			} else {
				echo "No Result";
			}
			$stmt->close();

            //print_r( $salePaymentHeaderArray);
            $sale_id_header = $salePaymentHeaderArray[0]["sale_id_header"];
			//$sale_id_header = $paymentHeaderArray[0];
		
			$stmt = $mysqli->prepare("SELECT item_id, item_no, description, qty, price, discount, amount FROM sale_detail WHERE sale_id_header = ? ORDER BY item_id asc"); 
			$stmt->bind_param("s", $sale_id_header);
			$stmt->execute();
			$result = $stmt->get_result();
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$salePaymentBodyArray[] = $row;
				};
				//echo json_encode($paymentBodyArray);
				
			} else {
				//echo "No Result";
			}
			$stmt->close();
			echo json_encode(array($salePaymentHeaderArray, $salePaymentBodyArray));
		}
		echo '<br><a href="../../saleMaintenance.php">Return</a>';
		break;

}
