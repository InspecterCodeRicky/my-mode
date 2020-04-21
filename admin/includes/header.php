<?php
include_once('includes/connection.php');
include_once('includes/users.php');
// get class User
$user = new User();

// get user by email
$user_current = $user->get_user_talent_by_email($_SESSION['email_ad'], 'users');

// print_r($user);
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">My Mode</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#"><i class="icon-envelope"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="icon-eye-open"></i></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="icon-bar-chart"></i></a>
      </li>
      <form class="form-inline ml-md-4 mb-2">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn my-2 my-sm-0" type="submit"><i class="icon-search"></i></button>
      </form>
    </ul>
    <ul class="navbar-nav mr-5">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="<?= $user_current['profile_target'] ?>" class="nav-avatar">
          <span class="navbar-brand lead font-weight-bolder" href="#"><?php if($user_current) {echo $user_current["firstname"];} ?></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>

  </div>
</nav>
