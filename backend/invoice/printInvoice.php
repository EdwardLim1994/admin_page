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

        $stmt = $mysqli->prepare("SELECT invoice_id, in_account, in_name, invoice_num, invoice_date, invoice_remark, doc_no, due_date, subtotal_ex, discount_header, total_amount FROM invoice_header WHERE invoice_id = ?");
        $stmt->bind_param("s", $_POST["invoice_id"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $jsonArrayHeader[] = $row;
            };
            //$_SESSION["currPageInvoice"] = $_POST['pageNum'];
            echo json_encode($jsonArrayHeader);
        } else {
            echo "No Result";
        }
        $stmt->close();

        echo "<br>";

        $stmt = $mysqli->prepare("SELECT invoice_detail_id, item_id, invoice_id_header, item_no, description, quantity, uom, price, discount, amount, base_cost FROM invoice_detail WHERE invoice_id_header = ? ");
        $stmt->bind_param("s", $_POST["invoice_id"]);
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

        echo '<br><a href="../../invoiceMaintenance.php">Return</a>';
        break;
}
