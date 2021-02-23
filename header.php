<?php
//session_start();
date_default_timezone_set("Asia/Kolkata");
include "./config/config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo $BASE_URL; ?>assets/css/style.css"> <!-- SLICK SLIDER  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" />
    <link rel="icon" href="<?php echo $BASE_URL; ?>assets/img/logo.png" type="image/png" sizes="16x16">
    <title>Febina Community Members</title>
    <!-- AOS  -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- MDI  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css" integrity="sha512-vIgFb4o1CL8iMGoIF7cYiEVFrel13k/BkTGvs0hGfVnlbV6XjAA0M0oEHdWqGdAVRTDID3vIZPOHmKdrMAUChA==" crossorigin="anonymous" />
    <!-- CkEditor -->
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>


    <!-- sweet alert cdn -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Stylesheet for icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- ANIMXYZ  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@animxyz/core@0.4.0/dist/animxyz.min.css">


    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet"> 
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@200&display=swap" rel="stylesheet"> 
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Bubblegum+Sans&display=swap" rel="stylesheet"> 
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Chicle&display=swap" rel="stylesheet"> 
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Libre+Franklin&display=swap" rel="stylesheet">  
    </head>
<script>
    function validate(obj) {
        var newpassword = document.getElementById('newpassword').value;
        if (newpassword != obj.value) {
            document.getElementById('small').innerHTML = "Passwords dosn't match....";
        } else {
            document.getElementById('small').innerHTML = "";

        }
    }
</script>

<body>
    <!-- Here is another comment -->
    <nav class="navbar sticky navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index">
                <img src="<?php echo $BASE_URL; ?>assets/img/logo.png" alt="" width="60" height="60" class="d-inline-block align-top"> <span style="font-weight:800;">Febina Community</span> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link me-2 mt-2" aria-current="page" href="<?php echo $BASE_URL; ?>index">Home <i class="mdi mdi-home"></i></a>
                    </li>
                    <li class="nav-item mt-2">
                            <a class="nav-link" href="<?php echo $BASE_URL; ?>feed">Feed <i class="mdi mdi-television-guide"></i></a>
                    </li>
                    <?php
                    if (isset($_SESSION['status'])) {
                    ?>
                        
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="<?php echo $BASE_URL; ?>addpost">Add Post <i class="mdi mdi-pen"></i></a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="<?php echo $BASE_URL; ?>profile">Profile <i class="mdi mdi-account"></i></a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="<?php echo $BASE_URL; ?>members">Members <i class="fa fa-users ms-1"></i></a>
                        </li>
                        <li class="nav-item mt-2">
                            <form action="<?php echo $BASE_URL; ?>code" method="post">
                                <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                                <button class="btn btn-primary" type="submit" name="logout">Sign Out <i class="fa fa-sign-out ms-1" aria-hidden="true"></i></button>
                            </form>
                        </li>

                    <?php
                    } else {
                    ?>
                        <li class="nav-item me-3 mt-2">
                            <a class="btn btn-primary" href="<?php echo $BASE_URL; ?>signin">Sign In <i class="fa fa-sign-in ms-1" aria-hidden="true"></i></a>
                        </li>
                        <li class="nav-item me-3 mt-2">
                            <a href="<?php echo $BASE_URL; ?>signup" class="btn btn-primary">Sign Up <i class="fa fa-user-plus ms-1"></i></a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
                <span class="navbar-text">
                </span>
            </div>
        </div>
    </nav>