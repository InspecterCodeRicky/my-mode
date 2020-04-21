<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');

   $user = new User();

   if(isset($_SESSION['loggedAdmin'])) {
       header('location: index.php');
       exit();
   }
   $errorEmail = false;
   $errorPassword = false;
   $errorLastname = false;
   $errorFirstname = false;
   $errorPhone = false;
   $errorGenre = false;
   $errorKey = false;


   if(isset($_POST['lastname'], $_POST['key'], $_POST['firstname'], $_POST['email'], $_POST['password'], $_POST['phone'])) {
       if (!isset($_POST['genre']) && empty($_POST['genre'])) {
           $errorGenre = "Selectionnner votre genre";
       }else if(empty($_POST['firstname'])) {
           $errorFirstname = "Champs vide";
       }else if(empty($_POST['lastname'])) {
           $errorLastname = "Champs vide";
       }else if (empty($_POST['phone'])) {
           $errorPhone = "Champs vide";
       }else if (empty($_POST['email'])) {
           $errorEmail = "Champs vide";
       }else if (empty($_POST['password'])) {
           $errorPassword = "Champs vide";
       }else if (empty($_POST['key'])) {
           $errorKey = "Champs vide";
       }else {
           $email = $_POST['email'];
           $password = $_POST['password'];
           $lastname = $_POST['lastname'];
           $firstname = $_POST['firstname'];
           $phone = $_POST['phone'];
           $genre = $_POST['genre'];
           $key = $_POST['key'];

           // check validation email
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $errorEmail =  "L'adresse email '.$email.' est considérée comme invalide.";
           }
           // check form phone valid
           if (!is_numeric($phone)) {
              $errorPhone = "le numéro de téléphone : '.$phone.' est considérée comme invalide.";
           }
           if($key !== "Virtual-Key") {
             $errorKey = "cette clé n'est pas valide";
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
           if($errorEmail == false && $errorPassword == false && $errorKey == false && $errorLastname == false && $errorFirstname == false && $errorPhone == false) {
               $users = $user->register_user($email, $password, $lastname, $firstname, $genre, $phone);

               $obj = json_decode($users);
               if($obj->{'error'}) {
                   $errorEmail = $obj->{'error'};
               }
           }
       }
   }

   ?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Mode</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link type="text/css" href="css/theme.css" rel="stylesheet">
      <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
      <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
   </head>
   <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <a class="navbar-brand" href="index.php">My Mode</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
               <li class="nav-item">
                  <a class="nav-link" href="login.php">Se connecter</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">Support</a>
               </li>
            </ul>
         </div>
      </nav>
      <div class="wrapper">
         <div class="container">
            <div class="row">
               <div class="col-6 offset-3">
                  <div class="module module-login mt-0">
                     <form method="post" class="form-vertical">
                        <div class="module-head">
                           <h3>S'inscrire</h3>
                        </div>
                        <div class="module-body">
                           <div class="control-group row">
                              <div class="col-12">
                                 <?php if($errorGenre) ?> <small class="error ml-3 form-text"> <?= $errorGenre ?> </small>
                                 <label class="radio mr-4">
                                 <input name="genre" value="Homme" type="radio" <?php if(isset($_POST['genre']) && $_POST['genre'] == 'Homme') { echo 'checked'; } ?>> Homme
                                 </label>
                                 <label class="radio">
                                 <input name="genre" value="Femme" type="radio" <?php if(isset($_POST['genre']) && $_POST['genre'] == 'Femme') { echo 'checked'; } ?>> Femme
                                 </label>
                              </div>
                           </div>
                           <div class="control-group row">
                              <div class="col-6">
                                 <div class="controls row-fluid">
                                    <label for="lastname">Prénom</label>
                                    <input class="form-control" type="text" name="firstname" placeholder="Prénom" value="<?php if((isset($_POST['firstname']))) { echo $_POST['firstname']; } ?>">
                                    <?php if($errorFirstname) ?> <small class="error form-text"> <?php echo $errorFirstname ?> </small>
                                 </div>
                              </div>
                              <div class="col-6">
                                 <div class="controls row-fluid">
                                    <label for=""firstname>Nom</label>
                                    <input class="form-control" type="text" name="lastname" placeholder="Nom" value="<?php if((isset($_POST['lastname']))) { echo $_POST['lastname']; } ?>">
                                    <?php if($errorLastname) ?> <small class="error form-text"> <?php echo $errorLastname ?> </small>
                                 </div>
                              </div>
                           </div>
                           <div class="control-group">
                              <div class="controls row-fluid">
                                 <label for="lastname">Téléphone</label>
                                 <input class="form-control" type="text" name="phone" placeholder="Téléphone" value="<?php if((isset($_POST['phone']))) { echo $_POST['phone']; } ?>">
                                 <?php if($errorPhone) ?> <small class="error form-text"> <?php echo $errorPhone ?> </small>
                              </div>
                           </div>
                           <div class="control-group">
                              <div class="controls row-fluid">
                                 <label for="">Email</label>
                                 <input class="form-control" type="text" name="email" placeholder="Email" value="<?php if((isset($_POST['email']))) { echo $_POST['email']; } ?>">
                                 <?php if($errorEmail) ?> <small class="error form-text"> <?php echo $errorEmail ?> </small>
                              </div>
                           </div>
                           <div class="control-group">
                              <div class="controls row-fluid">
                                 <label for="">Mot de passe</label>
                                 <input class="form-control" type="password" name="password" placeholder="Mot de passe" value="<?php if((isset($_POST['password']))) { echo $_POST['password']; } ?>">
                                 <?php if($errorPassword) ?> <small class="error form-text"> <?php echo $errorPassword ?> </small>
                              </div>
                           </div>
                           <div class="control-group">
                              <div class="controls row-fluid">
                                 <label for="">La clé d'acces</label>
                                 <input class="form-control" type="text" name="key" placeholder="Clé d'acces" value="<?php if((isset($_POST['key']))) { echo $_POST['key']; } ?>">
                                 <?php if($errorKey) ?> <small class="error form-text"> <?php echo $errorKey ?> </small>
                              </div>
                           </div>
                        </div>
                        <div class="module-foot">
                           <div class="control-group">
                              <div class="controls clearfix">
                                 <button type="submit" class="btn btn-primary pull-right">S'inscrire</button>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--/.wrapper-->
      <!--/.wrapper-->
      <?php include_once('includes/footer.php'); ?>
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <script src="https://cdn.tiny.cloud/1/74dynsu9ax3oqpzblnl0wgz3ebpmpu9howykdxz8gjg5gamd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
   </body>
</html>
