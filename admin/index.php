<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');
   include_once('includes/chat.php');
   // get class
   $user = new User();
   $message = new Chat();

   // get user by email
   $user_current = $user->get_user_talent_by_email($_SESSION['email_ad'], 'users');

   // if user not exits and not logged
   if(!$user_current || !$_SESSION['loggedAdmin']){
       session_destroy();
       header("Location: login.php");
       exit();
   }
   $messages = $message->fetchAll_message();
   $newMessage = 0;
   $today = date("Y-m-d");
   if($messages) {
     foreach ($messages as $elem) {
       $d=strtotime($elem['date_send']);
       $d = date("Y-m-d", $d);
       if($today == $d) {
         $newMessage = $newMessage+1;
       }
     }
   }

   ?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Mode</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                     <div class="btn-controls">
                        <div class="row">
                           <div class="col-4 ">
                              <div class="btn-box big">
                                 <a href="#">
                                    <i class="icon-eye-open"></i><b>5</b>
                                    <p class="text-muted">Page vue</p>
                                 </a>
                              </div>
                           </div>
                           <div class="col-4">
                              <div class="btn-box big">
                                 <a href="news-users.php">
                                    <i class="icon-user"></i><b>15</b>
                                    <p class="text-muted">Nouveau(x) utilisateur(s)</p>
                                 </a>
                              </div>
                           </div>
                           <div class="col-4">
                              <div class="btn-box big">
                                 <a href="message.php">
                                    <i class="icon-envelope"></i><b><?= $newMessage ?></b>
                                    <p class="text-muted">Nouveaux messages</p>
                                 </a>
                              </div>
                           </div>
                        </div>
                        <div class="btn-box-row row">
                           <div class="col-md-12 col-lg-8">
                              <div class="row">
                                 <div class="col-4">
                                    <div class="btn-box small ">
                                       <a href="#"><i class="icon-envelope"></i><b>Messages</b></a>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                    <div class="btn-box small">
                                       <a href="all-models.php"><i class="icon-group"></i><b>Models</b></a>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                    <div class="btn-box small">
                                       <a href="gallery.php"><i class="icon-camera"></i><b>Gallerie</b></a>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-4">
                                    <div class="btn-box small ">
                                       <a href="#"><i class="icon-save"></i><b>Total Sales</b></a>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                    <div class="btn-box small">
                                       <a href="#"><i class="icon-bullhorn"></i><b>Flux social</b></a>
                                    </div>
                                 </div>
                                 <div class="col-4">
                                    <div class="btn-box small">
                                       <a href="#"><i class="icon-sort-down"></i><b>Taux de rebond</b> </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-12 col-lg-4">
                              <ul class="widget widget-usage list-unstyled">
                                 <li>
                                    <p>
                                       <strong>Pc</strong> <span class="pull-right small muted">78%</span>
                                    </p>
                                    <div class="progress tight">
                                       <div class="bar" style="width: 78%;">
                                       </div>
                                    </div>
                                 </li>
                                 <li>
                                    <p>
                                       <strong>Tablette</strong> <span class="pull-right small muted">56%</span>
                                    </p>
                                    <div class="progress tight">
                                       <div class="bar bar-success" style="width: 56%;">
                                       </div>
                                    </div>
                                 </li>
                                 <li>
                                    <p>
                                       <strong>Mobile</strong> <span class="pull-right small muted">44%</span>
                                    </p>
                                    <div class="progress tight">
                                       <div class="bar bar-warning" style="width: 44%;">
                                       </div>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--/.wrapper-->
      <?php include_once('includes/footer.php'); ?>
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <script src="https://cdn.tiny.cloud/1/74dynsu9ax3oqpzblnl0wgz3ebpmpu9howykdxz8gjg5gamd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
      <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
      <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
      <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
      <script src="scripts/common.js" type="text/javascript"></script>
   </body>
</html>
