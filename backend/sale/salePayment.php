<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType = $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //

switch ($postType) {

	case ("salesorderSearch"):
		if (isset($_POST["searchSalesOrder"])) {
			$recordsPerPage = 10;
			$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

			$stmt = $mysqli->prepare("SELECT sale_id, customer_name, sale_total_amount, payment_status FROM sale_header WHERE sale_id REGEXP ? OR customer_name REGEXP ?");
			$stmt->bind_param("ss", $_POST["searchSalesOrder"], $_POST["searchSalesOrder"]);

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
		} else {
			echo "value not set";
		}
		break;

	case ("searchSalesOrderSelect"):

		$stmt = $mysqli->prepare("SELECT sale_id, customer_name, sale_salesperson, sale_date, sale_subtotal, sale_discount_header, sale_total_amount FROM sale_header WHERE sale_id = ?;");
		$stmt->bind_param("s", $_POST["saleID"]);
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



		break;

	case ("salesorderCountRow"):

		if (isset($_POST["searchSalesOrder"])) {
			$stmt = $mysqli->prepare("SELECT COUNT(sale_id) FROM sale_header WHERE sale_id REGEXP ? OR customer_name REGEXP ?");
			$stmt->bind_param("ss", $_POST["searchSalesOrder"], $_POST["searchSalesOrder"]);
			$stmt->execute();
			$row = $stmt->get_result()->fetch_row();
			$rowTotal = $row[0];
			echo json_encode($rowTotal);
			$stmt->close();
			break;
		}
		break;

	case ("salesorderSelect"):

		break;

	case ("searchRow"):

		if (isset($_POST["search"])) {
			//$_POST['pageNum'] = 1; // comment when commit

			// Prepare a select statement
			$recordsPerPage = 20;
			$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

			$stmt = $mysqli->prepare("SELECT sale_payment_id, sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference FROM sale_payment WHERE sale_id_header REGEXP ? OR customer_name REGEXP ?");
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
		$stmt = $mysqli->prepare("SELECT COUNT(sale_payment_id) FROM sale_payment;");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;

	case ("searchRowCount"):

		if (isset($_POST["search"])) {
			$stmt = $mysqli->prepare("SELECT COUNT(sale_payment_id) FROM sale_payment WHERE sale_id_header REGEXP ? OR customer_name REGEXP ? ");
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("ss", $_POST["search"], $_POST["search"]);

			$stmt->execute();
			$row = $stmt->get_result()->fetch_row();
			$rowTotal = $row[0];
			echo json_encode($rowTotal);
			$stmt->close();
		}
		break;

	case ("viewSalePayment"):
		//$_POST['pageNum'] = 1;// comment this after commit

		$recordsPerPage = 20;
		$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT sale_payment_id, sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference FROM sale_payment ORDER BY sale_payment_id desc limit $recordsPerPage OFFSET $offsetValue");

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

	case ("viewSalePaymentDetail"):

		if (isset($_POST["sale_id"])) {

			//fetch sale header data from sale header table
			$stmt = $mysqli->prepare("SELECT customer_account, customer_name, sale_salesperson, sale_subtotal, sale_discount_header, sale_total_amount FROM sale_header WHERE sale_id = ? ");
			$stmt->bind_param("s", $_POST["sale_id"]);
			$stmt->execute();
			$result = $stmt->get_result();

			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$saleHeaderArray[] = $row;
				};
				//echo json_encode($jsonArray);

			} else {
				echo "No Result";
			}
			$stmt->close();

			//fetch sale detail data from sale detail table
			$stmt = $mysqli->prepare("SELECT item_id, item_no, description, uom, qty, price, discount, amount FROM sale_detail WHERE sale_id_header = ? ORDER BY item_id asc");
			$stmt->bind_param("s", $_POST["sale_id"]);
			$stmt->execute();
			$result = $stmt->get_result();

			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$saleDetailArray[] = $row;
				};
				//echo json_encode($jsonArray);

			} else {
				echo "No Result";
			}
			$stmt->close();

			echo json_encode(array($saleHeaderArray, $saleDetailArray));

			break;
		}

	case ("addSalePayment"):

		// check isset for all post variable
		$countSetAdd = 0;
		$postVariable = array('customer_name', 'sale_id', 'payment_method', 'sale_amount', 'sale_payment', 'reference');

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
			$reference = $_POST["reference"];

			//query insert data into sale_payment table - 11 field
			$stmt = $mysqli->prepare("INSERT INTO sale_payment (sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssddssss", $sale_id_header, $sale_payment_date, $sale_payment_time, $payment_method, $customer_name, $sale_amount, $sale_payment, $reference, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			//query to update payment_status in sale_header table
			$stmt = $mysqli->prepare("UPDATE sale_header SET payment_status = ? WHERE sale_id = ?");
			$stmt->bind_param("ss", $payment_status, $_POST['sale_id']);
			$stmt->execute();
			$stmt->close();

			//query insert data into sale_payment_log table - 12 field
			$stmt = $mysqli->prepare("INSERT INTO sale_payment_log (mode, sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssddssss", $mode, $sale_id_header, $sale_payment_date, $sale_payment_time, $payment_method, $customer_name, $sale_amount, $sale_payment, $reference, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			echo "success add payment";
		} else {
			echo "Some input field is not set.";
		}
		break;

	case ("updateSalePayment"):

		// check isset for all post variable
		$countSetUpdate = 0;
		$postVariable = array('sale_payment_id', 'payment_method', 'sale_payment');

		foreach ($postVariable as $variable_name) {
			if (isset($_POST[$variable_name])) {
				$countSetUpdate++;
			} else {
				$countSetUpdate--;
				print_r($_POST[$variable_name]);
			}
		}

		// if all post variable is set, update data into database
		if ($countSetUpdate == count($postVariable)) {

			$payment_method = $_POST['payment_method'];
			$sale_payment = $_POST['sale_payment'];

			date_default_timezone_set("Asia/Kuala_Lumpur");
			$modify_date = date("Y-m-d");
			$modify_time = date("H:i:s");

			$modify_user = $_SESSION["username"];
			//$modify_user = "admin";
			$mode = "Update";

			$sale_payment_date = date("Y-m-d");
			$sale_payment_time = date("H:i:s");

			//update query for sale_payment tabel - 7 fields
			$stmt = $mysqli->prepare("UPDATE sale_payment SET payment_method = ?, sale_payment_date = ?, sale_payment_time = ?, sale_payment = ?, modified_date = ?, modified_time = ?, modified_user = ? WHERE sale_payment_id = ?");
			$stmt->bind_param("sssdsssi", $payment_method, $sale_payment_date, $sale_payment_time, $sale_payment, $modify_date, $modify_time, $modify_user, $_POST['sale_payment_id']);
			$stmt->execute();
			$stmt->close();

			//query to fetch data from sale_payment table
			$stmt = $mysqli->prepare("SELECT sale_id_header, customer_name, sale_amount, reference, creation_date, creation_time, creation_user FROM sale_payment WHERE sale_payment_id = ?");
			$stmt->bind_param("i", $_POST["sale_payment_id"]);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($sale_id_header, $customer_name, $sale_amount, $reference, $creation_date, $creation_time, $creation_user);
			$stmt->fetch();
			$stmt->close();

			//query insert data into sale_payment_log table - 12 field
			$stmt = $mysqli->prepare("INSERT INTO sale_payment_log (mode, sale_id_header, sale_payment_date, sale_payment_time, payment_method, customer_name, sale_amount, sale_payment, reference, creation_date, creation_time, creation_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssddssss", $mode, $sale_id_header, $sale_payment_date, $sale_payment_time, $payment_method, $customer_name, $sale_amount, $sale_payment, $reference, $creation_date, $creation_time, $creation_user);
			$stmt->execute();
			$stmt->close();

			echo "success edit payment";
		} else {
			echo "Some input field is not set.";
		}
		break;
}

mysqli_close($mysqli);
