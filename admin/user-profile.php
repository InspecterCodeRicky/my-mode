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
   $error = false;
   function isJSON($string){
      return is_string($string) && is_array(json_decode($string, true)) ? true : false;
   }


   $errorLastname = false;
   $errorFirstname = false;
   $errorPhone = false;
   $errorGenre = false;
   $errorImage = false;
   $error = false;

   if(isset($_POST['lastname'], $_POST['firstname'], $_POST['phone'])) {
       if (!isset($_POST['genre']) && empty($_POST['genre'])) {
           $errorGenre = "Selectionnner votre genre";
       }else if(empty($_POST['firstname'])) {
           $errorFirstname = "Champs vide";
       }else if(empty($_POST['lastname'])) {
           $errorLastname = "Champs vide";
       }else if (empty($_POST['phone'])) {
           $errorPhone = "Champs vide";
       }else {
           $lastname = $_POST['lastname'];
           $firstname = $_POST['firstname'];
           $phone = $_POST['phone'];
           $genre = $_POST['genre'];

           // check form phone valid
           if (!is_numeric($phone)) {
              $errorPhone = "le numéro de téléphone : '.$phone.' est considérée comme invalide.";
           }

           if(isset($_FILES['picture']['name']) && !empty($_FILES['picture']['name'])) {
             // check image
             $target_dir = "images/gallery/";
             $target_file = $target_dir.time().'-profile-'.basename($_FILES["picture"]["name"]);
             $target_file = str_replace(' ', '_', $target_file);
             $uploadOk = 1;
             $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
             $check = getimagesize($_FILES["picture"]["tmp_name"]);
             if($check !== false) {
                 $uploadOk = 1;
             } else {
                 $errorImage = "Le fichier n'est pas une image.";
                 $uploadOk = 0;
             }

             // Allow certain file formats
             if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
             && $imageFileType != "gif" ) {
                 $errorImage = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                 $uploadOk = 0;
             }
             if ($uploadOk == 0) {
                 $errorImage = "Désolé, votre fichier n'a pas été téléchargé.";
             } else { // if everything is ok, try to upload file

                 if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                     $success =  "Le fichier ". basename( $_FILES["picture"]["name"]). " a été téléchargé.";
                 } else {
                     $errorImage = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                 }
             }
             $old_targte_file = $user_current['profile_target'];
           } else {
             $target_file = $user_current['profile_target'];
           }

           $email = $_SESSION['email_ad'];
           // if not error input
           if($errorGenre == false && $errorLastname == false && $errorFirstname == false && $errorPhone == false) {
               $user_update = $user->update_user($email, $lastname, $firstname, $genre, $phone, $target_file);
               if(isJSON($user_update)) {
                   $error = json_decode($user_update);
                   $error = $error->{'error'};
               }
               if($old_targte_file && $error == false && $old_targte_file= != "images/user.png") {
                 unlink($old_targte_file);
               }
               if($error == false) {
                 header('location: user-profile.php');
                 exit();
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
                        <h3>Profil </h3>
                        <p class="mb-0">Ce compte a été créer le <?= $user_current['date_register']  ?></p>
                     </div>
                     <div class="module-body">
                        <?php if ($error): ?>
                        <div class="alert">
                           <button type="button" class="close" data-dismiss="alert">×</button>
                           <strong>Attention!</strong> <?= $error ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($_SESSION['message_CB_admin'] != ''): ?>
                        <div class="alert alert-success">
                           <button type="button" class="close" data-dismiss="alert">×</button>
                           <strong>Succes!</strong> <?= $_SESSION['message_CB_admin'] ?>
                        </div>
                        <?php $_SESSION['message_CB_admin'] = '';
                           endif; ?>
                        <div class="stream-composer media">
                           <a href="#" class="media-avatar medium pull-left">
                           <img src="<?= $user_current['profile_target'] ?>">
                           </a>
                           <div class="media-body pb-5">
                              <div class="clearfix">
                                 <form class="edit-profile" action="" method="post" enctype="multipart/form-data">
                                    <div class="control-group row">
                                       <div class="col-12 mb-4 d-profile_target  d-none">
                                          <div id="add_box_img" class="img-box bg-white">
                                             <label class="label">cliquer pour changer  l'image si souhaité</label>
                                             <?php if($errorImage) ?> <small class="error  form-text"> <?= $errorImage ?> </small>
                                             <div class="DropZone__Preview">
                                                <div id="img_Preview" class="DropZone__Preview--add" style="background-image : url(<?= $user_current['profile_target'] ?>); background-size : auto 100% ;">
                                                   <input name="picture" id="preview_input" multiple type="file"/>
                                                   <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-12 d-genre d-none">
                                          <?php if($errorGenre) ?> <small class="error ml-3 form-text"> <?= $errorGenre ?> </small>
                                          <label class="radio mr-4">
                                          <input name="genre" value="Homme" type="radio" <?php if(isset($_POST['genre']) && $_POST['genre'] == 'Homme') { echo 'checked'; } else if($user_current['genre'] == 'Homme') { echo 'checked'; }?>> Homme
                                          </label>
                                          <label class="radio">
                                          <input name="genre" value="Femme" type="radio" <?php if(isset($_POST['genre']) && $_POST['genre'] == 'Femme') { echo 'checked'; }else if($user_current['genre'] == 'Femme') { echo 'checked' ;}?>> Femme
                                          </label>
                                       </div>
                                    </div>
                                    <div class="control-group row">
                                       <div class="col-6">
                                          <div class="controls row-fluid">
                                             <label for="lastname">Prénom</label>
                                             <input disabled class="form-control" type="text" name="firstname" placeholder="Prénom" value="<?php if((isset($_POST['firstname']))) { echo $_POST['firstname']; } else { echo $user_current['firstname'] ;} ?>">
                                             <?php if($errorFirstname) ?> <small class="error form-text"> <?php echo $errorFirstname ?> </small>
                                          </div>
                                       </div>
                                       <div class="col-6">
                                          <div class="controls row-fluid">
                                             <label for=""firstname>Nom</label>
                                             <input disabled class="form-control" type="text" name="lastname" placeholder="Nom" value="<?php if((isset($_POST['lastname']))) { echo $_POST['lastname']; }  else { echo $user_current['lastname'] ;}?>">
                                             <?php if($errorLastname) ?> <small class="error form-text"> <?php echo $errorLastname ?> </small>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <div class="controls row-fluid">
                                          <label for="lastname">Téléphone</label>
                                          <input disabled class="form-control" type="text" name="phone" placeholder="Téléphone" value="<?php if((isset($_POST['phone']))) { echo $_POST['phone']; } else { echo $user_current['phone'] ;} ?>">
                                          <?php if($errorPhone) ?> <small class="error form-text"> <?php echo $errorPhone ?> </small>
                                       </div>
                                    </div>
                                    <div id="edit-action" class="mt-4">
                                       <div class="controls clearfix">
                                          <button type="button" class="btn edit-btn btn-primary pull-right">modifier</button>
                                       </div>
                                    </div>
                                    <div id="edit-submit" class="mt-4 d-none">
                                       <div class="controls clearfix">
                                          <button type="submit" class="btn btn-primary pull-right">Enregister</button>
                                       </div>
                                    </div>
                                 </form>
                              </div>
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
      <script type="text/javascript">
         $('.edit-btn').on('click', function() {
           $('#edit-action').addClass('d-none')
           $('#edit-submit').removeClass('d-none')
           $('.d-genre').removeClass('d-none')
           $('.d-profile_target').removeClass('d-none')
           $('.edit-profile input').attr('disabled', false)
         })
      </script>
      <script type="text/javascript">
         function getBase64(file, name) {
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
              var base64 =reader.result;
              $('.DropZone__Preview--add').css("background-image", "url(" + base64 + ")")
              $('.DropZone__Preview--add').css("background-size", "auto 100%")
              return base64
            };
            reader.onerror = function (error) {
              console.log('Error: ', error);
            };
         }

         $('#preview_input').on('change click', function() {
           if (this.files && this.files.length) {
             var file = this.files[0];
             const acceptedImageTypes = ['image/gif', 'image/jpg', 'image/jpeg', 'image/png'];
             console.log(file['type']);
             if(!acceptedImageTypes.includes(file['type'])) {
               alert("Ce fichier n'est pas une image.")
             } else {
               getBase64(file, $(this).attr("name"));
             }
           } else {
             $('.DropZone__Preview--add').css("background-image", "url(images/icons/camera.svg)")
             $('.DropZone__Preview--add').css("background-size", "auto")
           }
         })
      </script>
   </body>
</html>
