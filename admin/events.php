<?php
   include_once('includes/connection.php');
   include_once('includes/users.php');
   include_once('includes/events.php');
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
   function isJSON($string){
      return is_string($string) && is_array(json_decode($string, true)) ? true : false;
   }
   $error = false ;
   $article = new Event();
   if(isset($_GET['search']) && !empty($_GET['search'])) {
     $articles = $article->fetch_keyWord($_GET['search']);
   } else {
     $articles = $article->fetch_all();

   }

   // delete event
   if(isset($_GET['delete']) && !empty($_GET['id'])) {
     $author = $user_current['firstname'].' '.$user_current['lastname'];
     $deleteArticle = $article->delete_event($_GET['id'], $author);
     if(isJSON($deleteArticle)) {
       $error = json_decode($deleteArticle);
       $error = $error->{"error"};
     }
   }

   ?>
<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Mode</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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
               <div class="col-md-12 col-lg-9 grid">
                  <div class="module">
                     <div class="m-3">
                        <?php
                           if(isset($_SESSION['message_CB_admin']) && !empty($_SESSION['message_CB_admin'])) { ?>
                        <div class="alert alert-success">
                           <button type="button" class="close" data-dismiss="alert">×</button>
                           <strong>Succes!</strong> <?= $_SESSION['message_CB_admin'] ?>
                        </div>
                        <?php $_SESSION['message_CB_admin'] = ""; }
                           ?>
                     </div>
                     <div class="m-3">
                        <?php
                           if($error || !empty($_SESSION['error_CB_admin'])) { ?>
                        <div class="alert">
                           <button type="button" class="close" data-dismiss="alert">×</button>
                           <?php
                              if($error) { ?>
                           <strong>Attention!</strong> <?= $error ;?>
                           <?php } else { ?>
                           <strong>Erreur !</strong> <?= $_SESSION['error_CB_admin'] ;?>
                           <?php }
                              ?>
                        </div>
                        <?php $_SESSION['error_CB_admin'] = ""; }
                           ?>
                     </div>
                     <div class="d-flt">
                        <a href="create-event.php"><i class="menu-icon icon-plus"></i> créer un article</a>
                     </div>
                     <nav class="btns mt-3 mr-3" role="tablist" aria-label="Tabs">
                        <button class="" role="tab" aria-selected="false" aria-controls="panel-1" id="tab-1" tabindex="0" data-setState="section1">Liste</button>
                        <button role="tab" aria-selected="true" aria-controls="panel-2" id="tab-2" tabindex="-1" data-setState="section2">Tableau</button>
                     </nav>
                     <article id="panel-1" class="" role="tabpanel" tabindex="0" aria-labelledby="tab-1" data-scene="section1">
                        <div class="row ml-2 mr-2">
                           <div class="col-4 mb-4">
                              <form class="form" action="" method="get">
                                 <label class="small d-block mb-0" for="search">Rechercher</label>
                                 <input class="form-control" type="text" name="search" placeholder="mot clé" value="<?php if(isset($_GET['search'])) { echo $_GET['search']; } ?>">
                              </form>
                           </div>
                        </div>
                        <div class="row ml-2 mr-2 list-wrapper">
                           <?php
                              if($articles) {
                                foreach ($articles as $elem) {
                                  $title = (strlen($elem['title']) > 30) ? substr($elem['title'],0,35).'...' : $elem['title'];
                                  $content = (strlen($elem['content']) > 38) ? substr($elem['content'],0,38).'...' : $elem['content'];
                                  $date_depart = DateTime::createFromFormat('Y-m-j', $elem['date_depart']);
                                  $day = $date_depart->format('d');
                                  $month = $date_depart->format('M');
                                  $year = $date_depart->format('Y');
                                  ?>
                           <div class="col-lg-6 col-md-6 col-sm-12">
                              <div class="event-list" style="padding: 0;">
                                 <div class="item">
                                    <div class="time">
                                       <span class="day"> <?= $day ?>
                                       <span class="month"><?= $month; ?></span>
                                       <span class="year"><?= $year; ?></span>
                                    </div>
                                    <div class="info">
                                       <h4>
                                          <span class="font-weight-bold"><?= $title ?></span>
                                       </h4>
                                       <div class="desc">
                                          <div class="font-weight-bolder">
                                             <span>de <?= $elem['hour_depart'].' h' ?></span> à <span><?= $elem['hour_depart'].' h' ?></span>
                                          </div>
                                          <div class="action-btn">
                                             <a class="_icon" href="edit-event.php?edit=true&id=<?= $elem['id'] ?>"> <i class="menu-icon icon-edit"></i> </a>
                                             <a class="_icon" href="?delete=true&id=<?= $elem['id'] ?>"> <i class="menu-icon icon-trash"></i> </a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php
                              } ?>
                           <div class="col-12">
                              <div id="pagination-container"></div>
                           </div>
                           <?php
                              }else {
                                if(isset($_GET['search'])) { ?>
                           <div class="col-12">
                              <p> Nous avons rien trouvé</p>
                           </div>
                           <div class="col-12">
                              <a class="btn mt-3 mb-3 btn-primary" href="conseils.php">Retour</a>
                           </div>
                           <?php } else { ?>
                           <p> il n'a pas encore des événements</p>
                           <?php }
                              }
                              ?>
                        </div>
                     </article>
                     <article id="panel-2" role="tabpanel" tabindex="0" aria-labelledby="tab-2" data-scene="section2">
                        <div class="module-body table">
                           <table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped	 display" width="100%">
                              <thead>
                                 <tr>
                                    <th>Action</th>
                                    <th>Titre</th>
                                    <th>Dates</th>
                                    <th>Heures</th>
                                    <th>Auteur</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    if($articles) {
                                      foreach ($articles as $elem) {
                                        $title = (strlen($elem['title']) > 28) ? substr($elem['title'],0,33).'...' : $elem['title'];
                                        $date_depart = DateTime::createFromFormat('Y-m-j', $elem['date_depart']);
                                        $date_depart = $date_depart->format('d-m-Y');
                                        $date_end = DateTime::createFromFormat('Y-m-j', $elem['date_end']);
                                        $date_end = $date_end->format('d-m-Y');
                                      ?>
                                 <tr class="gradeA even">
                                    <td class="sorting_1">
                                       <a class="_icon" href="edit-event.php?edit=true&id=<?= $elem['id'] ?>"> <i class="menu-icon icon-edit"></i> </a>
                                       <a class="_icon" href="?delete=true&id=<?= $elem['id'] ?>"> <i class="menu-icon icon-trash"></i> </a>
                                    </td>
                                    <td class=" "><?= $title ?></td>
                                    <td class="center "><?= 'du '.$date_depart.' au '.$date_end ?></td>
                                    <td class="center "><?= $elem['hour_depart'].' pour '.$elem['hour_end'] ?></td>
                                    <td class="center "><?= $elem['author'] ?></td>
                                 </tr>
                                 <?php }
                                    }
                                    ?>
                              </tbody>
                              <tfoot>
                                 <tr>
                                    <th>Action</th>
                                    <th>Titre</th>
                                    <th>Dates</th>
                                    <th>Heures</th>
                                    <th>Auteur</th>
                                 </tr>
                              </tfoot>
                           </table>
                        </div>
                     </article>
                  </div>
               </div>
            </div>
         </div>
         <!--/.container-->
      </div>
      <!--/.wrapper-->
      <?php include_once('includes/footer.php'); ?>
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      <script src="https://cdn.tiny.cloud/1/74dynsu9ax3oqpzblnl0wgz3ebpmpu9howykdxz8gjg5gamd/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
      <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
      <script src="scripts/flot/jquery.flot.resize.js" type="text/javascript"></script>
      <script src="scripts/datatables/jquery.dataTables.js" type="text/javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js" type="text/javascript"></script>
      <!-- <script src="scripts/common.js" type="text/javascript"></script> -->
      <script>
         $(document).ready(function() {
         	$('.datatable-1').dataTable();
         	$('.dataTables_paginate').addClass("btn-group datatable-pagination");
         	$('.dataTables_paginate > a').wrapInner('<span />');
         	$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
         	$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
         } );
      </script>
      <script type="text/javascript">
         const grid = document.querySelector('.grid');
         const tabs = document.querySelectorAll('[role="tab"]');
         const tabList = document.querySelector('[role="tablist"]');
         console.log();
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
         });
         
      </script>
   </body>
</html>
