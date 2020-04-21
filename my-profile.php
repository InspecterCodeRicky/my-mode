<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');
   // get class User
   $user = new User();
   // echo $_SESSION['message_CB_success'];
   // get user by email
   $user_current = $user->get_user_talent_by_email($_SESSION['email'], $_SESSION['type_profile']);

   function isJSON($string){
      return is_string($string) && is_array(json_decode($string, true)) ? true : false;
   }
   // if user not exits and not logged
   if(isJSON($user_current) || !$_SESSION['logged_in']){
       session_destroy();
       header("Location: index.php");
       exit();
   }
   $errorGenre = false;
   $errorFirstname = false;
   $errorLastname = false;
   $errorPhone = false;
   $errorBirthday = false;
   $success = false;
   if($_SESSION['type_profile'] =='talents') {
       // display progress profile user
       $objLenght = count($user_current) - 3;
       $progress = 0 ;
       foreach($user_current as $key=>$value) {
           if($value) {
               $progress = $progress + 1;
           }
       }
       $progress =$progress-3 ;
       $progress = ceil(($progress * 100) / $objLenght);
       // get all photos and do a array
       $Allphotos = $user_current['photos'];
       $photos = explode('|', $Allphotos, -1);

       // $birthday = date('d-m-Y' , strtotime($user_current['birthday']));
       function getAge($birthDate) {
         $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
          ? ((date("Y") - $birthDate[2]) - 1)
          : (date("Y") - $birthDate[2]));
         return $age;
       }


       // delete photos
       if(isset($_GET['delete-photo'], $_GET['url-photo']) && $_GET['delete-photo'] == true && !empty($_GET['url-photo'])) {
         $urlPhoto = $_GET['url-photo'].'|';
         $newUrlPhotos =  str_replace($urlPhoto," ",$Allphotos);
         //Update photos
         $path1 = trim($_GET['url-photo']);
         if(!unlink($path1)) {
           echo "error";
         } else {
           echo "success";
         }
         $update = $pdo->prepare("UPDATE talents SET photos = ? WHERE email = ?");
         $update->bindValue(1, $newUrlPhotos);
         $update->bindValue(2, $_SESSION['email']);
         $update->execute();
         header('location: my-profile.php');
       }

       // update profile user ->> table talents
       if($_POST && isset($_GET['update'])) {
           if(isset($_POST['lastname'], $_POST['firstname'], $_POST['genre'], $_POST['phone'])) {
               if (!isset($_POST['genre']) && empty($_POST['genre'])) {
                   $errorGenre = "Selectionnner votre genre";
               }else if(empty($_POST['lastname'])) {
                   $errorLastname = "Champs vide";
               }else if(empty($_POST['firstname'])) {
                   $errorFirstname = "Champs vide";
               }else if (empty($_POST['phone'])) {
                   $errorPhone = "Champs vide";
               }
               else {
                   $lastname = $_POST['lastname'];
                   $firstname = $_POST['firstname'];
                   $genre = $_POST['genre'];
                   $address = $_POST['address'];
                   $phone = $_POST['phone'];
                   $size = $_POST['size'];
                   // $birthday = $_POST['birthday'];
                   $color_eyes = $_POST['color_eyes'];
                   $color_hair = $_POST['color_hair'];

                   // check form phone valid
                   if (!is_numeric($phone)) {
                       $errorPhone = "le numéro de téléphone : '$phone' est considérée comme invalide.";
                   }
                   // check age > 18
                   if(!empty($_POST['birthday'])) {
                     $birthday = date('d-m-Y' , strtotime($_POST['birthday']));
                     $birthDate = explode("-",$birthday);
                     if(getAge($birthDate) < 18) {
                       $errorBirthday = "Âge doit être supérieur à 17";
                     }
                   }
                   //if not error input
                   if($errorGenre == false && $errorLastname == false && $errorFirstname == false && $errorPhone == false && $errorBirthday == false) {
                     $users = $user->update_model($lastname, $firstname, $genre, $phone, $address, $birthday, $size, $color_eyes, $color_hair, $_SESSION['email']);
                   }
               }
           }
       }
   } else {
     // update profile user --> table users
     if($_POST && isset($_GET['update'])) {
         if(isset($_POST['lastname'], $_POST['firstname'], $_POST['genre'], $_POST['phone'])) {
             if (!isset($_POST['genre']) && empty($_POST['genre'])) {
                 $errorGenre = "Selectionnner votre genre";
             }else if(empty($_POST['lastname'])) {
                 $errorLastname = "Champs vide";
             }else if(empty($_POST['firstname'])) {
                 $errorFirstname = "Champs vide";
             }else if (empty($_POST['phone'])) {
                 $errorPhone = "Champs vide";
             }
             else {
                 $lastname = $_POST['lastname'];
                 $firstname = $_POST['firstname'];
                 $genre = $_POST['genre'];
                 $address = $_POST['address'];
                 $phone = $_POST['phone'];
                 // check form phone valid
                 if (!is_numeric($phone)) {
                     $errorPhone = "le numéro de téléphone : '$phone' est considérée comme invalide.";
                 }


                 // if not error input
                 if($errorGenre == false && $errorLastname == false && $errorFirstname == false && $errorPhone == false) {
                   $users = $user->update_user($lastname, $firstname, $genre, $phone, $_SESSION['email']);
                 }
             }
         }
     }
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
         include_once("includes/header.php");
         ?>
      <!-- Header part end-->
      <section class="my-profile mt-5 mb-5">
         <div class="container">
            <div class="row">
               <div class="col-sm-12 col-md-5 col-lg-4 mb-5">
                  <div class="box_shadow">
                     <h2 class="mb-5 m-3 text-center">Mon profil</h2>
                     <?php if($_SESSION['type_profile'] =='talents') { ?>
                     <div class="profile_completed_progress m-4 mb-4">
                        <div class="progress_bar">
                           <div class="set-size charts-container">
                              <div class="pie-wrapper progress-30">
                                 <span class="label"> <?= $progress ?><span class="smaller">%</span>
                                 </span>
                                 <div class="pie">
                                    <div class="left-side half-circle"></div>
                                    <div class="right-side half-circle"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="picture_iner mb-5">
                        <div class="profile_picture mb-5" style="background-image : url(<?= $photos[0] ?>)">
                        </div>
                     </div>
                     <?php } ?>
                     <div class="info_profile text-center m-4">
                        <a href="#" id="open_box_form" class="btn_1 m-auto">Éditer mon profil</a>
                        <div class="info-perso mt-3 text-left">
                           <P class="info_title"><?= $user_current['firstname'] ;?>
                              <span class="lastname_style"><?= $user_current['lastname'] ;?></span>
                              <span class="small">
                              <?php
                                 $birthday = $user_current['birthday'];
                                 $birthDate = explode("-",$birthday);
                                 $age = getAge($birthDate);
                                 echo '('.$age.' ans)';
                                 ?>
                              </span>
                           </P>
                           <span>Membre depuis le <?= $user_current['date_register'];?></span>
                           <p class="info_title mt-4">Contact</p>
                           <p><span class="ti-email"> Email:</span> <?= $user_current['email'] ;?></p>
                           <p><span class="ti-mobile"> Téléphone:</span> <?= $user_current['phone'] ;?></p>
                           <?php if($_SESSION['type_profile'] =='talents') { ?>
                           <p class="info_title mt-4">Information personnelles</p>
                           <div class="">
                              <p><span class="info_title">Taille :</span> <span><?php if($user_current['size']) { echo $user_current['size'].' m'; } else{ echo 'non spécifié';} ?></span></p>
                              <p><span class="info_title">Couleur de cheveux :</span> <span><?php if($user_current['color_hair']) { echo $user_current['color_hair']; } else{ echo 'non spécifié';} ?></span></p>
                              <p><span class="info_title">Couleur des yeux :</span> <span><?php if($user_current['color_eyes']) { echo $user_current['color_eyes']; } else{ echo 'non spécifié';} ?></span></p>
                              <p><span class="info_title">Adresse :</span> <span><?php if($user_current['address']) { echo $user_current['address']; } else{ echo 'non spécifié';} ?></span></p>
                           </div>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12 col-md-7 col-lg-8 mb-5 grid">
                  <?php
                     if($errorGenre || $errorLastname || $errorFirstname || $errorPhone || $errorBirthday) { ?>
                  <div class="alert alert-warning">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                     <strong>Erreur!</strong> Désolé, nous n'avons pas pu mettre à jour votre profil, veuillez réessayer à nouveau !
                  </div>
                  <?php }
                     ?>
                  <?php
                     if(isset($_SESSION['message_CB']) && !empty($_SESSION['message_CB'])) { ?>
                  <div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                     <strong>Succès!</strong> <?= $_SESSION['message_CB'] ?>
                  </div>
                  <?php $_SESSION['message_CB'] = ""; }
                     ?>
                  <nav class="btns" role="tablist" aria-label="Tabs">
                     <button class="<?php if($_SESSION['type_profile'] !='talents') echo 'd-none'?>" role="tab" aria-selected="true" aria-controls="panel-1" id="tab-1" tabindex="0" data-setState="section1">Mes publications</button>
                     <button role="tab" aria-selected="false" aria-controls="panel-2" id="tab-2" tabindex="-1" data-setState="section2">Mes contacts</button>
                  </nav>
                  <article id="panel-1" class="<?php if(count($photos) < 2) echo 'not-photos-post'; ?>" role="tabpanel" tabindex="0" aria-labelledby="tab-1" data-scene="section1">
                     <?php if($_SESSION['type_profile'] =='talents') {
                        if($user_current['photos']) { ?>
                     <p class="heading pt-0">Mes publications</p>
                     <div class="row my-gallery">
                        <?php
                           for ($i=1; $i < count($photos); $i++) { ?>
                        <div class="col-sm-12 col-md-6 col-lg-4 text-center">
                           <div class="img-box">
                              <div class="my-picture" style="background-image : url(<?= $photos[$i] ?>)"> </div>
                              <div class="transparent-box">
                                 <div class="caption">
                                    <p><span class="ti-share"> 45</span></p>
                                    <p><span class="ti-heart"> 10</span></p>
                                    <form  method="post" class="d-inline" action="my-profile.php?delete-photo=true&url-photo=<?= $photos[$i]?>">
                                       <p><span class="trash-post ti-trash"></span></p>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php } ?>
                     </div>
                     <?php } } ?>
                  </article>
                  <article id="panel-2" role="tabpanel" tabindex="0" aria-labelledby="tab-2" data-scene="section2">
                     <p class="heading pt-0">Mes contacts</p>
                     <div class="contacts m-auto <?php $contacts = false; if(!$contacts ) echo ' not-contact'?>">
                        <ul>
                           <li>
                              <div class="profile-photo" style="background-image : url(<?php if($photos[0]){ echo $photos[0]; } else { echo 'img/talents/no-picture.png'; } ?>)"></div>
                              <div class="profile-name">George Clooney</div>
                              <div class="profile-message">Nespresso, what else?</div>
                              <div class="profile-time">19:40</div>
                           </li>
                        </ul>
                     </div>
                  </article>
               </div>
            </div>
            <?php if($_SESSION['type_profile'] == 'talents') { ?>
            <div class="search_filter_iner">
               <div class="action-filter-md mb-5">
                  <div class="back-btn">
                     <span class="ti-close"></span>
                     Retour
                  </div>
               </div>
               <form method="post" class="form_auth_iner _form" action="?update">
                  <div class="row">
                     <div class="col-12 switch-wrap d-flex">
                        <?php if($errorGenre) ?>
                        <small class="error form-text"> <?php echo $errorGenre ?> </small>
                        <p>Homme</p>
                        <div class="primary-radio">
                           <input type="radio" <?php if($user_current['genre'] == 'Homme') echo 'checked'?> name="genre" value="Homme" id="homme">
                           <label for="homme"></label>
                        </div>
                        <p>Femme</p>
                        <div class="primary-radio">
                           <input type="radio" <?php if($user_current['genre'] == 'Femme') echo 'checked'?> name="genre" value="Femme" id="femme">
                           <label for="femme"></label>
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="name">Nom</label>
                        <input value="<?= $user_current['lastname'] ?>" type="text" id="lastname"  class="form-control" name="lastname" placeholder="Nom">
                        <?php if($errorLastname) ?> <small class="error form-text"> <?php echo $errorLastname ?> </small>
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="birthday">Date de naissance</label>
                        <?php
                           $birthday = DateTime::createFromFormat('j-m-Y', $user_current['birthday']);
                           $birthday = $birthday->format('Y-m-d'); ?>
                        <input value="<?= $birthday ?>" type="date" id="birthday"  class="form-control" name="birthday">
                        <?php if($errorBirthday) ?> <small class="error form-text"> <?php echo $errorBirthday ?> </small>
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="firstname">Prénom</label>
                        <input value="<?= $user_current['firstname'] ?>" type="text" class="form-control" name="firstname" placeholder="Prénom">
                        <?php if($errorFirstname) ?> <small class="error form-text"> <?php echo $errorFirstname ?> </small>
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="phone">Téléphone</label>
                        <input value="<?= $user_current['phone'] ?>" type="text" id="phone" class="form-control" name="phone" placeholder="Téléphone">
                        <?php if($errorPhone) ?> <small class="error form-text"> <?php echo $errorPhone ?> </small>
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="address">Adresse</label>
                        <input value="<?= $user_current['address'] ?>" type="text" id="address" class="form-control" name="address" placeholder="Adresse">
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="size">Taile (m)</label>
                        <input value="<?= $user_current['size'] ?>" type="text" id="size" class="form-control" name="size" placeholder="Taile (m)">
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="color_eyes">Couleur des yeux</label>
                        <input value="<?= $user_current['color_eyes'] ?>" type="text" id="color_eyes" class="form-control" name="color_eyes" placeholder="Couleur des yeux">
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="color_hair">Couleur de cheveux</label>
                        <input value="<?= $user_current['color_hair'] ?>" type="text" id="color_hair" class="form-control" name="color_hair" placeholder="Couleur de cheveux">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 col-md-6 mb-sm-4">
                        <a href="my-profile.php" class="w-100 genric-btn primary-border mr-5">Annuler</a>
                     </div>
                     <div class="col-sm-12 col-md-6">
                        <button type="submit" class="w-100 genric-btn primary">Enregistrer</button>
                     </div>
                  </div>
               </form>
            </div>
            <?php } else { ?>
            <div class="search_filter_iner">
               <div class="action-filter-md mb-5">
                  <div class="back-btn">
                     <span class="ti-close"></span>
                     Retour
                  </div>
               </div>
               <form method="post" class="form_auth_iner _form" action="?update">
                  <div class="row">
                     <div class="col-12 switch-wrap d-flex">
                        <?php if($errorGenre) ?>
                        <small class="error form-text"> <?php echo $errorGenre ?> </small>
                        <p>Homme</p>
                        <div class="primary-radio">
                           <input type="radio" <?php if($user_current['genre'] == 'Homme') echo 'checked'?> name="genre" value="Homme" id="homme">
                           <label for="homme"></label>
                        </div>
                        <p>Femme</p>
                        <div class="primary-radio">
                           <input type="radio" <?php if($user_current['genre'] == 'Femme') echo 'checked'?> name="genre" value="Femme" id="femme">
                           <label for="femme"></label>
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="name">Nom</label>
                        <input value="<?= $user_current['lastname'] ?>" type="text" id="lastname"  class="form-control" name="lastname" placeholder="Nom">
                        <?php if($errorLastname) ?> <small class="error form-text"> <?php echo $errorLastname ?> </small>
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="firstname">Prénom</label>
                        <input value="<?= $user_current['firstname'] ?>" type="text" class="form-control" name="firstname" placeholder="Prénom">
                        <?php if($errorFirstname) ?> <small class="error form-text"> <?php echo $errorFirstname ?> </small>
                     </div>
                     <div class="col-sm-12 col-md-6 mb-md-4">
                        <label for="phone">Téléphone</label>
                        <input value="<?= $user_current['phone'] ?>" type="text" id="phone" class="form-control" name="phone" placeholder="Téléphone">
                        <?php if($errorPhone) ?> <small class="error form-text"> <?php echo $errorPhone ?> </small>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-sm-12 col-md-6 mb-sm-4">
                        <a href="my-profile.php" class="w-100 genric-btn primary-border mr-5">Annuler</a>
                     </div>
                     <div class="col-sm-12 col-md-6">
                        <button type="submit" class="w-100 genric-btn primary">Enregistrer</button>
                     </div>
                  </div>
               </form>
            </div>
            <?php }?>
         </div>
      </section>
      <?php
         if($_SESSION['type_profile'] == 'talents') { ?>
      <div class="wrap-icon-footer">
         <div class="DropZone__Preview--input">
            <form method="post" action="includes/upload.php" enctype="multipart/form-data" id="picUploadForm" target="uploadTarget">
               <input name="picture" id="preview_input" multiple type="file"/>
            </form>
            <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
         </div>
      </div>
      <?php } ?>
      <!-- footer part start-->
      <?php
         include_once("includes/footer.php");
         ?>
      <script src="js/rangerInput.min.js"></script>
      <script>
         const grid = document.querySelector('.grid');
         const tabs = document.querySelectorAll('[role="tab"]');
         const tabList = document.querySelector('[role="tablist"]');
         let tabFocus = 0;

         for (const [index, tab] of tabs.entries()) {
           tab.style.setProperty('--i', index + 1);
         }

         tabList.addEventListener('click', e => {
           const tg = e.target;
           if(tg.tagName === 'BUTTON') {
             const index = [...tabList.children].indexOf(tg);
             tabList.style.setProperty('--curr', index);
             tabList.querySelector('[aria-selected="true"]').setAttribute('aria-selected', false);
             tg.setAttribute('aria-selected', true);
             grid.dataset.state = tg.dataset.setstate;
           }
         }, false);

         const initTab1 = $('#tab-1').attr('class')
         if(initTab1 == 'd-none') {
             $('#tab-2').click()
         } else {
             $('#tab-1').click()
         }

         $('.trash-post').on('click', function() {
           const form = $(this).closest("form")
           $(form).submit()
           console.log(form)
         })

         $("#preview_input").change(function(e) {
             e.preventDefault();
             //On select file to upload
             var image = $('#preview_input').val();
             var img_ex = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

             //validate file type
             if(!img_ex.exec(image)){
                 alert('Please upload only .jpg/.jpeg/.png/.gif file.');
                 $('#fileInput').val('');
                 return false;
             }else{
                 $('.uploadProcess').show();
                 $('#uploadForm').hide();
                 $( "#picUploadForm" ).submit();
             }
         })

         function completeUpload(success, fileName) {
             if(success == 1){
                 const row = `<div class="col-sm-12 col-md-6 col-lg-4 text-sm-center">
                               <div class="img-box">
                                   <div class="my-picture" style="background-image : url(img/talents/${fileName})"> </div>
                                   <div class="transparent-box">
                                       <div class="caption">
                                         <p><span class="ti-share"> 45</span></p>
                                         <p><span class="ti-heart"> 10</span></p>
                                         <form  method="post" class="d-inline" action="my-profile.php?delete-photo=true&url-photo=<?= $photos[$i]?>">
                                           <p><span class="trash-post ti-trash"></span></p>
                                         </form>
                                       </div>
                                   </div>
                               </div>
                             </div>`
               $('#panel-1 .my-gallery').append(row)
               if($('#panel-1').hasClass('not-photos-post')) {
                 $('#panel-1').removeClass('not-photos-post')
               }
               $('.uploadProcess').hide()
             }else{
                 $('.uploadProcess').hide();
                 alert('There was an error during file upload!')
             }
             return true;
         }
      </script>
   </body>
</html>
