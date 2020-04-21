<?php
if(!empty($_FILES['picture']['name'])){
    //Include database configuration file
    include_once 'connection.php';
    include_once 'users.php';

    $user = new User();
    $user_current = $user->get_user_talent_by_email($_SESSION['email'], $_SESSION['type_profile']);
  if($user_current) {
      $photos = $user_current['photos'];

      //File uplaod configuration
      $result = 0;
      $uploadDir = "../img/talents/";
      $fileName = time().'_'.basename($_FILES['picture']['name']);
      $targetPath = $uploadDir. $fileName;

      //Upload file to server
      if(move_uploaded_file($_FILES['picture']['tmp_name'], $targetPath)){
          //Get current user ID from session
          $userId = 1;
          $newFilesPhotos = $photos.'img/talents/'.$fileName.'|';
          $email = $_SESSION['email'];
          //Update photos in the database talents
          $update = $pdo->prepare("UPDATE talents SET photos = ? WHERE email = ?");
          $update->bindValue(1, $newFilesPhotos);
          $update->bindValue(2, $email);
          $update->execute();

          //Update status
          if($update){
              $result = 1;
          }
      }
    }

    //Load JavaScript function to show the upload status
    echo '<script type="text/javascript">window.top.window.completeUpload(' . $result . ',\'' . $fileName . '\');</script>  ';
}

?>
