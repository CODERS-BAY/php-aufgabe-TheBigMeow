 <!-- Startseite -->

<?php
  //wenn neue nachricht
  if(isset($_POST['message'])){
    addMessage($_POST['message'], userId(), userTeamId());
  }

  //wenn nachricht löschen
  if(isUserLeader() && isset($_POST['deleteid'])){
    deleteMessage($_POST['deleteid'], userTeamId());
  }
?>

 <div class="container">
   <div class="card">
     <div class="card-body">
       <h1>Startseite</h1>
       <span><?php echo userImage() ?></span>
       <h2>Hallo <?php echo userName() ?> du bist in <?php echo userTeam() ?> </h2>
       <div class="row">
         <div class="col-sm">
           <a href="?page=profile&id=<?php echo userId() ?>" class="btn btn-primary">Profil ändern</a>
         </div>
         <div class="col-sm">
           <a href="?page=emp" class="btn btn-primary">Mitarbeiterliste</a>
         </div>
         <div class="col-sm">
           <form method="POST" action="">
             <input type="hidden" value="logout" name="action" />
             <button type="submit" class="btn btn-primary">Ausloggen</button>
           </form>
         </div>
         <div class="col-12">
          <hr />
           <?php if (isUserInTeam()) { ?>
              <form method="POST">
                <div class="mb-3">
                  <label for="newMessage" class="form-label">Neue Nachricht</label>
                  <textarea class="form-control" id="newMessage" name="message" rows="3"></textarea>
                </div>
                <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Abschicken</button>
              </div>
              </form>
           <?php } else { ?>
             <strong>Du bist in keine Team und kannst damit keine Team-Nachrichten ertellen</strong>
           <?php } ?>
           <hr />
          
           <?php 
              //nur wenn in team!
              if(isUserInTeam()) {
                foreach (messages(userTeamId()) as $ds) {
            ?>
                <div class="card">
                  <div class="card-header">
                    Nachricht von <?php echo $ds["username"] ?> - Team <?php echo $ds["team"] ?>
                  </div>
                  <div class="card-body">
                    <p class="card-text">
                      <?php echo $ds["message"] ?>
                    </p>
                    <?php if (isUserLeaderOfTeam($ds["team"])) { ?>
                      <form method="POST">
                        <input type="hidden" name="deleteid" value="<?php echo $ds['id'] ?>" />
                        <button type="submit" class="btn btn-danger">Löschen</a>
                      </form>
                    
                    <?php } ?>
                  </div>
                </div>
           <?php }
           } ?>
         </div>
       </div>
     </div>
   </div>
 </div>