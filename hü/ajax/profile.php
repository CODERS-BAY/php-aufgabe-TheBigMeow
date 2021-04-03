<?php 
session_start();
//user funktionen
require_once "../func/user.php";

//datenbank funktionen
require_once "../func/database.php";

if(userLoggedIn()){
    $data['firstname'] = $_POST['firstname'];
    $data['lastname'] = $_POST['lastname'];
    $data['email'] = $_POST['email'];
    $data['image'] = null;
    if(isset($_FILES['file']['name'])){
        $filename = $_FILES['file']['name'];
        $data['image'] = $filename;
        $location = "../bilder/".basename($filename);
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        $valid_extensions = array("jpg","jpeg","png");
        $response = 0;
        if(in_array(strtolower($imageFileType), $valid_extensions)) {
           if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
              $response = $location;
           }
        }
     }
     changeProfileData(userId(), $data);
     $_SESSION['image'] = $data['image'];
     echo "true";
     return;
}
echo "false";

?>