<?php
   include_once('includes/connection.php');
   include_once('includes/article.php');

   // get class User
   $article = new Article();

   function isJSON($string){
      return is_string($string) && is_array(json_decode($string, true)) ? true : false;
   }
   $error = false;

   // url path id and keysAccess
   if(isset($_GET['id'], $_GET['keyAccess'])) {
     if(!empty($_GET['id']) && !empty($_GET['keyAccess'])) {
       $search_article = $article->get_article_by_keyAccess($_GET['id'], $_GET['keyAccess'], 'articles');
       if(isJSON($search_article)) {
     		$error = "Désolé, nous n'avons pas pu trouvé cet événement, il semblerait qu'il est plus bon.";
     	}

       if($error ==  false) {
         $title = $search_article['title'];
         $content = $search_article['content'];
         $date_create = $search_article['date_create'];
         $author= $search_article['author'];
         $target_file= 'admin/'.$search_article['target_file'];

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
      <!-- breadcrumb start-->
      <section class="breadcrumb breadcrumb_bg align-items-center">
         <div class="container">
            <div class="row align-items-center justify-content-between">
               <div class="col-sm-6">
                  <div class="breadcrumb_tittle text-left">
                     <h2>blog details</h2>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="breadcrumb_content text-right">
                     <p>Home<span>/</span>blog details</p>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- breadcrumb start-->
      <!--================Blog Area =================-->
      <section class="blog_area single-post-area all_post section_padding">
         <div class="container">
            <div class="row">
               <div class="col-lg-8 posts-list">
                  <div class="single-post">
                     <div class="feature-img bg-single-blog" style="background-image : url(<?= $target_file ?>)">
                        <!-- <img class="img-fluid" src="img/blog/single_blog_1.png" alt=""> -->
                     </div>
                     <div class="blog_details">
                        <h2><?= $title ?>
                        </h2>
                        <ul class="blog-info-link mt-3 mb-4">
                           <li><a href="#"><i class="far fa-comments"></i> <?= $author ?></a></li>
                           <li><a href="#"><i class="far fa-comments"></i> <?= $date_create ?></a></li>
                           <li><i class="fas fa-user"></i> Mode, Lifestyle</li>
                        </ul>
                        <div class="content">
                           <?= $content ?>
                        </div>
                     </div>
                  </div>
                  <div class="navigation-top">
                     <div class="d-sm-flex justify-content-between text-center">
                        <p class="like-info"><span class="align-middle"><i class="far fa-heart"></i></span> Lily and 4
                           people like this
                        </p>
                        <div class="col-sm-4 text-center my-2 my-sm-0">
                           <!-- <p class="comment-count"><span class="align-middle"><i class="far fa-comment"></i></span> 06 Comments</p> -->
                        </div>
                        <ul class="social-icons">
                           <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                           <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                           <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                           <li><a href="#"><i class="fab fa-behance"></i></a></li>
                        </ul>
                     </div>
                     <div class="navigation-area">
                        <div class="row">
                           <div
                              class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                              <div class="thumb">
                                 <a href="#">
                                 <img class="img-fluid" src="img/post/preview.png" alt="">
                                 </a>
                              </div>
                              <div class="arrow">
                                 <a href="#">
                                 <span class="text-white ti-arrow-left"></span>
                                 </a>
                              </div>
                              <div class="detials">
                                 <p>Prev Post</p>
                                 <a href="#">
                                    <h4>Space The Final Frontier</h4>
                                 </a>
                              </div>
                           </div>
                           <div
                              class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                              <div class="detials">
                                 <p>Next Post</p>
                                 <a href="#">
                                    <h4>Telescopes 101</h4>
                                 </a>
                              </div>
                              <div class="arrow">
                                 <a href="#">
                                 <span class="text-white ti-arrow-right"></span>
                                 </a>
                              </div>
                              <div class="thumb">
                                 <a href="#">
                                 <img class="img-fluid" src="img/post/next.png" alt="">
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="blog-author">
                     <div class="media align-items-center">
                        <img src="img/blog/author.png" alt="">
                        <div class="media-body">
                           <a href="#">
                              <h4>Harvard milan</h4>
                           </a>
                           <p>Second divided from form fish beast made. Every of seas all gathered use saying you're, he
                              our dominion twon Second divided from
                           </p>
                        </div>
                     </div>
                  </div>
                  <div class="comments-area">
                     <h4>05 Comments</h4>
                     <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                           <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                 <img src="img/comment/comment_1.png" alt="">
                              </div>
                              <div class="desc">
                                 <p class="comment">
                                    Multiply sea night grass fourth day sea lesser rule open subdue female fill which them
                                    Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser
                                 </p>
                                 <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                       <h5>
                                          <a href="#">Emilly Blunt</a>
                                       </h5>
                                       <p class="date">December 4, 2017 at 3:12 pm </p>
                                    </div>
                                    <div class="reply-btn">
                                       <a href="#" class="btn-reply text-uppercase">reply</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                           <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                 <img src="img/comment/comment_2.png" alt="">
                              </div>
                              <div class="desc">
                                 <p class="comment">
                                    Multiply sea night grass fourth day sea lesser rule open subdue female fill which them
                                    Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser
                                 </p>
                                 <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                       <h5>
                                          <a href="#">Emilly Blunt</a>
                                       </h5>
                                       <p class="date">December 4, 2017 at 3:12 pm </p>
                                    </div>
                                    <div class="reply-btn">
                                       <a href="#" class="btn-reply text-uppercase">reply</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="comment-list">
                        <div class="single-comment justify-content-between d-flex">
                           <div class="user justify-content-between d-flex">
                              <div class="thumb">
                                 <img src="img/comment/comment_3.png" alt="">
                              </div>
                              <div class="desc">
                                 <p class="comment">
                                    Multiply sea night grass fourth day sea lesser rule open subdue female fill which them
                                    Blessed, give fill lesser bearing multiply sea night grass fourth day sea lesser
                                 </p>
                                 <div class="d-flex justify-content-between">
                                    <div class="d-flex align-items-center">
                                       <h5>
                                          <a href="#">Emilly Blunt</a>
                                       </h5>
                                       <p class="date">December 4, 2017 at 3:12 pm </p>
                                    </div>
                                    <div class="reply-btn">
                                       <a href="#" class="btn-reply text-uppercase">reply</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="comment-form">
                     <h4>Leave a Reply</h4>
                     <form class="form-contact comment_form" action="#" id="commentForm">
                        <div class="row">
                           <div class="col-12">
                              <div class="form-group">
                                 <textarea class="form-control w-100" name="comment" id="comment" cols="30" rows="9"
                                    placeholder="Write Comment"></textarea>
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group">
                                 <input class="form-control" name="name" id="name" type="text" placeholder="Name">
                              </div>
                           </div>
                           <div class="col-sm-6">
                              <div class="form-group">
                                 <input class="form-control" name="email" id="email" type="email" placeholder="Email">
                              </div>
                           </div>
                           <div class="col-12">
                              <div class="form-group">
                                 <input class="form-control" name="website" id="website" type="text" placeholder="Website">
                              </div>
                           </div>
                        </div>
                        <div class="load_btn">
                           <a href="#" class="btn_1">SUBMIT </a>
                        </div>
                     </form>
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
      <!--================Blog Area end =================-->
      <!-- footer part start-->
      <?php
         include_once("includes/footer.php")
         ?>
      <!-- footer part end-->
   </body>
</html>
