<?php
  //https://www.php.net/manual/de/function.session-start.php
  session_start();

  //user funktionen
  require_once "func/user.php";
  //datenbank funktionen
  require_once "func/database.php";

  if(isset($_POST['action']) && $_POST['action'] == 'logout') {
    logout();
  }

  if(isset($_POST['login_user']) && isset($_POST['login_password'])){
    login($_POST['login_user'], $_POST['login_password']);
  }
?> 
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <title>Mitarbeiter Verwaltung!</title>
  <!-- jquery -->
  <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
</head>

<body>

<div class="container">
  <h1 class="display-1">Mitarbeiterverwaltung</h1>
</div>
<!-- wenn benutzer angemeldet -->
<?php if(userLoggedIn()) { 
   if(isset($_GET['page']) && $_GET['page'] == 'profile'){
    include("sites/profile.php");  
   }else if (isset($_GET['page']) && $_GET['page'] == 'emp'){
    include("sites/emplist.php");  
   }else {
    include("sites/home.php");  
   }
   
  
?>
    
<!-- wenn benutzer nicht angemeldet -->
<?php } else {
   include("sites/login.php");
   //createTestUser();
} ?>
</body>

</html>