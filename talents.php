<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');
   // get class User
   $user = new User();

   $models = $user->fetch_all_users('talents');

   // function get $age
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
      <!-- breadcrumb start-->
      <section class="breadcrumb _form breadcrumb_bg align-items-center">
         <div class="container">
            <form action="" method="get">
               <div class="row align-items-center">
                  <div class="col-sm-12 mb-5">
                     <div class="breadcrumb_tittle text-left">
                        <h2>Tous nos talents</h2>
                     </div>
                  </div>
                  <div class="col-12 col-md-6">
                     <input type="text" class="form-control" placeholder="Nom, Prénom, ville, sexe, etc...">
                  </div>
                  <div class="col-12 col-md-3">
                     <a href="#" class="btn_1">Rechercher</a>
                  </div>
               </div>
            </form>
         </div>
      </section>
      <!-- breadcrumb start-->
      <!-- feature_post_talents start-->
      <section class="all_post section_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-3">
                  <div class="search_filter_iner">
                     <div class="action-filter-md d-md-none d-flex justify-content-between mb-5">
                        <div class="back-btn">
                           <span class="ti-close"></span>
                           Retour
                        </div>
                        <div class="refresh_filter">
                           <span class="ti-reload">
                           <i class="fas fa-redo-alt"></i>
                           </span>
                           Réinitialiser
                        </div>
                     </div>
                     <form action="">
                        <div class="sexe_filter_inner">
                           <h4>Sexe</h4>
                           <div class="switch-wrap d-flex">
                              <div class="primary-checkbox">
                                 <input type="checkbox" name="sexe_filter" id="women_sexe">
                                 <label for="women_sexe"></label>
                              </div>
                              <p>Femme</p>
                           </div>
                           <div class="switch-wrap d-flex">
                              <div class="primary-checkbox">
                                 <input type="checkbox" name="sexe_filter" id="man_sexe">
                                 <label for="man_sexe"></label>
                              </div>
                              <p>Homme</p>
                           </div>
                        </div>
                        <div class="age_filter_iner mt-5">
                           <h4>Âge</h4>
                           <div class="tick-slider">
                              <div class="tick-slider-value-container">
                                 <div id="weightLabelMin" class="tick-slider-label">0</div>
                                 <div id="weightLabelMax" class="tick-slider-label">40</div>
                                 <div id="weightValue" class="tick-slider-value"></div>
                              </div>
                              <div class="tick-slider-background"></div>
                              <div id="weightProgress" class="tick-slider-progress"></div>
                              <div id="weightTicks" class="tick-slider-tick-container"></div>
                              <input
                                 id="weightSlider"
                                 class="tick-slider-input"
                                 type="range"
                                 min="19"
                                 max="40"
                                 step="3"
                                 value="9"
                                 data-tick-step="5"
                                 data-tick-id="weightTicks"
                                 data-value-id="weightValue"
                                 data-progress-id="weightProgress"
                                 data-handle-size="18"
                                 data-min-label-id="weightLabelMin"
                                 data-max-label-id="weightLabelMax"
                                 />
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
               <div class="col-md-9">
                  <div class="row">
                     <?php
                        if($models) {
                          foreach ($models as $elem) {
                              $Allphotos = $elem['photos'];
                              $photoProfile = explode('|', $Allphotos, -1);
                              $genre = $elem['genre'];
                              $birthday = date('d-m-Y' , strtotime($elem['birthday']));
                              $birthDate = explode("-",$birthday);
                              $firstname = $elem['firstname'];
                              $lastname = $elem['lastname'];
                              $keyAccess = $elem['keyAccess'];
                            ?>
                     <div class="col-lg-4 col-sm-6">
                        <div class="single_post post_1">
                           <a href="talents-profile.php?id=<?= $elem['id'];?>&keyAccess=<?=$keyAccess;?>">
                              <div class="single_post_img" style="background-image : url(<?= $photoProfile[0]; ?>)">
                              </div>
                              <div class="single_post_text text-center">
                                 <h5 title="sexe et age"><?= $genre.'/'.getAge($birthDate).' ans'; ?></h5>
                                 <h2><?= $firstname; ?> <span class="lastname_style"><?= $lastname;?></span></h2>
                              </div>
                           </a>
                        </div>
                     </div>
                     <?php }
                        }
                        ?>
                  </div>
                  <div class="page_pageniation">
                     <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                           <li class="page-item disabled">
                              <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                           </li>
                           <li class="page-item"><a class="page-link" href="#">1</a></li>
                           <li class="page-item"><a class="page-link" href="#">2</a></li>
                           <li class="page-item"><a class="page-link" href="#">3</a></li>
                           <li class="page-item">
                              <a class="page-link" href="#">Next</a>
                           </li>
                        </ul>
                     </nav>
                  </div>
               </div>
               <div class="col-12 d-md-none d-block">
                  <div class="filter-show-btn filter_box_open _form">
                     <a class="btn_1">Filter</a>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- feature_post_talents end-->
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
         include_once("includes/footer.php");
         ?>
      <script src="js/rangerInput.min.js"></script>
   </body>
</html>
