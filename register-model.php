<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');

   $user = new User();

   if(isset($_SESSION["logged_in"])) {
       header("Location: my-profile.php");
       exit();
   }
   // register a model
   $errorEmail = false;
   $errorPassword = false;
   $errorLastname = false;
   $errorFirstname = false;
   $errorPhone = false;
   $errorGenre = false;
   $errorPhoto = false;
   $errorBirthday = false;
   // function get $age
   function getAge($birthDate) {
     $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
      ? ((date("Y") - $birthDate[2]) - 1)
      : (date("Y") - $birthDate[2]));
     return $age;
   }

   if(isset($_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['password'], $_POST['phone'], $_POST['birthday'], $_FILES["fileToUpload"])) {

       if (!isset($_POST['genre']) && empty($_POST['genre'])) {
           $errorGenre = "Selectionnner votre genre";
       }else if($_FILES["fileToUpload"]["name"]== null) {
           $errorPhoto = "Choisissez une photo de profil";
       }else if(empty($_POST['lastname'])) {
           $errorLastname = "Champs vide";
       }else if(empty($_POST['birthday'])) {
           $errorBirthday = "Champs vide";
       }else if(empty($_POST['firstname'])) {
           $errorFirstname = "Champs vide";
       }else if (empty($_POST['phone'])) {
           $errorPhone = "Champs vide";
       }else if (empty($_POST['email'])) {
           $errorEmail = "Champs vide";
       }else if (empty($_POST['password'])) {
           $errorPassword = "Champs vide";
       }else {
           $email = $_POST['email'];
           $password = $_POST['password'];
           $lastname = $_POST['lastname'];
           $firstname = $_POST['firstname'];
           $birthday = date('d-m-Y' , strtotime($_POST['birthday']));
           $phone = $_POST['phone'];
           $genre = $_POST['genre'];

           // check validation email
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $errorEmail =  "L'adresse email '$email' est considérée comme invalide.";
           }
           // check age > 18
           $birthDate = explode("-",$birthday);
           if(getAge($birthDate) < 18) {
             $errorBirthday = "Vous devez êtes majeur !";
           }

           // check form phone valid
           if (!is_numeric($phone)) {
              $errorPhone = "le numéro de téléphone : '$phone' est considérée comme invalide.";
           }

           // check image
           $target_dir = "img/talents/";
           $target_file = $target_dir.time().'-'.basename($_FILES["fileToUpload"]["name"]);
           $target_file = str_replace(' ', '', $target_file);
           $uploadOk = 1;
           $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
           $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
           if($check !== false) {
               $uploadOk = 1;
           } else {
               $errorPhoto = "Le fichier n'est pas une image.";
               $uploadOk = 0;
           }
           // Allow certain file formats
           if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
           && $imageFileType != "gif" ) {
               $errorPhoto = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
               $uploadOk = 0;
           }
           if ($uploadOk == 0) {
               $errorPhoto = "Désolé, votre fichier n'a pas été téléchargé.";
           } else { // if everything is ok, try to upload file
               if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                   $success =  "Le fichier ". basename( $_FILES["fileToUpload"]["name"]). " a été téléchargé.";
               } else {
                   $errorPhoto = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
               }
           }

           // Validate password strength
           $uppercase = preg_match('@[A-Z]@', $password);
           $lowercase = preg_match('@[a-z]@', $password);
           $number    = preg_match('@[0-9]@', $password);
           // $specialChars = preg_match('@[^\w]@', $password); // à faire pour les caracters speciaux

           if(!$uppercase || !$lowercase || !$number ||  strlen($password) < 8) {
               $errorPassword = "Le mot de passe doit comporter au moins 8 caractères et doit comprendre au moins une lettre majuscule, un chiffre et un caractère spécial.";
           }

           // if not error input
           if($errorEmail == false && $errorPassword == false && $errorLastname == false && $errorFirstname == false && $errorPhone == false && $errorPhoto == false && $errorBirthday == false && $errorGenre == false) {
               $target_file = $target_file.'|';
               $users = $user->register_model($email, $password, $lastname, $firstname, $genre, $birthday, $phone, $target_file);

               $obj = json_decode($users);
               if($obj->{'error'}) {
                   $errorEmail = $obj->{'error'};
               }
           }
       }

   }
   ?>
