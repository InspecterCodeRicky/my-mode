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

   $models = $user->fetch_all_models();

   ?>
<!DOCTYPE html>
<html lang="fr">
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
                           <h3>Models</h3>
                        </div>
                        <div class="module-body table">
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                              <thead>
                                 <tr>
                                    <th>id</th>
                                    <th>Avatar</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    foreach ($models as $elem) {
                                                 $Allphotos = $elem['photos'];
                                                 $photos = explode('|', $Allphotos, -1);
                                                 $avatar = '../'.$photos[0];
                                                 ?>
                                 <tr class="gradeA even">
                                    <td class="  sorting_1">
                                       <a href="fiche-model.php?id=<?= $elem['id'] ?>&keyAccess=<?= $elem['keyAccess'] ?>"><?= $elem['id'] ?></a>
                                    </td>
                                    <td class="  sorting_1">
                                       <div class="bg-article bg-circle" style="background-image : url(<?= $avatar ?>)"></div>
                                    </td>
                                    <td class=" "><?= $elem['firstname'] ?></td>
                                    <td class=" "><?= $elem['lastname'] ?></td>
                                    <td class="center "><?= $elem['email'] ?></td>
                                    <td class="center "><?= $elem['phone'] ?></td>
                                 </tr>
                                 <?php }
                                    ?>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <th>id</th>
                                    <th>Avatar</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
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
      <script src="scripts/datatables/jquery.dataTables.js"></script>
      <script>
         $(document).ready(function() {
         	$('.datatable-1').dataTable();
         	$('.dataTables_paginate').addClass("btn-group datatable-pagination");
         	$('.dataTables_paginate > a').wrapInner('<span />');
         	$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
         	$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
         } );
      </script>
   </body>
 </html>
