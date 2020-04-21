<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');

   $user = new User();

   if(isset($_SESSION["logged_in"])) {
       header("Location: my-profile.php");
       exit();
   }
   // register a user normal
   $errorEmail = false;
   $errorPassword = false;
   $errorLastname = false;
   $errorFirstname = false;
   $errorPhone = false;
   $errorGenre = false;


   if(isset($_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['password'], $_POST['phone'])) {
       if (!isset($_POST['genre']) && empty($_POST['genre'])) {
           $errorGenre = "Selectionnner votre genre";
       }else if(empty($_POST['lastname'])) {
           $errorLastname = "Champs vide";
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
           $phone = $_POST['phone'];
           $genre = $_POST['genre'];

           // check validation email
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $errorEmail =  "L'adresse email '$email' est considérée comme invalide.";
           }

           // check form phone valid
           if (!is_numeric($phone)) {
              $errorPhone = "le numéro de téléphone : '$phone' est considérée comme invalide.";
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
           if($errorEmail == false && $errorPassword == false && $errorLastname == false && $errorFirstname == false && $errorPhone == false && $errorGenre == false) {
               $users = $user->register_user($email, $password, $lastname, $firstname, $genre, $phone);

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
         <div class="wrap_form_auth_inner">
            <div class="wrap_auth">
               <nav class="navbar navbar-light shadow-sm bg-white">
                  <a class="navbar-brand ml-md-5 m-auto" href="index.php">
                  <img src="img/logo.png" alt="logo">
                  </a>
               </nav>
               <h2 class="mb-4">Créer un compte </h2>
               <form method="POST" class="form_auth_iner _form" action="">
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
                        <input type="text" class="form-control" name="lastname" placeholder="Nom" value="<?php if((isset($_POST['lastname']))) { echo $_POST['lastname']; } ?>">
                        <?php if($errorLastname) ?> <small class="error form-text"> <?php echo $errorLastname ?> </small>
                     </div>
                     <div class="col-12 mb-md-4">
                        <input type="text" class="form-control" name="firstname" placeholder="Prénom" value="<?php if((isset($_POST['firstname']))) { echo $_POST['firstname']; } ?>">
                        <?php if($errorFirstname) ?> <small class="error form-text"> <?php echo $errorFirstname ?> </small>
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
                     <div class="col-12 mb-4 d-flex justify-content-between">
                        <a class="text-secondary" href="login.php">j'ai déjà un compte</a>
                        <a class="text-secondary" href="register-model.php">Devenir un model</a>
                     </div>
                     <div class="col-12 mb-md-4">
                        <button type="submit" class="btn_1 w-100">S'inscrire</button>
                     </div>
                  </div>
               </form>
            </div>
            <div class="bg_auth_iner" style="background-image: url(img/gallery/register.jpg);"></div>
         </div>
      </div>
   </body>
</html>
