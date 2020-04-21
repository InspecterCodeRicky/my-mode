<?php
   include_once('includes/connection.php');
   include_once('includes/chat.php');

   $chat = new Chat();

   $errorEmail = false;
   $errorName = false;
   $errorSubject = false;
   $errorMessage = false;
   $error = false;

   if(isset($_POST['email'], $_POST['name'], $_POST['subject'], $_POST['message'])) {
     if(empty($_POST['message'])) {
       $errorMessage = 'Ce champs est vide';
     }else if(empty($_POST['name'])) {
       $errorName = 'Ce champs est vide';
     } else if(empty($_POST['email'])) {
       $errorEmail = 'Ce champs est vide';
     } else if(empty($_POST['subject'])) {
       $errorSubject = 'Ce champs est vide';
     } else {
       $from = $_POST['email'];
       $name = $_POST['name'];
       $subject = $_POST['subject'];
       $message = $_POST['message'];

       // check validation email
       if (!filter_var($from, FILTER_VALIDATE_EMAIL)) {
           $errorEmail =  "L'adresse email '$from' est considérée comme invalide.";
       }

       if($errorName ==  false && $errorEmail == false && $errorMessage == false && $errorSubject == false) {
         $result = $chat->message_contact($from, $name, $subject, $message);
         if($chat->isJSON($result)) {
           $error = json_decode($result->{'error'});
         }

       }
     }
   }

   ?>
<!doctype html>
<html lang="fr">
   <head>
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
      <!-- breadcrumb start-->
      <section class="breadcrumb breadcrumb_bg align-items-center">
         <div class="container">
            <div class="row align-items-center justify-content-between">
               <div class="col-sm-6">
                  <div class="breadcrumb_tittle text-left">
                     <h2>Nous contatez</h2>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="breadcrumb_content text-right">
                     <p>Acceuil<span>/</span>
                        <?php
                           $remove= array(".php", "my-mode", "/");
                           echo str_replace($remove, "", $_SERVER['PHP_SELF']);
                           ?>
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- breadcrumb start-->
      <!-- ================ contact section start ================= -->
      <section class="contact-section section_padding">
         <div class="container">
            <div class="row">
               <div class="col-12">
                  <?php
                     if($error) { ?>
                  <div class="alert alert-warning">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                     <strong>Attention!</strong> <?= $error ;?>
                  </div>
                  <?php }
                     ?>
                  <?php
                     if($_SESSION['message_CB']) { ?>
                  <div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                     <strong>Succès!</strong> <?= $_SESSION['message_CB'] ;?>
                  </div>
                  <?php $_SESSION['message_CB'] = "";}
                     ?>
                  <h2 class="contact-title">Restons en conctact</h2>
               </div>
               <div class="col-lg-8">
                  <form class="form-contact contact_form" method="post" id="contactForm"
                     novalidate="novalidate">
                     <div class="row">
                        <div class="col-12">
                           <div class="form-group">
                              <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" placeholder='Votre message'><?php if((isset($_POST['message']))) { echo $_POST['message']; } ?></textarea>
                              <?php if($errorMessage) ?> <small class="error form-text"> <?php echo $errorMessage ?> </small>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group">
                              <input class="form-control" name="name" id="name" type="text" placeholder='Votre nom' value="<?php if((isset($_POST['name']))) { echo $_POST['name']; } ?>">
                              <?php if($errorName) ?> <small class="error form-text"> <?php echo $errorName ?> </small>
                           </div>
                        </div>
                        <div class="col-sm-6">
                           <div class="form-group">
                              <input class="form-control" name="email" id="email" type="email" placeholder='Votre email' value="<?php if((isset($_POST['email']))) { echo $_POST['email']; } ?>">
                              <?php if($errorEmail) ?> <small class="error form-text"> <?php echo $errorEmail ?> </small>
                           </div>
                        </div>
                        <div class="col-12">
                           <div class="form-group">
                              <input class="form-control" name="subject" id="subject" type="text" placeholder='Votre objet' value="<?php if((isset($_POST['subject']))) { echo $_POST['subject']; } ?>">
                              <?php if($errorSubject) ?> <small class="error form-text"> <?php echo $errorSubject ?> </small>
                           </div>
                        </div>
                     </div>
                     <div class="load_btn">
                        <button type="submit" href="#" class="btn_1">Envoyer</button>
                     </div>
                  </form>
               </div>
               <div class="col-lg-4">
                  <div class="media contact-info">
                     <span class="contact-info__icon"><i class="ti-home"></i></span>
                     <div class="media-body">
                        <h3>Paris 15ème, France.</h3>
                        <p>14 rue de la place, Paris 75015</p>
                     </div>
                  </div>
                  <div class="media contact-info">
                     <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                     <div class="media-body">
                        <h3> <a href="telto:+ 21 52 51 81 00">+ 21 52 51 81 00</a> </h3>
                        <p>De 9h30-13h / 14h30-17h</p>
                     </div>
                  </div>
                  <div class="media contact-info">
                     <span class="contact-info__icon"><i class="ti-email"></i></span>
                     <div class="media-body">
                        <h3> <a href="mailto:support@my-mode.com">support@my-mode.com</a> </h3>
                        <p>Un plaisir de vous repondre!</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- ================ contact section end ================= -->
      <!-- social_connect_part part start-->
      <section class="social_connect_part">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-12">
                  <div class="social_connect">
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_1.png" class="" alt="blog">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_2.png" class="" alt="blog">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_3.png" class="" alt="blog">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_4.png" class="" alt="blog">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_5.png" class="" alt="blog">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_6.png" class="" alt="blog">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- social_connect_part part end-->
      <!-- footer part start-->
      <?php
         include_once("includes/footer.php")
         ?>
      <!-- footer part end-->
   </body>
</html>
