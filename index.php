<?php
   include_once('includes/connection.php');
   include_once('includes/article.php');
   // get class User
   $article = new Article();

   $articles = $article->fetch_rand(7);

   ?>
<!doctype html>
<html lang="fr">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>lifeleck BLOG || HOME</title>
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
      <!-- banner post start-->
      <section class="banner_post">
         <div class="container-fluid">
            <div class="row justify-content-between">
               <div class="banner_post_talent_1" style="background-image: url(img/post/emma.jpg);">
                  <div class="banner_post_iner text-center">
                     <h5 title="sexe et age">Femme/19 ans</h5>
                     <a href="talents.php">
                        <h2> Emma LARMANAC</h2>
                     </a>
                     <P>Jeune mannequi amateur, je souhaite de me lancer dans une carrière professionnelle.</P>
                  </div>
               </div>
               <div class="banner_post_talent_1" style="background-image: url(img/post/petter.png);">
                  <div class="banner_post_iner text-center">
                     <h5 title="sexe et age">Homme/19 ans</h5>
                     <a href="talents.php">
                        <h2> Petter VERGER</h2>
                     </a>
                     <P>Jeune mannequi amateur, je souhaite de me lancer dans une carrière professionnelle.</P>
                  </div>
               </div>
               <div class="banner_post_talent_1" style="background-image: url(img/post/unc2.png);">
                  <div class="banner_post_iner text-center">
                     <h5 title="sexe et age">Femme/19 ans</h5>
                     <a href="talents.php">
                        <h2> Emilie POITOUT</h2>
                     </a>
                     <P>Jeune mannequi amateur, je souhaite de me lancer dans une carrière professionnelle.</P>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- banner post end-->
      <!-- about us start-->
      <div class="about_us padding_top margin_top">
         <div class="container">
            <div class="row">
               <div class="col-lg-7 col-md-12">
                  <div class="about_us_text_iner">
                     <h2 title="À propos de nous">À propos de nous</h2>
                     <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sunt deserunt sint molestias culpa soluta tempora quas eveniet? Hic facilis, nobis totam, vitae ipsa accusantium magnam molestiae minima, illum dolore veritatis.</p>
                     <a href="register-model.php" class="genric-btn primary-border">Devenir un model</a>
                  </div>
               </div>
               <div class="col-lg-5 col-md-12">
                  <div class="about_us_image_iner"></div>
               </div>
            </div>
         </div>
      </div>
      <!-- about us end-->
      <!-- subscribe form start-->
      <div class="subscribe_form padding_top">
         <div class="container">
            <div class="row ">
               <div class="col-lg-12">
                  <div class="subscribe_form_iner">
                     <form>
                        <div class="form-row align-items-center justify-content-center">
                           <div class="col-md-12 col-lg-3">
                              <h3 title="Abonnez-vous à notre newsletter">Abonnez-vous à notre newsletter</h3>
                           </div>
                           <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                              <input type="text" class="form-control" placeholder="Votre nom">
                           </div>
                           <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                              <input type="text" class="form-control" placeholder="Votre email">
                           </div>
                           <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                              <a href="#" class="btn_1">S'inscrire</a>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- subscribe form end-->
      <!-- feature_post start-->
      <section class="all_post section_padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-8">
                  <div class="row">
                     <?php
                        foreach ($articles as $key  => $elem) {
                          if( $key == (count( $articles ))-1 && $elem['status'] == 'post') {
                             $date_create = DateTime::createFromFormat('Y-m-j', $elem['date_create']);
                             $date_create = $date_create->format('d M Y');
                             $title = (strlen($elem['title']) > 28) ? substr($elem['title'],0,33).'...' : $elem['title'];
                             $image = 'admin/'.$elem['target_file']
                            ?>
                     <div class="col-lg-12 list-item">
                        <div class="single_post post_1 feature_post">
                           <a href="single-blog.php?id=<?= $elem['id']  ?>&keyAccess=<?= $elem['keyAccess'] ?>">
                              <div class="single_post_img" style="background-image : url(<?=$image ?>)">
                              </div>
                              <div class="single_post_text text-center">
                                 <h5> Fashion / Mode</h5>
                                 <h2><?= $title ?></h2>
                                 <p>Publié le <?=$date_create?></p>
                              </div>
                           </a>
                        </div>
                     </div>
                     <?php }
                        }

                        foreach ($articles as $key => $elem) {
                          if($key != (count( $articles ))-1 && $elem['status'] == 'post') {
                            $date_create = DateTime::createFromFormat('Y-m-j', $elem['date_create']);
                            $date_create = $date_create->format('d M Y');
                            $title = (strlen($elem['title']) > 28) ? substr($elem['title'],0,33).'...' : $elem['title'];
                            $image = 'admin/'.$elem['target_file']
                            ?>
                     <div class="col-lg-6 col-sm-6 list-item">
                        <div class="single_post post_1">
                           <a href="single-blog.php?id=<?= $elem['id']  ?>&keyAccess=<?= $elem['keyAccess'] ?>">
                              <div class="single_post_img" style="background-image : url(<?=$image ?>)">
                              </div>
                              <div class="single_post_text text-center">
                                 <h5> Fashion / Mode</h5>
                                 <h2><?= $title ?></h2>
                                 <p>Publié le <?=$date_create?></p>
                              </div>
                           </a>
                        </div>
                     </div>
                     <?php }
                        }
                        ?>
                  </div>
               </div>
               <div class="col-lg-4">
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
                           <img src="img/insta/instagram_1.png" class="" alt="blog ">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_2.png" class="" alt="blog ">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_3.png" class="" alt="blog ">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_4.png" class="" alt="blog ">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_5.png" class="" alt="blog ">
                           <div class="social_connect_overlay">
                              <a href="#"><span class="ti-instagram"></span></a>
                           </div>
                        </div>
                     </div>
                     <div class="single-social_connect">
                        <div class="social_connect_img">
                           <img src="img/insta/instagram_6.png" class="" alt="blog ">
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
