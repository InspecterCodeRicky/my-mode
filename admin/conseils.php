<?php
include_once('includes/connection.php');
include_once('includes/users.php');
include_once('includes/articles.php');
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
$article = new Article();
if(isset($_GET['search']) && !empty($_GET['search'])) {
 $articles = $article->fetch_keyWord($_GET['search']);
} else {
 $articles = $article->fetch_all();

}

if(isset($_GET['delete']) && !empty($_GET['id'])) {
 $author = $user_current['firstname'].' '.$user_current['lastname'];
 $deleteArticle = $article->delete_article($_GET['id'], $author);
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
                    <a href="create-article.php"><i class="menu-icon icon-plus"></i> créer un article</a>
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
                              $title = (strlen($elem['title']) > 40) ? substr($elem['title'],0,45).'...' : $elem['title'];
                              $content = (strlen($elem['content']) > 200) ? substr($elem['content'],0,200).'...' : $elem['content'];

                              ?>
                       <div class="col-sm-12 col-md-6 mb-4 list-item">
                          <div class="card">
                             <div class="bg-article" style="background-image : url(<?= $elem['target_file'] ?>)"></div>
                             <div class="mr-3 ml-3 mt-2">
                                <span class="small text-italic"><?= $elem['author'] ?></span>
                                <span class="small text-italic float-right"><?= $elem['date_create'] ?></span>
                             </div>
                             <div class="card-body pt-2">
                                <h5 class="card-title lead font-weight-bolder"><?= $title ?></h5>
                                <div class="card-text content mb-2 text-justify"><?= $content; ?></div>
                                <a href="edit-article.php?edit=true&id=<?= $elem['id'];?>" class="btn btn-primary">Éditer</a>
                                <a href="conseils.php?delete=true&id=<?= $elem['id'];?>" class="btn float-right btn-danger">Supprimer</a>
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
                       <p> il n'a pas encore d'artciles pour le blog nos conseils</p>
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
                                <th>Photo</th>
                                <th>Titre</th>
                                <th>contenu</th>
                                <th>Auteur</th>
                                <th>Date création</th>
                             </tr>
                          </thead>
                          <tbody>
                             <?php
                                if($articles) {
                                  foreach ($articles as $elem) {
                                    $title = (strlen($elem['title']) > 30) ? substr($elem['title'],0,30).'...' : $elem['title'];
                                    $content = (strlen($elem['content']) > 70) ? substr($elem['content'],0,70).'...' : $elem['content'];
                                  ?>
                             <tr class="gradeA even">
                                <td class="sorting_1">
                                   <a class="_icon" href="edit-article.php?edit=true&id=<?= $elem['id'];?>"> <i class="menu-icon icon-edit"></i> </a>
                                   <a class="_icon" href="conseils.php?delete=true&id=<?= $elem['id'];?>"> <i class="menu-icon icon-trash"></i> </a>
                                </td>
                                <td class="sorting_1">
                                   <div class="table-image-bg bg-article" style="background-image : url(<?= $elem['target_file'] ?>)"></div>
                                </td>
                                <td class=" "><?= $title ?></td>
                                <td class=" "><?= $content ?></td>
                                <td class="center "><?= $elem['author'] ?></td>
                                <td class="center "><?= $elem['date_create'] ?></td>
                             </tr>
                             <?php }
                                }
                                ?>
                          </tbody>
                          <tfoot>
                             <tr>
                                <th>Action</th>
                                <th>Photo</th>
                                <th>Titre</th>
                                <th>contenu</th>
                                <th>Auteur</th>
                                <th>Date création</th>
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
