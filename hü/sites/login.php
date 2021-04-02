 <!-- login -->
 <div class="container">
   <?php
    if (isset($_POST['login_user']) && isset($_POST['login_password'])) {
      echo '<div class="alert alert-danger" role="alert">Falsche Anmeldedaten</div>';
    }

    ?>
   <div class="card">
     <div class="card-body">
       <h1>Login</h1>
       <form method="POST" action="">
         <div class="form-group">
           <label for="inputEmail">Benutzername</label>
           <input type="text" name="login_user" class="form-control" id="inputEmail">
         </div>
         <div class="form-group">
           <label for="inputPassword">Passwort</label>
           <input type="password" name="login_password" class="form-control" id="inputPassword">
         </div>
         <button type="submit" class="btn btn-primary">Anmelden</button>
       </form>
     </div>
   </div>
 </div>