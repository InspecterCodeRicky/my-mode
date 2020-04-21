<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');

   $user = new User();
   if(isset($_SESSION['logged'])) {
       header('location: index.php');
       exit();
   }
   $errorEmail = false;
   $errorPassword = false;
   $errorAuth = false;
   // LOGIN USER
   if(isset($_POST['email'], $_POST['password'])) {
     if(empty($_POST['email'])) {
           $errorEmail = "Champs vide";
       }else if (empty($_POST['password'])) {
           $errorPassword = "Champs vide";
       } else {
           $typeProfile = 'users';
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
                  <a class="nav-link" href="register.php">S'inscrire</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">Mot de passe oublié?</a>
               </li>
            </ul>
         </div>
      </nav>
      <div class="wrapper">
         <div class="container">
            <div class="row">
               <div class="col-4 offset-4">
                  <div class="module module-login ">
                     <form method="post" class="form-vertical">
                        <div class="module-head">
                           <h3>Se connecter</h3>
                           <?php if($errorAuth) ?> <small class="error form-text"> <?php echo $errorAuth ?> </small>
                        </div>
                        <div class="module-body">
                           <div class="control-group">
                              <div class="controls row-fluid">
                                 <label for="">Email</label>
                                 <input class="form-control" type="text" name="email" placeholder="Email" alue="<?php if((isset($_POST['email']))) { echo $_POST['email']; } ?>">
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
                        </div>
                        <div class="module-foot">
                           <div class="control-group">
                              <div class="controls clearfix">
                                 <button type="submit" class="btn btn-primary pull-right">Connecter</button>
                                 <label class="checkbox">
                                 <input type="checkbox"> Se souvenir de moi
                                 </label>
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
