<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //
switch ($postType) {

    case ("paymentList"):
        //$_POST['pageNum'] = 1;// comment this after commit

	 	$recordsPerPage= 20;
	 	$offsetValue = ($_POST['pageNum']-1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT payment_identifier, customer_account, payment_date, invoice_id FROM payment ORDER BY payment_id desc limit $recordsPerPage OFFSET $offsetValue"); 

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

    case ("printPayment"):
        if (isset($_POST["payment_identifier"], $_POST["customer_account"] )) {

            //query to fetch customer detail from customer table
			$stmt = $mysqli->prepare("SELECT name FROM customers WHERE customer_account = ?");
			$stmt->bind_param("s", $_POST["customer_account"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($customer_name);
			$stmt->fetch();
			$stmt->close();

            $stmt = $mysqli->prepare("SELECT invoice_id, payment_date, payment_amount FROM payment WHERE payment_identifier = ?");
            $stmt->bind_param("s", $_POST["payment_identifier"]);
            $stmt->execute();
            $result = $stmt->get_result();

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $jsonArrayPayment[] = $row;
                };
                $jsonArrayPayment[] = $customer_name;
                echo json_encode($jsonArrayPayment);
            } else {
                echo "No Result";
            }
            $stmt->close();

        }
        else{
            echo "not set";
        }

}
