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
                     <div class="module message">
                        <div class="module-head">
                           <h3>
                              Message
                           </h3>
                        </div>
                        <div class="module-option clearfix">
                           <div class="pull-left">
                              <div class="dropdown">
                                 <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Inbox
                                 </button>
                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Inbox(11)</a>
                                    <a class="dropdown-item" href="#">Sent</a>
                                    <a class="dropdown-item" href="#">Draft(2)</a>
                                 </div>
                              </div>
                           </div>
                           <div class="pull-right">
                              <a href="#" class="btn btn-primary">Compose</a>
                           </div>
                        </div>
                        <div class="module-body table">
                           <table class="table table-message">
                              <tbody>
                                 <tr class="heading">
                                    <td class="cell-check">
                                       <input type="checkbox" class="inbox-checkbox">
                                    </td>
                                    <td class="cell-icon">
                                    </td>
                                    <td class="cell-author hidden-phone hidden-tablet">
                                       From
                                    </td>
                                    <td class="cell-title">
                                       Objet
                                    </td>
                                    <td class="cell-icon hidden-phone hidden-tablet">
                                    </td>
                                    <td class="cell-time align-right">
                                       Date
                                    </td>
                                 </tr>
                                 <?php
                                    if($messages) {
                                      foreach ($messages as $elem) { ?>
                                 <tr class="unread">
                                    <td class="cell-check">
                                       <input type="checkbox" class="inbox-checkbox">
                                    </td>
                                    <td class="cell-icon">
                                       <i class="icon-star"></i>
                                    </td>
                                    <td class="cell-author hidden-phone hidden-tablet">
                                       <?= $elem['name'] ?>
                                    </td>
                                    <td class="cell-title">
                                       <?= $elem['subject'] ?>
                                    </td>
                                    <td class="cell-icon hidden-phone hidden-tablet">
                                       <i class="icon-paper-clip-no"></i>
                                    </td>
                                    <td class="cell-time align-right">
                                       <?php
                                          $d=strtotime($elem['date_send']);
                                            echo  date("Y-m-d", $d);
                                           ?>
                                    </td>
                                 </tr>
                                 <?php }
                                    }

                                    ?>
                              </tbody>
                           </table>
                        </div>
                        <div class="module-foot">
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
   </body>
</html>
