<?php
include_once('includes/connection.php');
if(isset($_GET['logout']) && $_GET['logout']== 'true') {
    session_destroy();
    header('location: login.php');
    exit();
}
?>

<div class="col-md-12 col-lg-3">
    <div class="sidebar sticky-top">
        <ul class="widget widget-menu list-unstyled">
            <li class="active"><a href="index.php"><i class="menu-icon icon-dashboard"></i>Dashboard</a></li>
            <li><a href="message.php"><i class="menu-icon icon-inbox"></i>Messagerie<b class="label green pull-right">11</b> </a></li>
            <li><a href="task.php"><i class="menu-icon icon-tasks"></i>Tasks <b class="label orange pull-right">9</b> </a></li>
            <li class="active"><a href="gallery.php"><i class="menu-icon icon-camera"></i>Gallerie</a></li>
        </ul>
        <ul class="widget widget-menu list-unstyled">
          <li>
            <a class="collapsed" data-toggle="collapse" href="#togglePages">
              <i class="menu-icon icon-cog"></i>
              <i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
              Publication
            </a>
            <ul id="togglePages" class="collapse list-unstyled">
              <li><a href="create-article.php"><i class="menu-icon icon-plus"></i> créer un article</a></li>
              <li><a href="create-event.php"><i class="menu-icon icon-plus"></i> créer un événement </a></li>
            </ul>
          </li>
          <li>
            <a class="collapsed" data-toggle="collapse" href="#plusPages">
              <i class="menu-icon icon-cog"></i>
              <i class="icon-chevron-down pull-right"></i><i class="icon-chevron-up pull-right"></i>
              Pages
            </a>
            <ul id="plusPages" class="collapse list-unstyled">
              <li><a href="all-models.php"><i class="menu-icon icon-user"></i> Les models </a></li>
              <li class="active"><a href="all-users.php"><i class="menu-icon icon-user"></i>Utilisateurs</a></li>
              <li><a href="form.php"><i class="menu-icon icon-paste"></i> page à propos </a></li>
              <li><a href="conseils.php"><i class="menu-icon icon-paste"></i> Les conseils </a></li>
              <li><a href="events.php"><i class="menu-icon icon-paste"></i> Les événements </a></li>
            </ul>
          </li>
        </ul>
        <ul class="widget widget-menu list-unstyled">
            <li><a href="user-profile.php"><i class="menu-icon icon-user"></i>Mon profile </a></li>
            <li><a href="?logout=true"><i class="menu-icon icon-signout"></i>Se deconnecter </a></li>
        </ul>
    </div>
</div>
