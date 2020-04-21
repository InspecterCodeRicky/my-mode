<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');

   $user = new User();

   if(isset($_SESSION['logged_in'])) {
       header('location: my-profile.php');
       exit();
   }

   $errorEmail = false;
   $errorPassword = false;
   $errorTypeProfile = false;
   $errorAuth = false;

   // LOGIN USER
   if(isset($_POST['email'], $_POST['password'])) {
       if(!isset($_POST['type_profile']) && empty($_POST['errorTypeProfile'])) {
           $errorTypeProfile = "Selectionez votre type de profil";
       }else if(empty($_POST['email'])) {
           $errorEmail = "Champs vide";
       }else if (empty($_POST['password'])) {
           $errorPassword = "Champs vide";
       } else {
           $typeProfile = $_POST['type_profile'];
           $email = $_POST['email'];
           $password = $_POST['password'];
           $result = $user->login_user($typeProfile, $email, $password);

           $obj = json_decode($result);
           if($obj->{'error'}) {
               $errorAuth = $obj->{'error'};
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
         <div class="wrap_form_auth_inner">
            <div class="wrap_auth">
               <nav class="navbar navbar-light shadow-sm bg-white">
                  <a class="navbar-brand ml-md-5 m-auto" href="index.php">
                  <img src="img/logo.png" alt="logo">
                  </a>
               </nav>
               <h2 class="mb-4">Se connecter</h2>
               <?php if($errorAuth) ?> <small class="error form-text"> <?= $errorAuth ?> </small>
               <form method="POST" class="form_auth_iner _form" action="">
                  <div class="row">
                     <?php if($errorTypeProfile) ?> <small class="error ml-3 form-text"> <?= $errorTypeProfile ?> </small>
                     <div class="col-12 switch-wrap d-flex">
                        <p>Model</p>
                        <div class="primary-radio">
                           <input type="radio" name="type_profile" value="talents" id="talent" <?php if(isset($_POST['type_profile']) && $_POST['type_profile'] == 'talents') { echo 'checked'; } ?>>
                           <label for="talent"></label>
                        </div>
                        <p>Utilisateur</p>
                        <div class="primary-radio">
                           <input type="radio" name="type_profile" value="users" id="user" <?php if(isset($_POST['type_profile']) && $_POST['type_profile'] == 'users') { echo 'checked'; } ?>>
                           <label for="user"></label>
                        </div>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="text" class="form-control" name="email" placeholder="Email" value="<?php if((isset($_POST['email']))) { echo $_POST['email']; } ?>">
                        <?php if($errorEmail) ?> <small class="error form-text"> <?php echo $errorEmail ?> </small>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="password" class="form-control" name="password" placeholder="Mot de passe" value="<?php if((isset($_POST['password']))) { echo $_POST['password']; } ?>">
                        <?php if($errorPassword) ?> <small class="error form-text"> <?php echo $errorPassword ?> </small>
                     </div>
                     <div class="col-12 mb-4 d-flex justify-content-between">
                        <a class="text-secondary" href="register.php">je n'ai pas de compte</a>
                        <a class="text-secondary" href="register-model.php">Devenir un model</a>
                     </div>
                     <div class="col-12 mb-md-4">
                        <button type="submit" class="btn_1 w-100">Se connecter</button>
                     </div>
                  </div>
               </form>
            </div>
            <div class="bg_auth_iner" style="background-image: url(img/gallery/gallery_item_2.png);"></div>
         </div>
      </div>
   </body>
</html>
