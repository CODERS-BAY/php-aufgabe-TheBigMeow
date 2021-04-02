<?php 

function userLoggedIn(){
	return isset($_SESSION['user']);
}

function userRole(){
	return $_SESSION['role_name'];
}

function userName(){
	return $_SESSION['user_name'];
}

function userTeam(){
	if(isset($_SESSION['team'])){
		return $_SESSION['team'];
	}
	return 'keinem Team';
}

function userImage(){
	if(isset($_SESSION['image'])){
		return '<img class="img-thumbnail" src="bilder/' . $_SESSION['image'] . '" />';
	}
	return '';
}

function userId(){
	return $_SESSION['user_id'];
}

function userTeamId(){
	return $_SESSION['team_id'];
}

function isUserLeader() {
	return $_SESSION['role'] == 2;
}

function isUserLeaderOfTeam($team) {
	return $_SESSION['role'] == 2 && isset($_SESSION['team']) && $_SESSION['team'] == $team;
}

function isUserAdmin() {
	return $_SESSION['role'] == 1;
}

function isUserInTeam(){
	return isset($_SESSION['team']);
}


?>