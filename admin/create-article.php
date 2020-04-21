<?php
   include_once('includes/connection.php');
   include_once('includes/articles.php');
   include_once('includes/users.php');
   // get class User and Article class
   $user = new User();
   $article = new Article();

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
   $errorImage = false;
   $errorTitle = false;
   $errorContent = false;
   $errorPostcheck = false;
   $errorTagname = false;
   if(isset($_FILES['picture'], $_POST['title'], $_POST['content'])) {
     if(empty($_FILES['picture'])){
       $errorImage = "Vous n'avez choisi votre image";
     } else if(empty($_POST['title'])) {
       $errorTitle = "Ce champs est vide";
     } else if(empty($_POST['content'])) {
       $errorContent = "Ce champs est vide";
     }else {


       $title =$_POST['title'];
       $content = $_POST['content'];
       $tagname = $_POST['Tagname'];

       if(empty($_POST['status'])) {
         $status = "not-post";
       }else {
         $status = $_POST['status'];
       }

       // check image
       $target_dir = "images/gallery/";
       $target_file = $target_dir.time().'-'.basename($_FILES["picture"]["name"]);
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

       $email = $user_current['email'];
       $keyAccess = $user_current['keyAccess'];
       if($errorImage == false && $errorTitle == false && $errorContent == false && $errorPostcheck == false && $errorTagname == false) {
           $result = $article->create_article($target_file, $title, $content, $tagname, $status, $email, $keyAccess);
           if(isJSON($result)) {
               print_r ($result);
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
                           <h3 class="d-inline-block">Créer un événement</h3>
                           <p class="d-inline-block float-right text-red small">Les champs avec * sont obligatoires</p>
                        </div>
                        <div class="module-body">
                           <div class="stream-composer d-md-flex media">
                              <a href="#" class="media-avatar d-md-block d-none medium pull-left">
                              <img src="<?= $user_current['profile_target'] ?>">
                              </a>
                              <div class="row">
                                 <form action="" method="post" enctype="multipart/form-data">
                                    <div class="col-12 mb-4">
                                       <div id="add_box_img" class="img-box bg-white">
                                          <label class="label">Choissisez une image pour votre article *</label>
                                          <?php if($errorImage) ?> <small class="error  form-text"> <?= $errorImage ?> </small>
                                          <div class="DropZone__Preview">
                                             <div id="img_Preview" class="DropZone__Preview--add">
                                                <input name="picture" id="preview_input" multiple type="file"/>
                                                <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                       <label class="label" for="title_article">Titre de l'article *</label>
                                       <?php if($errorTitle) ?> <small class="error  form-text"> <?= $errorTitle ?> </small>
                                       <input type="text" placeholder="Votre titre" class="form-control w-100 input_custom" id="title_article" name="title" value="<?php if((isset($_POST['title']))) { echo $_POST['title']; } ?>">
                                    </div>
                                    <div class="col-12 mb-4">
                                       <label class="label" for="myTextarea">Contenu de l'article *</label>
                                       <?php if($errorContent) ?> <small class="error  form-text"> <?= $errorContent ?> </small>
                                       <textarea name="content" id="myTextarea">
                                       <?php if((isset($_POST['content']))) { echo $_POST['content']; } ?>
                                       </textarea>
                                    </div>
                                    <div class="col-12 mb-4">
                                       <p class="mb-2 font-weight-bold" for="myTextarea">Chocher pour publier l'article</p>
                                       <?php if($errorPostcheck) ?> <small class="error  form-text"> <?= $errorPostcheck ?> </small>
                                       <label class="checkbox">
                                       <input name="status" type="checkbox" <?php if(isset($_POST['status']) && $_POST['status'] == 'post') { echo 'checked'; } ?> value="post">
                                       publié
                                       </label>
                                    </div>
                                    <div class="col-12 mb-4">
                                       <label class="label" for="tags_article">Tagname</label> <span>(séparez les avec une virgule) 3 maximum</span>
                                       <input type="text" placeholder="Tagname" class="form-control w-100 input_custom" id="tags_article" name="Tagname" value="<?php if((isset($_POST['Tagname']))) { echo $_POST['Tagname']; } ?>">
                                    </div>
                                    <div class="clearfix">
                                       <button type="submit" class="btn btn-primary pull-right">
                                       Envoyer
                                       </button>
                                    </div>
                                 </form>
                              </div>
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
