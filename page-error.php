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
         include_once("includes/header.php")
         ?>
      <!-- Header part end-->
      <!-- breadcrumb start-->
      <section class="breadcrumb _form breadcrumb_bg align-items-center">
         <div class="container">
            <form action="" method="get">
               <div class="row align-items-center">
                  <div class="col-sm-12 mb-5">
                     <div class="breadcrumb_tittle text-left">
                        <h2>Page not found</h2>
                     </div>
                  </div>
                  <div class="col-12 col-md-6">
                     <p class="text-white mb-3">
                        Désolé, nous n'avons pas trouvé cette page
                     </p>
                     <a href="index.php" class="genric-btn primary">Acceuil</a>
                     <a href="contact.php" class="genric-btn primary">Contact</a>
                  </div>
               </div>
            </form>
         </div>
      </section>
      <!-- breadcrumb start-->
      <!-- footer part start-->
      <?php
         include_once("includes/footer.php");
         ?>
      <script src="js/rangerInput.min.js"></script>
   </body>
</html>
