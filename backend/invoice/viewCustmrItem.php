<?php

require_once("../login/dbConfig.php");
session_start();

ini_set('display_errors', 1);
error_reporting(-1);
$postType =  $_POST["postType"];
//var_dump($_POST);

// SQL for view all items data //

switch ($postType) {

		// customer section for view
	case ("searchRowCustomer"):

		if (isset($_POST["searchCustomerName"]) || isset($_POST['searchCustomerID'])) {
			//$_POST['pageNum'] = 1;

			// Prepare a select statement
			$recordsPerPage = 10;
			$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

			if ($_POST["searchCustomerName"] != "" && $_POST["searchCustomerID"] == "") {
				$stmt = $mysqli->prepare("SELECT customer_id, customer_account, name FROM customers WHERE customer_account REGEXP ? limit $recordsPerPage OFFSET $offsetValue");
				$stmt->bind_param("s", $_POST["searchCustomerName"]);
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
			} elseif ($_POST['searchCustomerID'] != "" && $_POST["searchCustomerName"] == "") {
				$stmt = $mysqli->prepare("SELECT customer_id, customer_account, name FROM customers WHERE name REGEXP ? limit $recordsPerPage OFFSET $offsetValue");
				$stmt->bind_param("s", $_POST["searchCustomerID"]);
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
			} elseif ($_POST["searchCustomerName"] != "" && $_POST['searchCustomerID'] != "") {
				$stmt = $mysqli->prepare("SELECT customer_id, customer_account, name FROM customers WHERE customer_account REGEXP ? AND name REGEXP ? limit $recordsPerPage OFFSET $offsetValue");
				$stmt->bind_param("ss", $_POST["searchCustomerID"], $_POST["searchCustomerName"]);
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

			//$stmt = $mysqli->prepare("SELECT customer_id, customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, religion, control_ac, accounting_account FROM customers WHERE customer_account REGEXP ? OR name REGEXP ?");
			// $stmt = $mysqli->prepare("SELECT customer_id, customer_account, name FROM customers WHERE customer_account REGEXP ? OR name REGEXP ?");
			// $stmt->bind_param("ss", $_POST["searchCustomerID"], $_POST["searchCustomerName"]);



		}
		break;

	case ("countRowCustomer"):

		//calculate total row of data
		$stmt = $mysqli->prepare("SELECT COUNT(customer_id) FROM customers;");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;

	case ("searchRowCountCustomer"):

		// if (isset($_POST["searchCustomerName"]) || isset($_POST['searchCustomerID'])) {
		// 	$stmt = $mysqli->prepare("SELECT COUNT(customer_id) FROM customers WHERE customer_account REGEXP ? OR name REGEXP ? ");
		// 	// Bind variables to the prepared statement as parameters
		// 	$stmt->bind_param("ss", $_POST["searchCustomerID"], $_POST["searchCustomerName"]);

		// 	$stmt->execute();
		// 	$row = $stmt->get_result()->fetch_row();
		// 	$rowTotal = $row[0];
		// 	echo json_encode($rowTotal);
		// 	$stmt->close();
		// }

		if (isset($_POST["searchCustomerName"]) || isset($_POST['searchCustomerID'])) {

			if ($_POST["searchCustomerName"] != "" && $_POST["searchCustomerID"] == "") {
				$stmt = $mysqli->prepare("SELECT COUNT(customer_id) FROM customers WHERE customer_account REGEXP ? ");
				$stmt->bind_param("s", $_POST["searchCustomerName"]);
				$stmt->execute();
				$row = $stmt->get_result()->fetch_row();
				$rowTotal = $row[0];
				echo json_encode($rowTotal);
				$stmt->close();
			} elseif ($_POST['searchCustomerID'] != "" && $_POST["searchCustomerName"] == "") {
				$stmt = $mysqli->prepare("SELECT COUNT(customer_id)   FROM customers WHERE  name REGEXP ?");
				$stmt->bind_param("s", $_POST["searchCustomerID"]);
				$stmt->execute();
				$row = $stmt->get_result()->fetch_row();
				$rowTotal = $row[0];
				echo json_encode($rowTotal);
				$stmt->close();
			} elseif ($_POST["searchCustomerName"] != "" && $_POST['searchCustomerID'] != "") {
				$stmt = $mysqli->prepare("SELECT COUNT(customer_id)   FROM customers WHERE customer_account REGEXP ? AND name REGEXP ?");
				$stmt->bind_param("ss", $_POST["searchCustomerID"], $_POST["searchCustomerName"]);
				$stmt->execute();
				$row = $stmt->get_result()->fetch_row();
				$rowTotal = $row[0];
				echo json_encode($rowTotal);
				$stmt->close();
			}

		}
		break;

	case ("viewCustomer"):
		//$_POST['pageNum'] = 1;

		$recordsPerPage = 20;
		$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT customer_id, customer_account, name, reg_num, outstanding, points, status, address, postcode, state, salutation, email, website, biz_nature, salesperson, category, city, country, attention, introducer, reg_date, expiry_date, telephone1, telephone2, fax, handphone, skype, nric, religion, control_ac, accounting_account FROM customers order by customer_id desc limit $recordsPerPage OFFSET $offsetValue");

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

	case ("searchRowItemAdd"):
		$stmt = $mysqli->prepare("SELECT item_id, item_no, description, selling_price1, qty_available, unit_cost FROM items WHERE item_id = ?;");
		$stmt->bind_param("s", $_POST["itemID"]);
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

		
	case ("searchRowItemGetQuantity"):
		$stmt = $mysqli->prepare("SELECT qty_available FROM items WHERE item_id = ?;");
		$stmt->bind_param("s", $_POST["itemID"]);
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;

		// item section for view
	case ("searchRowItem"):

		if (isset($_POST["search"])) {

			//$_POST['pageNum'] = 1;

			$recordsPerPage = 10;
			$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;
			//$stmt = $mysqli->prepare("SELECT item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu FROM items WHERE item_no REGEXP ? OR description REGEXP ? limit $recordsPerPage OFFSET $offsetValue");
			$stmt = $mysqli->prepare("SELECT item_id, item_no, description, selling_price1, qty_available, unit_cost  FROM items WHERE item_no REGEXP ? OR description REGEXP ? limit $recordsPerPage OFFSET $offsetValue");
			// Bind variables to the prepared statement as parameters
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

	case ("countRowItem"):

		//calculate total row of data
		$stmt = $mysqli->prepare("SELECT COUNT(item_id) FROM items;");
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$rowTotal = $row[0];
		echo json_encode($rowTotal);
		$stmt->close();
		break;

	case ("searchRowCountItem"):
		if (isset($_POST["search"])) {
			$stmt = $mysqli->prepare("SELECT COUNT(item_no) FROM items WHERE item_no REGEXP ? OR description REGEXP ? ;");
			// Bind variables to the prepared statement as parameters
			$stmt->bind_param("ss", $_POST["search"], $_POST["search"]);
			$stmt->execute();
			$row = $stmt->get_result()->fetch_row();
			$rowTotal = $row[0];
			echo json_encode($rowTotal);
		}
		$stmt->close();
		break;

	case ("viewItem"):

		//$_POST['pageNum'] = 1;

		$recordsPerPage = 20;
		$offsetValue = ($_POST['pageNum'] - 1) * $recordsPerPage;

		$stmt = $mysqli->prepare("SELECT item_id, item_no, doc_key, description, description2, description3, master_vendor, vendor_item, item_type, category, item_group, unit_cost, selling_price1, qty_hand, qty_hold, qty_available, qty_reorder_available, qty_max, vendor, vendor_company, item_picture, plu FROM items order by item_id desc limit $recordsPerPage OFFSET $offsetValue");
		$stmt->execute();
		$result = $stmt->get_result();

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$jsonArray[] = $row;
			};
			echo json_encode($jsonArray);
		} else {
			echo "No result";
		}
		$stmt->close();
		break;
}

mysqli_close($mysqli);
