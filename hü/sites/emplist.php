  <!-- ma liste -->
  <div class="container">
    <a href="?">Zurück</a>
    <div class="card">
      <div class="card-body">
        <h1>Mitarbeiter</h1>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Bild</th>
              <th scope="col">Vorname</th>
              <th scope="col">Nachname</th>
              <th scope="col">Email</th>
              <th scope="col">Team</th>
              <th scope="col">Rolle</th>
              <th scope="col">Bearbeiten</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (allEmployees() as $ds) { ?>
              <tr>
                <td>
                  <?php if(isset($ds['image'])){
                  ?>
                   <img style="max-height:50px" class="rounded img-thumbnail" src="bilder/<?php echo $ds['image'] ?>">
                  <?php } ?>
                </td>
                <td><?php echo $ds['firstname'] ?></td>
                <td><?php echo $ds['lastname'] ?></td>
                <td><?php echo $ds['email'] ?></td>
                <td><?php echo $ds['team'] ?></td>
                <td><?php echo $ds['role'] ?></td>
                <td>
                  <a href="?page=profile&id=<?php echo $ds['id'] ?>" class="btn btn-primary btn-sm">Bearbeiten</a>
                  <?php if(isUserAdmin()) { ?> 
                    <div class="btn btn-danger btn-sm">Löschen</div>
                  <?php } ?>
                  
                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>