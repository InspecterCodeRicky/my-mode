<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');
   // get class User
   $user = new User();

   // get user by email
   $user_current = $user->get_user_talent_by_email($_SESSION['email_ad'], 'users');

   // if user not exits and not logged
   if(!$user_current || !$_SESSION['loggedAdmin']){
       session_destroy();
       header("Location: login.php");
       exit();
   }
   $error = false;
   function isJSON($string){
      return is_string($string) && is_array(json_decode($string, true)) ? true : false;
   }
   if(isset($_GET['id'], $_GET['keyAccess']) && (!empty($_GET['id']) && !empty($_GET['keyAccess']))) {
   	$model = $user->get_models_by_keyAccess($_GET['id'], $_GET['keyAccess']);
   	if(isJSON($model)) {
   		$error = json_decode($model);
   		$error = $error->{"error"};
   	} else {
   		$Allphotos = $model['photos'];
   		$photos = explode('|', $Allphotos, -1);
   		$firstname = $model['firstname'];
   		$lastname = $model['lastname'];
   		$birthday = $model['birthday'];
   		$birthDate = explode("-",$birthday);
   		$age = getAge($birthDate);
   		$size = $model['size'];
   		$color_eyes = $model['color_eyes'];
   		$color_hair = $model['color_hair'];
   		$address = $model['address'];
   		$email = $model['email'];
   		$phone = $model['phone'];
   	}

   } else {
   	$error = "Nous n'avons pas trouvé.";
   	header("Location: all-models.php");
   	exit();
   }
   function getAge($birthDate) {
     $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
      ? ((date("Y") - $birthDate[2]) - 1)
      : (date("Y") - $birthDate[2]));
     return $age;
   }
   ?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <head>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>My Mode</title>
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
         <!-- <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
         <link type="text/css" href="css/theme.css" rel="stylesheet">
         <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
         <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
   </head>
   <body>
      <!-- Start header -->
      <?php include_once('includes/header.php'); ?>
      <!-- End header -->
      <div class="wrapper">
         <div class="container">
            <div class="row">
               <!-- Start menu sidebar -->
               <?php include_once('includes/menu-sidebar.php'); ?>
               <!-- End menu sidebar -->
               <div class="col-md-12 col-lg-9">
                  <div class="content">
                     <div class="module">
                        <?php if($error) { ?>
                        <div class="module-head">
                           <h3>Fiche model</h3>
                        </div>
                        <div class="module-body">
                           <div class="stream-composer media">
                              <a href="#" class="media-avatar medium pull-left">
                              <img src="images/user.png">
                              </a>
                              <div class="media-body">
                                 <div class="clearfix">
                                    <div class="alert">
                                       <button type="button" class="close" data-dismiss="alert">×</button>
                                       <strong>Attention!</strong> <?= $error ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--/.module-body-->
                        <?php } else { ?>
                        <div class="module-head">
                           <h3>Fiche de <strong><?= $firstname.' '.$lastname ?></strong> </h3>
                           <p class="mb-0">Membre depuis le <?= $model['date_register'];?></p>
                        </div>
                        <div class="module-body">
                           <div class="stream-composer media">
                              <a href="#" class="media-avatar medium pull-left">
                              <img src="../<?= $photos[0]?>">
                              </a>
                              <div class="media-body">
                                 <div class="clearfix">
                                    <div class="">
                                       <div>
                                          <label class="mb-0 font-weight-bold" for="">Description : </label>
                                          <p>
                                             Je suis Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas sint inventore eaque recusandae. Dicta exercitationem eaque mollitia eum possimus sed cum fugiat, fuga commodi aspernatur voluptatibus aliquam molestias officia quis.
                                          </p>
                                       </div>
                                       <div>
                                          <label class="font-weight-bold" for="">Date de naissance : </label> <span><?= $birthday.' ('.$age.'ans)' ?></span>
                                       </div>
                                       <div>
                                          <label class="font-weight-bold" for="">Adresse mail : </label> <span><?= $email ?></span>
                                       </div>
                                       <div>
                                          <label class="font-weight-bold" for="">Téléphone : </label> <span><?= $phone ?></span>
                                       </div>
                                       <div>
                                          <label class="font-weight-bold" for="">Taille : </label> <span><?php if($size) {echo $size.' m'; } else { echo 'non spécifié';}?></span>
                                       </div>
                                       <div>
                                          <label class="font-weight-bold" for="">Couleur des yeux : </label> <span><?php if($color_eyes) {echo $color_eyes; } else { echo 'non spécifié';}?></span>
                                       </div>
                                       <div>
                                          <label class="font-weight-bold" for="">Couleur de cheveux : </label> <span><?php if($color_hair) {echo $color_hair; } else { echo 'non spécifié';}?></span>
                                       </div>
                                       <div>
                                          <label class="font-weight-bold" for="">nombre de post : </label> <span><?= count($photos) -1 ?></span>
                                       </div>
                                       <p>
                                          <a href="all-models.php" class="btn btn-dark"> Retour</a>
                                          <a target="_blank" href="../talents-profile.php?id=<?= $model['id'] ?>&keyAccess=<?= $model['keyAccess'] ?>" class="btn btn-primary"> voir plus</a>
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--/.module-body-->
                        <?php } ?>
                     </div>
                     <!--/.module-->
                  </div>
                  <!--/.content-->
               </div>
               <!--/.span9-->
            </div>
         </div>
         <!--/.container-->
      </div>
      <!--/.wrapper-->
      <?php include_once('includes/footer.php'); ?>
      <!--/. footer  -->
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <script src="https://cdn.tiny.cloud/1/74dynsu9ax3oqpzblnl0wgz3ebpmpu9howykdxz8gjg5gamd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
   </body>
</html>
