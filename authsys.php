<?php
$my_area = "Minecraft RCON Console";
//SETUP for user-account(s) using "username" => password_hash("your_password",PASSWORD_DEFAULT)
//default user-data is "admin" and "1234abcd"
//to generate a new hash from the web just call authsys.php?generate_password=your_password
$login_data = ["admin" => '$2y$10$1PGI0jsBj8w413SvbriuZOFHgiqqtu3aXgC2.cNwP4vGKIGqmDUAO'];

//Time after logging out of current session.
//(e.g. 5 * 60) = 5 minutes.
//If you don't want to be logged out assign 0.
$logout = 0;

session_start();
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SESSION['LAST_ACTIVITY'])) {
	$_SESSION['LAST_ACTIVITY'] = time();
    header('WWW-Authenticate: Basic realm="' . $my_area . '"');
    auth_fail();
} else {
	if (!isset($login_data[$_SERVER['PHP_AUTH_USER']])) {
		auth_fail();
	}
	if (!password_verify((string) $_SERVER["PHP_AUTH_PW"], $login_data[$_SERVER["PHP_AUTH_USER"]])) {
        auth_fail();
	} else {
		if ($logout != 0) {
			$_SESSION['LOGOUT_TIME'] = $logout;
		}
	}
	if (isset($_GET["generate_password"])) {
        exit(
            password_hash((string) $_GET["generate_password"], PASSWORD_DEFAULT)
        );
	}
}

function auth_fail(): never {
	header('HTTP/1.0 401 Unauthorized');
	echo 'Authorization failed!';
	exit;
}

?>
