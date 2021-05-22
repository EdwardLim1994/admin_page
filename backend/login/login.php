<?php

require_once('dbConfig.php');

session_start();

// Check if the user is already logged in, if yes then redirect him to page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	if ($_SESSION["role"] == "administrator" or $_SESSION['role'] == "staff") {
		header("location: ../../menu.php");
	} else {
		header("location: ../../normal.php");
	}
	exit;
}

if (isset($_POST)) {
	$username = $_POST['username'];
	$enterPassword = $_POST['password'];

	$stmt = $mysqli->prepare("SELECT id, username, password, role, login_attempt, status FROM users WHERE username = ?");
	$stmt->bind_param("s", $username);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows == 1) {
		// Bind result variables
		$stmt->bind_result($id, $username, $password, $role, $login_attempt, $status);

		while ($stmt->fetch()) {

			if ($status == "active") {

				if (password_verify($enterPassword, $password)) {

					$ip_address = $_POST['ip_address'];
					$browser = $_POST['browser'];

					//$ip_address = "dummy ip";
					//$browser = "dumy browser";

					// update last login date after success login
					$stmt->close();
					$login_attempt = 0;
					session_regenerate_id(TRUE); 					// generate new session id each time login
					$curr_session_id = session_id();				// generate new session id each time login
					date_default_timezone_set("Asia/Kuala_Lumpur");
					$login_date = date("Y-m-d");
					$stmtLogin = $mysqli->prepare("UPDATE users SET last_login_date = ?, login_attempt = ?, current_session_id = ?, ip_address = ?, browser = ? WHERE username = ?");
					//$stmtLogin->bind_param("sissss", $login_date, $login_attempt, $curr_session_id, $_POST['ip_address'], $_POST['browser'], $username);  // for production
					$stmtLogin->bind_param("sissss", $login_date, $login_attempt, $curr_session_id, $_POST['ip_address'], $_POST['browser'], $username);
					$stmtLogin->execute();
					$stmtLogin->close();


					// Store data in session variables
					$_SESSION["loggedin"] = true;
					$_SESSION["username"] = $username;
					$_SESSION["id"] = $id;
					$_SESSION["role"] =  $role;
					$_SESSION["currentId"] = $curr_session_id; 		// newest session id

					// Redirect user to page after login

					if ($role == "administrator" || $role == "staff") {
						header("location: ../../menu.php");
					} else {
						header("location: ../../normal.php");
					}

				} else {

					// update login attempt if wrong password when login
					$stmt->close();
					$login_attempt++;
					$hashPass = password_hash($enterPassword, PASSWORD_DEFAULT);
					date_default_timezone_set("Asia/Kuala_Lumpur");
					$creation_date = date("Y-m-d");
					$creation_time = date("H:i:s");
					$mode = "login reject";

					$ip_address = $_POST['ip_address'];
					$browser = $_POST['browser'];

					//$ip_address = "scam ip";   // data for testing
					//$browser = "scam broswer";       // data for testing

					if ($login_attempt > 5) {

						$curr_status = "disabled";
						$stmtLogin = $mysqli->prepare("UPDATE users SET login_attempt = ?, status = ? WHERE username = ?");
						$stmtLogin->bind_param("iss", $login_attempt, $curr_status, $username);
						$stmtLogin->execute();
						$stmtLogin->close();

						$stmtlog = $mysqli->prepare("INSERT INTO userlog (mode, username, password, creation_date, creation_time, ip_address, browser) VALUES (?, ?, ?, ?, ?, ?, ?)");
						$stmtlog->bind_param("sssssss", $mode, $_POST['username'], $hashPass, $creation_date, $creation_time, $ip_address, $browser);
						$stmtlog->execute();
						$stmtlog->close();

						//Display an error message if password is not valid
						$error = "Your account has been disabled due to too many login attempt.";
						header("location: ../../index.php?error=$error");
						//header("location: testdisplay.php?error=$error");
					} else {

						$stmtLogin = $mysqli->prepare("UPDATE users SET login_attempt = ? WHERE username = ?");
						$stmtLogin->bind_param("is", $login_attempt, $username);
						$stmtLogin->execute();
						$stmtLogin->close();

						// query to insert selected data from user table to userlog table 

						$stmtlog = $mysqli->prepare("INSERT INTO userlog (mode, username, password, creation_date, creation_time, ip_address, browser) VALUES (?, ?, ?, ?, ?, ?, ?)");
						$stmtlog->bind_param("sssssss", $mode, $_POST['username'], $hashPass, $creation_date, $creation_time, $ip_address, $browser);
						$stmtlog->execute();
						$stmtlog->close();



						// Display an error message if password is not valid
						$error = "The password you entered was not valid. You have " . (6 - $login_attempt) . " time/s left to try";
						header("location: ../../index.php?error=$error");
						//header("location: testdisplay.php?error=$error");
					}
				}
			} else {

				// Display an error message if account is disbaled or inactive
				$error = "Your account are disabled or inactive";
				header("location: ../../index.php?error=$error");
			}
		}
	} else {
		$error =  "Access deny";
		header("location: ../../index.php?error=$error");
	}
}
