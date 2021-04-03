<?php 
session_start();
//user funktionen
require_once "../func/user.php";

//datenbank funktionen
require_once "../func/database.php";

if(userLoggedIn() && isUserLeader() && isset($_POST['userid'])  && isset($_POST['teamid'])){
    updateUserTeam($_POST['userid'], $_POST['teamid']);
    echo "true";
    return;
}

if(userLoggedIn() && isUserLeader() && isset($_POST['delete-from-team']) && isset($_POST['userid'])){
    removeUserFromTeam($_POST['userid']);
    echo "true";
    return;
}

echo "false";
?>