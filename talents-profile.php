<?php
   setlocale(LC_TIME, 'fr_FR.utf8','fra');
   include_once('includes/connection.php');
   include_once('includes/users.php');
   // get class User
   $user = new User();

   // get user by email
   $user_current = (!empty($_SESSION['email'])) ? $user->get_user_talent_by_email($_SESSION['email'], $_SESSION['type_profile']) : false ;


   // if user not exits and not logged
   $anonymous_user = (!$user_current || !$_SESSION['logged_in']) ? true : false;

   function isJSON($string){
      return is_string($string) && is_array(json_decode($string, true)) ? true : false;
   }
   $models = $user->fetch_all_users('talents');

   // url path id and keysAccess
   if(isset($_GET['id'], $_GET['keyAccess'])) {
     if(!empty($_GET['id']) && !empty($_GET['keyAccess'])) {
       $search_model = $user->get_user_talent_by_keyAccess($_GET['id'], $_GET['keyAccess'], 'talents');
       if(isJSON($search_model)){
           session_destroy();
           header("Location: page-error.php");
           exit();
       }
       // info of model
       $Allphotos = $search_model['photos'];
       $photos = explode('|', $Allphotos, -1);
       $firstname = $search_model['firstname'];
       $lastname = $search_model['lastname'];
       $birthday = $search_model['birthday'];
       $birthDate = explode("-",$birthday);
       $age = getAge($birthDate);
       $size = $search_model['size'];
       $color_eyes = $search_model['color_eyes'];
       $color_hair = $search_model['color_hair'];
       $address = $search_model['address'];
       $email = $search_model['email'];
       $phone = $search_model['phone'];

     }else {
       header("Location: page-error.php");
       exit();
     }
   }


   function getAge($birthDate) {
     $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
      ? ((date("Y") - $birthDate[2]) - 1)
      : (date("Y") - $birthDate[2]));
     return $age;
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
      <!--::header part start::-->
      <?php
         include_once("includes/header.php")
         ?>
      <!-- Header part end-->
      <section class="profile-talent mt-5">
         <div class="container">
            <div class="row">
               <div class="col-12 mb-5">
                  <div class="row">
                     <div class="col-sm-12 col-md-4">
                        <div class="profile_picture" style="background-image : url(<?= $photos[0] ?>)">
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-8">
                        <div class="profile_layout_iner">
                           <h3 class="font-weight-bold"><?= $firstname; ?> <span class="lastname_style"><?= $lastname; ?></span></h3>
                           <p>
                              <span class="font-weight-bold">Date de naissance :</span><span> <?= strftime("%d %B %G", strtotime($birthday)) ?> (<?= $age ?> ans)</span>
                           </p>
                           <p>
                              <span class="font-weight-bold">Nationalité :</span><span> non specifié</span>
                           </p>
                           <p class="font-italic mb-3">
                              Je suis Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas sint inventore eaque recusandae. Dicta exercitationem eaque mollitia eum possimus sed cum fugiat, fuga commodi aspernatur voluptatibus aliquam molestias officia quis.
                           </p>
                           <!-- si cest moi redirige vers profile -->
                           <?php
                              if($user_current && $email == $_SESSION['email']) { ?>
                           <a href="my-profile.php" class="btn_1 _form">Voir mon profil</a>
                           <?php } else { ?>
                           <a href="#" class="btn_1 _form">Prosoper un casting</a>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-8 mb-5">
                  <h3 title="Informations personelles">Informations personelles</h3>
                  <?php if($anonymous_user == false) {?>
                  <div class="wrap_info_iner">
                     <p><span class="info_title">Taile :</span> <span><?php if($size) { echo $size.'m'; } else{ echo 'non spécifié';} ?></span></p>
                     <p><span class="info_title">Couleur de cheveux :</span> <span><?php if($color_hair) { echo $color_hair; } else{ echo 'non spécifié';} ?></span></p>
                     <p><span class="info_title">Couleur des yeux :</span> <span><?php if($color_eyes) { echo $color_eyes; } else{ echo 'non spécifié';} ?></span></p>
                     <p><span class="info_title">Adresse :</span> <span><?php if($address) { echo $address; } else{ echo 'non spécifié';} ?></span></p>
                  </div>
                  <?php } else { ?>
                  <div class="wrap_not-login-info">
                     <div class="iner_register_mask">
                        <div class="push__iner">
                           <span class="ti-lock"></span>
                           <p>Informations iniquement accessibles aux membres </p>
                        </div>
                     </div>
                  </div>
                  <?php }?>
                  <p class="heading">Les publications de <span class="font-weight-bold"><?= $firstname ?></span></p>
                  <div class="row my-gallery">
                     <?php
                        if(count($photos) >= 2) {
                          for ($i=1; $i < count($photos); $i++) {
                          ?>
                     <div class="col-sm-12 col-md-6 col-lg-4 text-sm-center">
                        <div class="img-box">
                           <div class="my-picture" style="background-image : url(<?= $photos[$i] ?>)"> </div>
                           <div class="transparent-box">
                              <div class="caption">
                                 <p><span class="ti-share"> 45</span></p>
                                 <p><span class="ti-heart"> 10</span></p>
                              </div>
                           </div>
                        </div>
                     </div>
                     <?php } } else { ?>
                     <p class="small text-center">Pas de photos</p>
                     <?php } ?>
                  </div>
               </div>
               <div class="col-lg-4 all_post talents-sidebar">
                  <?php if($anonymous_user == false) { ?>
                  <div class="sidebar_widget mb-5">
                     <div class="single_sidebar_wiget m-0">
                        <p>Me contactez</p>
                        <div class="d-flex mb-4">
                           <span class="ti-email"></span>
                           <div class="__iner ml-3">
                              <p>Email</p>
                              <p><a href="mail-to:demo@demo.com"><?= $email ?></a></p>
                           </div>
                        </div>
                        <div class="d-flex">
                           <span class="ti-mobile"></span>
                           <div class="__iner ml-3">
                              <p>Téléphone</p>
                              <p><a href="tel-to:0615154845"><? $phone ?></a></p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php }
                     include_once('includes/sidebar.php');
                     ?>
               </div>
               <!-- <div class="col-lg-12">
                  </div> -->
            </div>
         </div>
      </section>
      <!-- footer part start-->
      <?php
         include_once("includes/footer.php");
         ?>
      <script src="js/rangerInput.min.js"></script>
   </body>
</html>
