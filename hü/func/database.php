<?php

require_once "config.php";
function openDataBaseConnection() {
	//https://www.php-einfach.de/mysql-tutorial/crashkurs-mysqli/
	$con = new mysqli(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);
	if($con === false){
		die("Keine Datenbank-Verbindung");
	}
	return $con;
}


function createTestUser(){
	//https://www.php.net/manual/de/function.password-hash.php
	$connection = openDataBaseConnection();
	$pwd = password_hash("test", PASSWORD_BCRYPT);
	$connection->query("INSERT INTO `employee` (`username`, `firstname`, `lastname`, `roleid`, `image`, `teamid`, `email`, `password`)
		VALUES ('musterfrau','Maxine', 'Musterfrau', '3', NULL, NULL, 'musterfrau@beispiel.at', '".$pwd."');");

	$pwd2 = password_hash("test2", PASSWORD_BCRYPT);
	$connection->query("INSERT INTO `employee` (`username`,`firstname`, `lastname`, `roleid`, `image`, `teamid`, `email`, `password`)
	VALUES ('leiter','Heinrich', 'Helferlein', '2', NULL, NULL, 'heinrich@helferlein.at', '".$pwd2."');");

	$pwd3 = password_hash("test3", PASSWORD_BCRYPT);
	$connection->query("INSERT INTO `employee` (`username`,`firstname`, `lastname`, `roleid`, `image`, `teamid`, `email`, `password`)
	VALUES ('admin','Henrietta', 'Herscher', '1', NULL, NULL, 'hh@hallo.xyz', '".$pwd3."');");



	$connection->close();
}


function login($username, $password) {
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("SELECT employee.id, employee.username, employee.image, employee.firstname, employee.lastname, roleid, teamid, role, team, password FROM employee
	LEFT OUTER JOIN roles ON employee.roleid = roles.id
	LEFT OUTER JOIN teams ON employee.teamid = teams.id WHERE username = ?");
	$statement->bind_param("s", $username);
	$statement->execute();

	$result = $statement->get_result();
	if ($result->num_rows > 0) {
		 while($row = $result->fetch_assoc()) {
			 //https://www.php.net/manual/de/function.password-verify.php
			 if(password_verify($password, $row['password'])){
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['user'] = $row['username'];
				$_SESSION['user_name'] = $row['firstname'] . ' ' . $row['lastname'];
				$_SESSION['role'] = $row['roleid'];
				$_SESSION['role_name'] = $row['role'];
				$_SESSION['team'] = $row['team'];
				$_SESSION['team_id'] = $row['teamid'];
				$_SESSION['image'] = $row['image'];
				$connection->close();
				return true;
			 }
		 }
	}
	$connection->close();
	return false;
}

function allEmployees(){
	$connection = openDataBaseConnection();
	$result = $connection->query("SELECT employee.id, employee.username, employee.image, employee.firstname, employee.lastname, employee.email, roleid, teamid, role, team FROM employee
	LEFT OUTER JOIN roles ON employee.roleid = roles.id
	LEFT OUTER JOIN teams ON employee.teamid = teams.id");
	//https://www.php.net/manual/de/mysqli-result.fetch-assoc.php
	$daten = [];
	foreach($result as $row) {
		$daten[] = $row;
	}
	$connection->close();
	return $daten;
}

function employeeWithId($id){
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("SELECT employee.id, employee.username, employee.image, employee.firstname, employee.lastname, employee.email, roleid, teamid, role, team FROM employee
	LEFT OUTER JOIN roles ON employee.roleid = roles.id
	LEFT OUTER JOIN teams ON employee.teamid = teams.id
	WHERE employee.id = ?");
	$statement->bind_param("i", $id);
	$statement->execute();
	$result = $statement->get_result();
	//https://www.php.net/manual/de/mysqli-result.fetch-assoc.php
	foreach($result as $row) {
		$connection->close();
		return $row;
	}
	$connection->close();
	return false;
}



function addMessage($message, $userid, $teamid) {
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("INSERT INTO messages (employeeid, teamid, message) VALUES (?,?,?)");
	$statement->bind_param("iis",$userid, $teamid, $message);
	$statement->execute();
	$connection->close();
}

function deleteMessage($id, $teamid) {
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("DELETE FROM messages WHERE id = ? AND teamid = ?");
	$statement->bind_param("ii",$id, $teamid);
	$statement->execute();
	$connection->close();
}

function messages($teamid){
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("SELECT messages.id, messages.message, employee.username, teams.team FROM messages
	INNER JOIN employee ON employee.id = messages.employeeid
	INNER JOIN teams ON teams.id = messages.teamid 
	WHERE teams.id = ?");
	$statement->bind_param("i", $teamid);
	$statement->execute();
	$result = $statement->get_result();
	//https://www.php.net/manual/de/mysqli-result.fetch-assoc.php
	$daten = [];
	foreach($result as $row) {
		$daten[] = $row;
	}
	$connection->close();
	return $daten;
}

function allTeams(){
	$connection = openDataBaseConnection();
	$result = $connection->query("SELECT * FROM teams");
	//https://www.php.net/manual/de/mysqli-result.fetch-assoc.php
	$daten = [];
	foreach($result as $row) {
		$daten[] = $row;
	}
	$connection->close();
	return $daten;
}

function allRights(){
	$connection = openDataBaseConnection();
	$result = $connection->query("SELECT * FROM roles");
	//https://www.php.net/manual/de/mysqli-result.fetch-assoc.php
	$daten = [];
	foreach($result as $row) {
		$daten[] = $row;
	}
	$connection->close();
	return $daten;
}

function logout(){
	//https://www.php.net/manual/de/function.session-unset.php
	session_unset();
}

function changeProfileData($id, $profile){
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("UPDATE employee SET firstname = ?, lastname = ?, email = ?, image = ? WHERE id = ?");
	$statement->bind_param("ssssi",$profile['firstname'], $profile['lastname'], $profile['email'], $profile['image'], $id);
	$statement->execute();
	$connection->close();
}

function updateUserRole($id, $roleid){
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("UPDATE employee SET roleid = ? WHERE id = ?");
	$statement->bind_param("ii",$roleid, $id);
	$r = $statement->execute();
	$connection->close();
}

function updateUserTeam($id, $teamid){
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("UPDATE employee SET teamid = ? WHERE id = ?");
	$statement->bind_param("ii",$teamid, $id);
	$statement->execute();
	$connection->close();
}

function removeUserFromTeam($id){
	$connection = openDataBaseConnection();
	$statement = $connection->prepare("UPDATE employee SET teamid = NULL WHERE id = ?");
	$statement->bind_param("i", $id);
	$statement->execute();
	$connection->close();
}

?>