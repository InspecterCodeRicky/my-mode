<?php
include_once('includes/connection.php');
if(isset($_GET['logout']) && $_GET['logout']== 'true') {
    session_destroy();
    header('location: index.php');
    exit();
}
?>
<header class="main_menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="navbar-brand" href="index.php"> <img src="img/logo.png" alt="logo"> </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse main-menu-item justify-content-center"
                        id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Acceuil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="talents.php">Talents</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ressources
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="conseils.php">Nos conseils</a>
                                    <a class="dropdown-item" href="evenements.php">Evènements</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Compte
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php
                                    if(!isset($_SESSION['logged_in'])) { ?>
                                    <a class="dropdown-item" href="login.php">Se connecter</a>
                                    <a class="dropdown-item" href="register-model.php">Devenir un model</a>
                                    <a class="dropdown-item" href="register.php">S'inscrire</a>
                                    <?php
                                        } else { ?>
                                            <a class="dropdown-item" href="my-profile.php">Mon profil</a>
                                            <a class="dropdown-item" href="?logout=true">Se déconnecter</a>
                                    <?php } ?>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.php">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="header_social_icon d-none d-lg-block">
                        <ul>
                            <li>
                                <div id="wrap">
                                    <form action="#" autocomplete="on">
                                        <input id="search" name="search" type="text" placeholder="Rechercher ici..."><span class="ti-search"></span>
                                    </form>
                                </div>
                            </li>
                            <li><a href="#" class="d-none d-lg-block"><i class="ti-facebook"></i></a></li>
                            <li><a href="#" class="d-none d-lg-block"> <i class="ti-twitter-alt"></i></a></li>
                            <li><a href="#" class="d-none d-lg-block"><i class="ti-instagram"></i></a></li>
                            <li><a href="#" class="d-none d-lg-block"><i class="ti-skype"></i></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
