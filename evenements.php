<?php
   include_once('includes/connection.php');
   include_once('includes/events.php');
   // get class User
   $article = new Event();

   $events = $article->fetch_all('events');

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
      <section class="breadcrumb breadcrumb_bg align-items-center">
         <div class="container">
            <div class="row align-items-center justify-content-between">
               <div class="col-sm-6">
                  <div class="breadcrumb_tittle text-left">
                     <h2 title="événement">Tous nos événements</h2>
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
      <!-- feature_post start-->
      <section class="all_post section_padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-8">
                  <div class="row list-wrapper">
                     <?php
                        if($events) {
                          $currentDateTime = date('Y-m-d');
                          foreach ($events as $elem) {
                            if($elem['date_end'] >  $currentDateTime && $elem['status'] == 'post') {
                            $title = (strlen($elem['title']) > 20) ? substr($elem['title'],0,25).'...' : $elem['title'];
                            $content = (strlen($elem['content']) > 50) ? substr($elem['content'],0,53).'...' : $elem['content'];
                            $date_depart = DateTime::createFromFormat('Y-m-j', $elem['date_depart']);
                            $day = $date_depart->format('d');
                            $month = $date_depart->format('M');
                            $year = $date_depart->format('Y');
                            ?>
                     <div class="col-lg-6 col-md-6 col-sm-12">
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
                     </div>
                     <?php } } ?>
                     <div class="col-12">
                        <div id="pagination-container"></div>
                     </div>
                     <?php
                        }else {
                          if(isset($_GET['search'])) { ?>
                     <div class="col-12">
                        <p> Nous avons rien trouvé</p>
                     </div>
                     <div class="col-12">
                        <a class="btn mt-3 mb-3 btn-primary" href="conseils.php">Retour</a>
                     </div>
                     <?php } else { ?>
                     <p> il n'a pas encore des événements</p>
                     <?php }
                        }
                        ?>
                  </div>
               </div>
               <div class="col-lg-4 d-aside">
                  <?php
                     include_once("includes/sidebar.php")
                     ?>
               </div>
            </div>
         </div>
      </section>
      <!-- feature_post end-->
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js" type="text/javascript"></script>
      <script>
         $(document).ready(function() {
           var items = $(".list-wrapper .list-item");
           var numItems = items.length;
           var perPage = 15;

           items.slice(perPage).hide();

           $('#pagination-container').pagination({
               items: numItems,
               itemsOnPage: perPage,
               prevText: "&laquo;",
               nextText: "&raquo;",
               onPageClick: function (pageNumber) {
                   var showFrom = perPage * (pageNumber - 1);
                   var showTo = showFrom + perPage;
                   items.hide().slice(showFrom, showTo).show();
               }
           });
         } );
      </script>
   </body>
</html>
