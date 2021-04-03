<?php 
session_start();
//user funktionen
require_once "../func/user.php";

//datenbank funktionen
require_once "../func/database.php";
if(userLoggedIn() && isUserAdmin() && isset($_POST['userid'])  && isset($_POST['roleid'])){
    updateUserRole($_POST['userid'], $_POST['roleid']);
    echo "true";
    return;
}
echo "false";
?>