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
   $dir    = 'images/gallery';
   $folder = scandir($dir);
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
                     <div class="module-head">
                        <h3>Gallerie </h3>
                     </div>
                     <div class="module-body list-wrapper">
                        <div class="row">
                           <?php foreach ($folder as $elem) {
                              if($elem !== '.' && $elem !== '..') {
                                $target_file = 'images/gallery/'.$elem
                              ?>
                           <div class="col-sm-12 col-md-6 col-lg-4 text-sm-center list-item">
                              <div class="img-box">
                                 <div class="gallery-bg" style="background-image : url(<?= $target_file?>)"> </div>
                              </div>
                           </div>
                           <?php } } ?>
                           <div class="col-12">
                              <div id="pagination-container"></div>
                           </div>
                        </div>
                     </div>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js" type="text/javascript"></script>
      <script type="text/javascript">
         $('.edit-btn').on('click', function() {
           $('#edit-action').addClass('d-none')
           $('#edit-submit').removeClass('d-none')
           $('.d-genre').removeClass('d-none')
           $('.edit-profile input').attr('disabled', false)
         })

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
         })
      </script>
   </body>
</html>
