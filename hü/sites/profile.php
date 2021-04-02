  <div class="container">
    <a href="?">Zurück</a>
    <?php
    $user = employeeWithId($_GET['id']);
    //alles nur anzeigen wenn es einen benutzer gibt 
    if ($user) {
    ?>
      <div class="card">
        <div class="card-body">
        <div class="alert alert-success" id="successfully-saved" style="display:none;" role="alert">
          Erfolgreich gespeichert
        </div>

          <h1>Profil von <?php echo $user["username"] ?></h1>
          <?php
          //nur anzeigen wenn der benutzer der angemeldete benutzer ist
          if (userId() == $_GET['id']) { ?>
            <form id="profile-form">
              <div class="form-group">
                <label for="inputFirstName">Vorname</label>
                <input type="text" class="form-control" id="inputFirstName" name="firstname" value="<?php echo $user['firstname'] ?>">
              </div>
              <div class="form-group">
                <label for="inputLastName">Nachname</label>
                <input type="text" class="form-control" id="inputLastName" name="lastname" value="<?php echo $user['lastname'] ?>">
              </div>
              <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="text" class="form-control" id="inputEmail" name="email" value="<?php echo $user['email'] ?>">
              </div>
              <div class="mb-3">
                <label for="formFile" class="form-label">Bild wählen</label>
                <input class="form-control" type="file" id="formFile" name="file">
              </div>
              <button type="button" id="update-user-profile" class="btn btn-primary">Speichern</button>
            </form>
          <?php } ?>


          <?php if (isUserLeader()) { ?>
            <hr />
            <?php if (isset($user['teamid'])) { ?>
              <span>Benutzer ist bereits in Team</span>
              <?php if (isUserLeaderOfTeam($user["team"])){
              ?>
                <form id="remove-user-from-team-form">
                  <input type="hidden" name="userid" value="<?php echo $user['id'] ?>" />
                  <input type="hidden" name="delete-from-team" value="true" />
                 <div id="remove-user-from-team" class="btn btn-primary">Benutzer aus Team entfernen</div>
                </form>
            
              <?php }?>
            <?php } else { ?>
            <form id="team-form">
              <input type="hidden" name="userid" value="<?php echo $user['id'] ?>" />
              <div class="form-group">
                <label for="exampleFormControlSelect1">Team</label>
                <select class="form-control" id="exampleFormControlSelect1" name="teamid">
                  <?php foreach (allTeams() as $team) { ?>
                    <option value="<?php echo $team['id'] ?>"><?php echo $team['team'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div id="add-user-to-team" class="btn btn-primary">Speichern</div>
              </form>
            <?php } ?>

          <?php } ?>

          <?php if (isUserAdmin()) { ?>
          <form id="role-form">
            <input type="hidden" name="userid" value="<?php echo $user['id'] ?>" />
            <div class="form-group">
              <label for="exampleFormControlSelect2">Rechte</label>
              <select class="form-control" id="exampleFormControlSelect2" name="roleid">
                <?php foreach (allRights() as $r) { ?>
                  <option
                   <?php if($r['id'] == $user['roleid']) { echo "selected"; } ?>
                   value="<?php echo $r['id'] ?>"><?php echo $r['role'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div id="change-user-role" class="btn btn-primary">Speichern</div>
            </form>
          <?php } ?>

        <?php } ?>

        </div>
      </div>
  </div>

<script>
  $(document).ready(function() {
    $('#remove-user-from-team').click(function(){
      console.log('Benutzer von Team entfernen...');
      $('#successfully-saved').hide();
      var form = $('#remove-user-from-team-form')[0];
      var data = new FormData(form);
      $.ajax("ajax/team.php",{
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false, 
        contentType: false,
        success:  function (res) {
          if(res){
            $('#successfully-saved').fadeIn(); 
          }
        }
      });
    });
    $('#add-user-to-team').click(function(){
      console.log('Team update...');
      $('#successfully-saved').hide();
      var form = $('#team-form')[0];
      var data = new FormData(form);
      $.ajax("ajax/team.php",{
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false, 
        contentType: false,
        success:  function (res) {
          if(res){
            $('#successfully-saved').fadeIn(); 
          }
        }
      });
    });
    $('#change-user-role').click(function(){
      console.log('Rollen update...');
      $('#successfully-saved').hide();
      var form = $('#role-form')[0];
      var data = new FormData(form);
      $.ajax("ajax/role.php",{
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false, 
        contentType: false,
        success:  function (res) {
          if(res){
            $('#successfully-saved').fadeIn(); 
          }
        }
      });
    });

    $('#update-user-profile').click(function() {
      $('#successfully-saved').hide();
      console.log('Benutzerprofil update...');
      var form = $('#profile-form')[0];
      var data = new FormData(form);
      $.ajax("ajax/profile.php", {
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false, 
        contentType: false,
        success: function (res) {
          if(res){
            $('#successfully-saved').fadeIn(); 
          }
        }
      })
    });
  });  
</script>