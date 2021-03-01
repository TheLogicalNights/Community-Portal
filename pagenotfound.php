<?php
    session_start();
    include "./config/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page not found</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@600;900&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/4b9ba14b0f.js" crossorigin="anonymous"></script>
<style>
body {
    background: rgb(255, 227, 174);
}
.page-wrap {
    min-height: 75vh;
}
</style>
</head>
<body>

<div class="page-wrap d-flex flex-row align-items-center">
    <div class="container p-4" style="border: 2px solid white; border-radius:15px;">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
            
                <span class="display-1 d-block">4<i class="far fa-question-circle fa-spin 2x"></i>4</span>
                <div class="mb-4 lead">The page you are looking for was not found.</div>
                <hr>
                <a href="<?php echo $BASE_URL; ?>index" class="btn btn-link">Back to Home</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>