<!doctype html>
<html lang="fr">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>My Mode</title>
      <link rel="icon" href="img/favicon.png">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- animate CSS -->
      <link rel="stylesheet" href="css/animate.css">
      <!-- themify CSS -->
      <link rel="stylesheet" href="css/themify-icons.css">
      <!-- style CSS -->
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/responsive.min.css">
   </head>
   <body>
      <div class="container-login100">
         <!-- <div class="row"> -->
         <div class="wrap_form_auth_inner custom_input_file">
            <div class="wrap_auth">
               <nav class="navbar navbar-light shadow-sm bg-white">
                  <a class="navbar-brand ml-md-5 m-auto" href="index.php">
                  <img src="img/logo.png" alt="logo">
                  </a>
               </nav>
               <h2 class="mb-4">Devenir un model</h2>
               <form class="form_auth_iner _form" method="POST" enctype="multipart/form-data">
                  <div class="row">
                     <?php if($errorGenre) ?> <small class="error ml-3 form-text"> <?= $errorGenre ?> </small>
                     <div class="col-12 switch-wrap d-flex">
                        <p>Homme</p>
                        <div class="primary-radio">
                           <input type="radio" name="genre" value="Homme" id="homme" <?php if(isset($_POST['genre']) && $_POST['genre'] == 'Homme') { echo 'checked'; } ?>>
                           <label for="homme"></label>
                        </div>
                        <p>Femme</p>
                        <div class="primary-radio">
                           <input type="radio" name="genre" value="Femme" id="femme" <?php if(isset($_POST['genre']) && $_POST['genre'] == 'Femme') { echo 'checked'; } ?>>
                           <label for="femme"></label>
                        </div>
                     </div>
                     <div class="col-12 mb-md-4">
                        <div class="DropZone__Preview">
                           <div id="img_Preview" class="DropZone__Preview--add">
                              <input name="fileToUpload" id="preview_input" multiple type="file"/>
                              <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                           </div>
                        </div>
                        <!-- <input type="file" name="fileToUpload" id="fileToUpload"> -->
                        <?php if($errorPhoto) ?> <small class="error form-text"> <?php echo $errorPhoto ?> </small>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="text" class="form-control" name="lastname" placeholder="Nom" value="<?php if((isset($_POST['lastname']))) { echo $_POST['lastname']; } ?>">
                        <?php if($errorLastname) ?> <small class="error form-text"> <?php echo $errorLastname ?> </small>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="text" class="form-control" name="firstname" placeholder="Prénom" value="<?php if((isset($_POST['firstname']))) { echo $_POST['firstname']; } ?>">
                        <?php if($errorFirstname) ?> <small class="error form-text"> <?php echo $errorFirstname ?> </small>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="date" class="form-control" name="birthday" placeholder="Âge" value="<?php if((isset($_POST['birthday']))) { echo $_POST['birthday']; } ?>">
                        <?php if($errorBirthday) ?> <small class="error form-text"> <?php echo $errorBirthday ?> </small>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="text" class="form-control" name="phone" placeholder="Téléphone" value="<?php if((isset($_POST['phone']))) { echo $_POST['phone']; } ?>">
                        <?php if($errorPhone) ?> <small class="error form-text"> <?php echo $errorPhone ?> </small>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="text" class="form-control" name="email" placeholder="Email" value="<?php if((isset($_POST['email']))) { echo $_POST['email']; } ?>">
                        <?php if($errorEmail) ?> <small class="error form-text"> <?php echo $errorEmail ?> </small>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="password" class="form-control" name="password" placeholder="Mot de passe" value="<?php if((isset($_POST['password']))) { echo $_POST['password']; } ?>">
                        <?php if($errorPassword) ?> <small class="error form-text"> <?php echo $errorPassword ?> </small>
                     </div>
                     <div class="col-12 mb-4">
                        <a class="text-secondary" href="login.php">j'ai déjà un compte</a>
                     </div>
                     <div class="col-12 mb-md-4">
                        <button type="submit" class="btn_1 w-100">S'inscrire</button>
                     </div>
                  </div>
               </form>
            </div>
            <div class="bg_auth_iner" style="background-image: url(img/post/emma.jpg);"></div>
         </div>
         <!-- </div> -->
      </div>
   </body>
   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
   <script type="text/javascript">
      function getBase64(file, name) {
         var reader = new FileReader();
         reader.readAsDataURL(file);
         reader.onload = function () {
           var base64 =reader.result;
           $('.DropZone__Preview--add').css("background-image", "url(" + base64 + ")")
           $('.DropZone__Preview--add').css("background-size", "auto 100%")
           return base64
         };
         reader.onerror = function (error) {
           console.log('Error: ', error);
         };
      }

      $('#preview_input').on('change click', function() {
        if (this.files && this.files.length) {
          var file = this.files[0];
          const acceptedImageTypes = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
          console.log(file['type']);
          if(!acceptedImageTypes.includes(file['type'])) {
            alert("Ce fichier n'est pas une image.")
          } else {
            getBase64(file, $(this).attr("name"));
          }
        } else {
          $('.DropZone__Preview--add').css("background-image", "url(images/icons/camera.svg)")
          $('.DropZone__Preview--add').css("background-size", "auto")
        }
      })
   </script>
</html>
