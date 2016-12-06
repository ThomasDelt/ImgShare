<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Img Share</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->


    <div class="container">
      <div class="title">
        <h1 class="text-center">Img Share</h1>
        <h2 class="text-center">Partagez vos photos en quelques clics</h2>
      </div>
      <div class="row">
        <div class="col-md-4">
          <p class="text-center"><i class="fa fa-eur fa-5x" aria-hidden="true"></i></p>
          <h2 class="text-center">Totalement gratuit</h2>
          <p>Img share vous permet de stocker et partager vos images gratuitement.</p>
        </div>
        <div class="col-md-4">
          <p class="text-center"><i class="fa fa-window-restore fa-5x" aria-hidden="true"></i></p>
          <h2 class="text-center">Sans publicité</h2>
          <p>Marre des publicités qui envahissent votre écran ? Img Share est totalement anti-pub. Plus besoin de bloqueur de publicité pour venir uploader vos images !</p>
         
       </div>
        <div class="col-md-4">
          <p class="text-center"><i class="fa fa-sign-in fa-5x" aria-hidden="true"></i></p>
          <h2 class="text-center">Pas d'inscription requise</h2>
          <p>Aucune inscription n'est requise pour uploader vos images. Nous ne stockons absolumment aucune de vos données personnelles.</p>
        </div>
      </div>

      <hr>
      <form id="form" method="post" enctype="multipart/form-data" action="add-file.php">
        <div class="form-group text-center">
          <label for="img" id="label-file">Ajouter votre image</label>
          
          <input class="upload-file" name ="img" type="file" id="img-input" accept=".jpg, .png, .jpeg, .gif, .bmp">
        </div>
        <div class="form-group text-center">
          <button id="btn-submit" type="submit">Uploader</button>
          <p>Taille max par image : 1Mo</p>
        </div>
      </form>
      <div id="progress"><i class="fa fa-refresh fa-spin" style="font-size:24px"></i></div>
      <p id="error"></p>
      <p id="success"></p>
      
      <div class="gallerie">
        <h2>Vos images</h2>
        <?php
          $pdo = new PDO('mysql:host=localhost;dbname=imgshare', 'root', '');
          $sql = "SELECT * FROM images";
          foreach ($pdo->query($sql) as $row) {
            $html =
            "<div class='col-lg-3 col-md-3 col-xs-2'>
              <a href=".$row['nom']."><img class='img-responsive' src=".$row['miniature']."></a>
            </div>";

            echo $html;
          }

        ?>
      </div>
      <footer>
        <p class="text-center">&copy; Img Share 2016</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/main.js"></script>

    </body>
</html>
