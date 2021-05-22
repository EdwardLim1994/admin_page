<?php

//$_POST = json_decode(file_get_contents('php://input'), true);  //###### comment ni time submit - shafie 
require_once('dbConfig.php');
session_start();

$postType =  $_POST["postType"];

// SQL for view all users //
if ($postType == "view") {
	// Perform query
	$stmt = $mysqli->prepare("SELECT username, role, login_attempt, contact_num, email, status FROM users");
	$stmt->execute();
	$result = $stmt->get_result();

	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$jsonArray[] = $row;
		};
		echo json_encode($jsonArray);
	} else {
		echo "0 results";
	}
	$stmt->close();
}

//SQL for add user
elseif ($postType == "add") {

	// find if there are existing username
	$stmtCheck = $mysqli->prepare("SELECT count(1) FROM users WHERE username = ?");
	$stmtCheck->bind_param("s", $_POST['username']);
	$stmtCheck->execute();
	$stmtCheck->bind_result($found);
	$stmtCheck->fetch();
	if ($found) {
		$errorMessage = "Username Already Existed";
		echo $errorMessage;
		//echo json_encode($errorMessage);

	} else {

		$stmtCheck->close();

		$hashPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$login_attempt = 0;
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$creation_date = date("Y-m-d");
		$creation_time = date("H:i:s");
		$creation_user = $_SESSION["username"];
		$mode = "Add";

		$stmt = $mysqli->prepare("INSERT INTO users (username, password, role, login_attempt, creation_date, creation_time, creation_user, status, contact_num, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssissssss", $_POST['username'], $hashPass, $_POST['role'], $login_attempt, $creation_date, $creation_time, $creation_user, $_POST['status'], $_POST['contact_num'], $_POST['email']);

		$stmt->execute();
		$stmt->close();

		// query to insert selected data from user table to userlog table - 12 field all

		$stmtlog = $mysqli->prepare("INSERT INTO userlog (mode, username, password, role, login_attempt, last_login_date, creation_date, creation_time, creation_user, status, contact_num, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmtlog->bind_param("ssssisssssss", $mode, $_POST['username'], $hashPass, $_POST['role'], $login_attempt, $last_login_date, $creation_date, $creation_time, $creation_user, $_POST['status'], $_POST['contact_num'], $_POST['email']);

		$stmtlog->execute();
		$stmtlog->close();

		echo "Success";
	}
}

//SQL for display selected user
// elseif ($postType == "selectedData") {

// 	$stmt = $mysqli->prepare("SELECT username, password, role, login_attempt FROM users WHERE username = ?");
// 	$stmt->bind_param("s", $_POST['username']);
// 	$stmt->execute();
// 	$result = $stmt->get_result();
// 	if (mysqli_num_rows($result) == 1){

// 		while($row = mysqli_fetch_assoc($result)) {
// 	               $jsonArray[] = $row;
// 	           	};
// 	    echo json_encode($jsonArray);
// 	}
// 	$stmt->close();
// }

//SQL for update user
elseif ($postType == "update") {

	if ($_POST['password']) {
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$modify_date = date("Y-m-d");
		$modify_time = date("H:i:s");
		$last_modified_user = $_SESSION["username"];
		$mode = "Update";

		$hashPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$stmt = $mysqli->prepare("UPDATE users SET password = ?, role = ?, login_attempt = ?, last_modified_date = ?, modified_time = ?, last_modified_user = ?, status = ?, contact_num = ?, email = ?  WHERE username = ?");
		$stmt->bind_param("ssisssssss", $hashPass, $_POST['role'], $_POST['login_attempt'], $modify_date, $modify_time, $last_modified_user, $_POST['status'], $_POST['contact_num'], $_POST['email'], $_POST['username']);

		$stmt->execute();
		$stmt->close();

		// query for fetch selected username data from user table

		$stmt = $mysqli->prepare("SELECT last_login_date, creation_date, creation_time, creation_user, current_session_id FROM users WHERE username = ?");
		$stmt->bind_param("s", $_POST['username']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($last_login_date, $creation_date, $creation_time, $creation_user, $current_session_id);
		$stmt->fetch();
		$stmt->close();

		// query to insert selected data from user table to userlog table - 16 field all

		$stmtlog = $mysqli->prepare("INSERT INTO userlog (mode, username, password, role, login_attempt, last_login_date, creation_date, creation_time, creation_user,  last_modified_date, modified_time, last_modified_user, current_session_id, status, contact_num, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmtlog->bind_param("ssssisssssssssss", $mode, $_POST['username'], $hashPass, $_POST['role'],  $_POST['login_attempt'], $last_login_date, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $last_modified_user, $current_session_id, $_POST['status'], $_POST['contact_num'], $_POST['email']);

		$stmtlog->execute();
		$stmtlog->close();

		echo "Success";
	} else {

		date_default_timezone_set("Asia/Kuala_Lumpur");
		$modify_date = date("Y-m-d");
		$modify_time = date("H:i:s");
		$last_modified_user = $_SESSION["username"];
		$mode = "Update";

		$stmt = $mysqli->prepare("UPDATE users SET  role = ?, login_attempt = ?, last_modified_date = ?, modified_time = ? , last_modified_user = ?, status = ?, contact_num = ?, email = ? WHERE username = ?");
		$stmt->bind_param("sisssssss", $_POST['role'], $_POST['login_attempt'], $modify_date, $modify_time, $last_modified_user, $_POST['status'], $_POST['contact_num'], $_POST['email'], $_POST['username']);

		$stmt->execute();
		$stmt->close();

		// query for fetch selected username data from user table

		$stmt = $mysqli->prepare("SELECT password, last_login_date, creation_date, creation_time, creation_user, current_session_id FROM users WHERE username = ?");
		$stmt->bind_param("s", $_POST['username']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($password, $last_login_date, $creation_date, $creation_time, $creation_user, $current_session_id);
		$stmt->fetch();
		$stmt->close();

		// query to insert selected data from user table to userlog table - 16 field all

		$stmtlog = $mysqli->prepare("INSERT INTO userlog (mode, username, password, role, login_attempt, last_login_date, creation_date, creation_time, creation_user,  last_modified_date, modified_time, last_modified_user, current_session_id, status, contact_num, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmtlog->bind_param("ssssisssssssssss", $mode, $_POST['username'], $password, $_POST['role'],  $_POST['login_attempt'], $last_login_date, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $last_modified_user, $current_session_id, $_POST['status'], $_POST['contact_num'], $_POST['email']);

		$stmtlog->execute();
		$stmtlog->close();

		echo "Success";
	}
}

//SQL for delete user
elseif ($postType == "delete") {

	date_default_timezone_set("Asia/Kuala_Lumpur");
	$modify_date = date("Y-m-d");
	$modify_time = date("H:i:s");
	$last_modified_user = $_SESSION["username"];
	$mode = "Delete";

	// query for fetch selected username data from user table

	$stmt = $mysqli->prepare("SELECT password, role, login_attempt, last_login_date, creation_date, creation_time, creation_user, current_session_id, status, contact_num, email FROM users WHERE username = ?");
	$stmt->bind_param("s", $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($password, $role, $login_attempt, $last_login_date, $creation_date, $creation_time, $creation_user, $current_session_id, $status, $contact_num, $trytest);
	$stmt->fetch();
	$stmt->close();

	// query to insert selected data from user table to userlog table - 16 field all

	$stmtlog = $mysqli->prepare("INSERT INTO userlog (mode, username, password, role, login_attempt,  last_login_date, creation_date, creation_time, creation_user,  last_modified_date, modified_time, last_modified_user, current_session_id, status, contact_num, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmtlog->bind_param("ssssisssssssssss", $mode, $_POST['username'], $password, $role, $login_attempt, $last_login_date, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $last_modified_user, $current_session_id, $status, $contact_num, $trytest);

	$stmtlog->execute();
	$stmtlog->close();

	// query to delete data from user table

	$stmt = $mysqli->prepare("DELETE FROM users WHERE username = ?");
	$stmt->bind_param("s", $_POST['username']);
	$stmt->execute();
	$stmt->close();

	echo "Success";
}

//sql to display staff information
elseif ($postType == "staffView") {
	$current_username = $_SESSION["username"];
	// Perform query view
	$stmt = $mysqli->prepare("SELECT username, email, contact_num FROM users WHERE username = ?");
	$stmt->bind_param("s", $current_username);
	$stmt->execute();
	$result = $stmt->get_result();

	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$jsonArray[] = $row;
		};
		echo json_encode($jsonArray);
	} else {
		echo "0 results";
	}
	$stmt->close();
}

// sql for staff update
elseif ($postType == "staffUpdate") {

	date_default_timezone_set("Asia/Kuala_Lumpur");
	$modify_date = date("Y-m-d");
	$modify_time = date("H:i:s");
	$current_id = $_SESSION['id'];
	$mode = "Update";

	if ($_POST['password']) {

		// find if there are existing username
		$stmtCheck = $mysqli->prepare("SELECT count(1) FROM users WHERE username = ? AND id != ?");
		$stmtCheck->bind_param("si", $_POST['username'], $current_id);
		$stmtCheck->execute();
		$stmtCheck->bind_result($found);
		$stmtCheck->fetch();
		if ($found) {
			$errorMessage = "Username Already Existed";
			echo $errorMessage;
		} else {
			$stmtCheck->close();
			$hashPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$stmt = $mysqli->prepare("UPDATE users SET username = ?, password = ?, last_modified_date = ?, modified_time = ?, last_modified_user = ?, contact_num = ?, email = ?  WHERE id = ?");
			$stmt->bind_param("sssssssi", $_POST['username'], $hashPass, $modify_date, $modify_time, $_POST['username'], $_POST['contact_num'], $_POST['email'], $current_id);
			$stmt->execute();
			$stmt->close();

			// query for fetch selected username data from user table

			$stmt = $mysqli->prepare("SELECT role,login_attempt, last_login_date, creation_date, creation_time, creation_user, current_session_id, status, ip_address, browser FROM users WHERE id = ?");
			$stmt->bind_param("i", $current_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($role, $login_attempt, $last_login_date, $creation_date, $creation_time, $creation_user, $current_session_id, $status, $ip_address, $browser);
			$stmt->fetch();
			$stmt->close();

			// query to insert selected data from user table to userlog table 

			$stmtlog = $mysqli->prepare("INSERT INTO userlog (user_id, mode, username, password, role, login_attempt, last_login_date, creation_date, creation_time, creation_user,  last_modified_date, modified_time, last_modified_user, current_session_id, status, contact_num, email, ip_address, browser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("issssisssssssssssss", $current_id, $mode, $_POST['username'], $hashPass, $role,  $login_attempt, $last_login_date, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $_POST['username'], $current_session_id, $status, $_POST['contact_num'], $_POST['email'], $ip_address, $browser);

			$stmtlog->execute();
			$stmtlog->close();

			echo "Success";
		}
	} else {

		// find if there are existing username
		$stmtCheck = $mysqli->prepare("SELECT count(1) FROM users WHERE username = ? AND id != ?");
		$stmtCheck->bind_param("si", $_POST['username'], $current_id);
		$stmtCheck->execute();
		$stmtCheck->bind_result($found);
		$stmtCheck->fetch();
		if ($found) {
			$errorMessage = "Username Already Existed";
			echo $errorMessage;
		} else {
			$stmtCheck->close();

			$stmt = $mysqli->prepare("UPDATE users SET username = ?, last_modified_date = ?, modified_time = ? , last_modified_user = ?, contact_num = ?, email = ? WHERE id = ?");
			$stmt->bind_param("ssssssi", $_POST['username'], $modify_date, $modify_time, $_POST['username'], $_POST['contact_num'], $_POST['email'], $current_id);

			$stmt->execute();
			$stmt->close();

			// query for fetch selected username data from user table

			$stmt = $mysqli->prepare("SELECT password, role,login_attempt, last_login_date, creation_date, creation_time, creation_user, current_session_id, status, ip_address, browser FROM users WHERE id = ?");
			$stmt->bind_param("i", $current_id);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($password, $role, $login_attempt, $last_login_date, $creation_date, $creation_time, $creation_user, $current_session_id, $status, $ip_address, $browser);
			$stmt->fetch();
			$stmt->close();


			// query to insert selected data from user table to userlog table 

			$stmtlog = $mysqli->prepare("INSERT INTO userlog (user_id, mode, username, password, role, login_attempt, last_login_date, creation_date, creation_time, creation_user,  last_modified_date, modified_time, last_modified_user, current_session_id, status, contact_num, email, ip_address, browser) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmtlog->bind_param("issssisssssssssssss", $current_id, $mode, $_POST['username'], $password, $role,  $login_attempt, $last_login_date, $creation_date, $creation_time, $creation_user, $modify_date, $modify_time, $_POST['username'], $current_session_id, $status, $_POST['contact_num'], $_POST['email'], $ip_address, $browser);

			$stmtlog->execute();
			$stmtlog->close();

			echo "Success";
		}
	}
}



mysqli_close($mysqli);
