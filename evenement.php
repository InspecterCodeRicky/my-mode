<?php
   include_once('includes/connection.php');
   include_once('includes/events.php');
   // get class User
   $article = new Event();


   function isJSON($string){
      return is_string($string) && is_array(json_decode($string, true)) ? true : false;
   }
   $error = false;

   // url path id and keysAccess
   if(isset($_GET['id'], $_GET['keyAccess'])) {
     if(!empty($_GET['id']) && !empty($_GET['keyAccess'])) {
       $search_event = $article->get_event_by_keyAccess($_GET['id'], $_GET['keyAccess'], 'events');
       if(isJSON($search_event)) {
     		$error = "Désolé, nous n'avons pas pu trouvé cet événement, il semblerait qu'il est plus bon.";
     	}

       if($error ==  false) {
         $title = $search_event['title'];
         $date_depart = $search_event['date_depart'];
         $hour_depart = $search_event['hour_depart'];
         $date_end = $search_event['date_end'];
         $hour_end = $search_event['hour_end'];
         $content = $search_event['content'];
         $address = $search_event['address'];

         $recap_event = $article->fetch_rand($_GET['id'], 3);
       }
     }else {
       header("Location: page-error.php");
       exit();
     }
   }else {
     header("Location: page-error.php");
     exit();
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
      <!-- breadcrumb start-->
      <section class="breadcrumb _form breadcrumb_bg align-items-center">
         <div class="container">
            <form action="" method="get">
               <div class="row align-items-center">
                  <div class="col-sm-12 mb-5">
                     <div class="breadcrumb_tittle text-left">
                        <?php
                           if($error == false) {?>
                        <h2 class="custom_title"> <?= $title ?></h2>
                        <?php } ?>
                     </div>
                  </div>
                  <?php
                     if($error) {?>
                  <div class="col-12 col-md-6">
                     <p class="text-white mb-3">
                        <?= $error ?>
                     </p>
                     <a href="index.php" class="genric-btn primary">Acceuil</a>
                     <a href="contact.php" class="genric-btn primary">Nous-Contactez</a>
                  </div>
                  <?php } ?>
               </div>
            </form>
         </div>
      </section>
      <!-- breadcrumb end-->
      <!-- Section content events -->
      <?php
         if($error == false) {?>
      <section id="event-section" class="section_padding">
         <div class="container">
            <div class="row">
               <div class="main col-lg-8 col-md-12">
                  <div class="row">
                     <div class="col-lg-12">
                        <h4 title="événement" class="font-weight-bold">À propos de cet événement</h4>
                     </div>
                     <div class="col-lg-12 mt-5">
                        <?= $content ?>
                     </div>
                  </div>
               </div>
               <div class="aside col-lg-4 col-md-12">
                  <div>
                     <p class="font-weight-bold">Date & heure</p>
                     <p class="mt-3"><?= 'du <span class="font-weight-bold">'.$date_depart.'</span> au <span class="font-weight-bold">'. $date_end.'</span>' ?> </p>
                     <p class="mt-2 font-weight-bold"><?= $hour_depart.' - '. $hour_end ?> </p>
                  </div>
                  <div class="mt-5">
                     <p class="font-weight-bold">Adresse</p>
                     <p class="mt-3 font-weight-bold"><?= $address?> </p>
                  </div>
                  <?php
                     if($recap_event) {?>
                  <div class="mt-5">
                     <h3>Autres événements</h3>
                  </div>
                  <?php
                     foreach ($recap_event as $elem) {
                       $title = (strlen($elem['title']) > 20) ? substr($elem['title'],0,25).'...' : $elem['title'];
                       $content = (strlen($elem['content']) > 50) ? substr($elem['content'],0,53).'...' : $elem['content'];
                       $date_depart = DateTime::createFromFormat('Y-m-j', $elem['date_depart']);
                       $day = $date_depart->format('d');
                       $month = $date_depart->format('M');
                       $year = $date_depart->format('Y');
                       ?>
                  <div class="event-list" style="padding: 0;">
                     <a href="evenement.php?id=<?= $elem['id'] ?>&keyAccess=<?= $elem['keyAccess'] ?>">
                        <div class="item">
                           <div class="time">
                              <span class="day"> <?= $day ?>
                              <span class="month"><?= $month; ?></span>
                              <span class="year"><?= $year; ?></span>
                           </div>
                           <div class="info">
                              <h4>
                                 <span class="font-weight-bold"><?= $title ?></span>
                              </h4>
                              <div class="desc mt-2">
                                 <div class="font-weight-bolder">
                                    <span>de <?= $elem['hour_depart'].' h' ?></span> à <span><?= $elem['hour_depart'].' h' ?></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </a>
                  </div>
                  <?php }
                     } ?>
               </div>
            </div>
         </div>
      </section>
      <?php } ?>
      <!-- footer part start-->
      <?php include_once("includes/footer.php"); ?>
      <script src="js/rangerInput.min.js"></script>
   </body>
</html>
