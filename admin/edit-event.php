<?php
   include_once('includes/connection.php');
   include_once('includes/events.php');
   include_once('includes/users.php');
   // get class User and Article class
   $user = new User();
   $article = new Event();

   // get user by email
   $user_current = $user->get_user_talent_by_email($_SESSION['email_ad'], 'users');

   // if user not exits and not logged
   if(!$user_current || !$_SESSION['loggedAdmin']){
       session_destroy();
       header("Location: login.php");
       exit();
   }
   function isJSON($string){
      return is_string($string) && is_array(json_decode($string, true)) ? true : false;
   }

   if(isset($_GET['edit'], $_GET['id']) && !empty($_GET['id'])) {
     $editArticle = $article->fetch_data($_GET['id']);
     if(isJSON($editArticle)) {
       $_SESSION['error_CB_admin'] = "l'article que vous avez essayé éditer n'est pas dans la base";
       // DATE_FORMAT(champs_date, '%d/%m/%Y') AS champs_date
       header("Location: events.php");
       exit();
     }
     // $date = DateTime::createFromFormat('Y-m-j', '2020-04-14');
     // $date = $date->format('Y-m-d');
   } else {
     header("Location: events.php");
     exit();
   }
   $errorTitle = false;
   $errorContent = false;
   $errorPostcheck = false;
   $errorAddress = false;
   $errorDate = false;
   $errordate_depart = false;
   $errorhour_depart = false;
   $errordate_end = false;
   $errorhour_end = false;
   $error = false;

   if(isset($_POST['title'], $_POST['content'], $_POST['address'], $_POST['date_depart'], $_POST['hour_depart'], $_POST['date_end'], $_POST['hour_end'])) {
     if(empty($_POST['title'])) {
       $errorTitle = "Ce champs est vide";
     } else if(empty($_POST['address'])) {
       $errorAddress = "Ce champs est vide";
     } else if(empty($_POST['date_depart'])) {
       $errorDate = "Ce champs est vide";
     } else if(empty($_POST['hour_depart'])) {
       $errorhour_depart = "Ce champs est vide";
     } else if(empty($_POST['date_end'])) {
       $errordate_end = "Ce champs est vide";
     } else if(empty($_POST['hour_end'])) {
       $errorhour_end = "Ce champs est vide";
     } else if(empty($_POST['content'])) {
       $errorContent = "Ce champs est vide";
     }else {

       $title =$_POST['title'];
       $address =$_POST['address'];
       $date_depart =$_POST['date_depart'];
       $hour_depart =$_POST['hour_depart'];
       $date_end = $_POST['date_end'];
       $hour_end = $_POST['hour_end'];
       $content = $_POST['content'];
       if(strlen($title) > 45) {
         $errorTitle = "Le titre ne doit pas dépasser 45 caractères maximun";
       }
       if(empty($_POST['status'])) {
         $status = "not-post";
       }else {
         $status = $_POST['status'];
       }
       if($date_end < $date_depart) {
         $errordate_end = "cette date n'est pas valide";
       }
       if($date_end == $date_depart) {
         if($hour_end <= $hour_depart) {
           $errorhour_end = "cette heure n'est pas valide";
         }
       }
       $author = $user_current['firstname'].' '.$user_current['lastname'];
       if($errorTitle == false && $errorContent == false && $errorPostcheck == false && $errorAddress == false
       && $errorDate == false && $errordate_depart == false && $errorhour_depart == false && $errordate_end == false
       && $errorhour_end == false ) {
           $result = $article->edit_event($title, $address,$status, $date_depart, $hour_depart, $date_end, $hour_end, $content, $author, $_GET['id']);
           if(isJSON($result)) {
             $error = json_decode($result);
             $error = $error->{"error"};
           }
       }


     }
   }
    ?>
