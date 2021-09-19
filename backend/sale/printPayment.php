<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //
switch ($postType) {
    case ("print"):
        //$_POST['pageNum'] = 1;// comment this after commit
        $sale_header_id = "";
        $stmt = $mysqli->prepare("SELECT sale_payment_id, sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_amount, sale_payment, reference FROM sale_payment WHERE sale_payment_id = ?");
        $stmt->bind_param("s", $_POST["sale_payment_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $jsonArrayHeader[] = $row;
                $sale_header_id = $row['sale_id_header'];
            };
            
            //$_SESSION["currPageInvoice"] = $_POST['pageNum'];
            echo json_encode($jsonArrayHeader);
        } else {
            echo "No Result";
        }
        $stmt->close();

        echo "<br>";

        $stmt = $mysqli->prepare("SELECT id, sale_id, customer_account, customer_name, sale_date, sale_phone_num, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount, payment_status FROM sale_header WHERE sale_id = ? ");
        $stmt->bind_param("s", $sale_header_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $jsonArrayBody[] = $row;
            };;
            echo json_encode($jsonArrayBody);
        } else {
            echo "No Result";
        }
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT sale_detail_id, sale_id_header, item_id, item_no, description, uom, qty, discount, amount FROM sale_detail WHERE sale_id_header = ? ");
        $stmt->bind_param("s", $sale_header_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $jsonArrayBody[] = $row;
            };;
            echo json_encode($jsonArrayBody);
        } else {
            echo "No Result";
        }
        $stmt->close();

        echo '<br><a href="../../saleMaintenance.php">Return</a>';
        break;
}