<!DOCTYPE html>
<html lang="fr">
   <head>
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
                     <div class="module">
                        <div class="module-head">
                           <h3 class="d-inline-block">Éditer cet événement</h3>
                           <p class="d-inline-block float-right text-red small">Les champs avec * sont obligatoires</p>
                        </div>
                        <div class="module-body">
                           <?php if($error) { ?>
                           <div class="m-3">
                              <div class="alert">
                                 <button type="button" class="close" data-dismiss="alert">×</button>
                                 <strong>Attention!</strong> <?= $error ?>
                              </div>
                           </div>
                           <?php } ?>
                           <div class="stream-composer d-md-flex media">
                              <a href="#" class="media-avatar d-md-block d-none medium pull-left">
                              <img src="<?= $user_current['profile_target'] ?>">
                              </a>
                              <form action="" method="post" enctype="multipart/form-data">
                                 <div class="row">
                                    <div class="col-12 mb-4">
                                       <label class="label" for="title_annonce">Titre de l'événement *</label> <span class="small">(45 caractères maximun)</span>
                                       <?php if($errorTitle) ?> <small class="error  form-text"> <?= $errorTitle ?> </small>
                                       <input type="text" placeholder="Votre titre" class="form-control w-100 input_custom" id="title_annonce" name="title" value="<?php if((isset($_POST['title']))) { echo $_POST['title']; } else { echo $editArticle['title']; } ?>">
                                    </div>
                                    <div class="col-12 mb-4">
                                       <label class="label" for="address_event">l'adresse se passe l'événement *</label>
                                       <?php if($errorAddress) ?> <small class="error  form-text"> <?= $errorAddress ?> </small>
                                       <input type="text" placeholder="Adresse" class="form-control w-100 input_custom" id="address_event" name="address" value="<?php if((isset($_POST['address']))) { echo $_POST['address']; } else { echo $editArticle['address']; }  ?>">
                                    </div>
                                    <div class="col-lg-6 col-md-12 mb-4">
                                       <label class="label" for="date_depart">Date début *</label>
                                       <?php if($errordate_depart) ?> <small class="error  form-text"> <?= $errordate_depart ?> </small>
                                       <input type="date" class="form-control w-100 input_custom" id="date_depart" name="date_depart" value="<?php if((isset($_POST['date_depart']))) { echo $_POST['date_depart']; } else { echo $editArticle['date_depart']; } ?>">
                                    </div>
                                    <div class="col-lg-6 col-md-12 mb-4">
                                       <label class="label" for="hour_depart">Heure début *</label>
                                       <?php if($errorhour_depart) ?> <small class="error  form-text"> <?= $errorhour_depart ?> </small>
                                       <input type="time" class="form-control w-100 input_custom" id="hour_depart" name="hour_depart" value="<?php if((isset($_POST['hour_depart']))) { echo $_POST['hour_depart']; } else { echo $editArticle['hour_depart']; } ?>">
                                    </div>
                                    <div class="col-lg-6 col-md-12 mb-4">
                                       <label class="label" for="date_end">Date fin *</label>
                                       <?php if($errordate_end) ?> <small class="error  form-text"> <?= $errordate_end?> </small>
                                       <input type="date" class="form-control w-100 input_custom" id="date_end" name="date_end" value="<?php if((isset($_POST['date_end']))) { echo $_POST['date_end']; }else { echo $editArticle['date_end']; } ?>">
                                    </div>
                                    <div class="col-lg-6 col-md-12 mb-4">
                                       <label class="label" for="hour_end">Heure fin *</label>
                                       <?php if($errorhour_end) ?> <small class="error  form-text"> <?= $errorhour_end ?> </small>
                                       <input type="time" class="form-control w-100 input_custom" id="hour_end" name="hour_end" value="<?php if((isset($_POST['hour_end']))) { echo $_POST['hour_end']; }  else { echo $editArticle['hour_end']; }?>">
                                    </div>
                                    <div class="col-12 mb-4">
                                       <label class="label" for="myTextarea">Descrption *</label>
                                       <?php if($errorContent) ?> <small class="error  form-text"> <?= $errorContent ?> </small>
                                       <textarea name="content" id="myTextarea">
                                       <?php if((isset($_POST['content']))) { echo $_POST['content']; } else { echo $editArticle['content']; } ?>
                                       </textarea>
                                    </div>
                                    <div class="col-12 mb-4">
                                       <p class="mb-2 font-weight-bold" for="">Chocher pour publier l'événement</p>
                                       <?php if($errorPostcheck) ?> <small class="error  form-text"> <?= $errorPostcheck ?> </small>
                                       <label class="checkbox">
                                       <input name="status" type="checkbox" <?php if(isset($_POST['status']) && $_POST['status'] == 'post') { echo 'checked'; }  else if($editArticle['status'] == 'post') { echo 'checked'; } ?> value="post">
                                       publié
                                       </label>
                                    </div>
                                    <div class="col-12 clearfix">
                                       <button type="submit" class="btn btn-primary pull-right">
                                       Envoyer
                                       </button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <!--/.module-body-->
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
      <script>
         tinymce.init({
           selector: '#myTextarea',
           language: 'fr_FR',
           height: 300,
           plugins: [
             'advlist autolink autoresize lists link image charmap print preview hr anchor pagebreak',
             'searchreplace wordcount visualblocks visualchars code fullscreen',
             'insertdatetime media nonbreaking save table contextmenu directionality',
             'emoticons template paste textcolor colorpicker textpattern imagetools'
           ],
           toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify |',
           toolbar2: ' bullist numlist outdent indent |  forecolor backcolor emoticons',
         });
      </script>
   </body>
</html>
