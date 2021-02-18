<?php
    date_default_timezone_set("Asia/Kolkata");
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="/Febina/Members-Portal/assets/css/style.css">    <!-- SLICK SLIDER  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" />
    <link rel="icon" href="./assets/img/logo.png" type="image/png" sizes="16x16">
    <title>Febina Community Members</title>    
    <!-- AOS  -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />    
    <!-- MDI  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css" integrity="sha512-vIgFb4o1CL8iMGoIF7cYiEVFrel13k/BkTGvs0hGfVnlbV6XjAA0M0oEHdWqGdAVRTDID3vIZPOHmKdrMAUChA==" crossorigin="anonymous"
    />    
    <!-- CkEditor -->
    <script src="https://cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>


    <!-- sweet alert cdn -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Stylesheet for icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    
    <!-- ANIMXYZ  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@animxyz/core@0.4.0/dist/animxyz.min.css">
    
    </head>
    <script>
        function showpass() {
            var x = document.getElementById('eye');
            if (x.className == 'fa fa-eye') {
                document.getElementById('eye').className = "fa fa-eye-slash";
                document.getElementById('password').type = "text";
            } else {
                document.getElementById('eye').className = "fa fa-eye";
                document.getElementById('password').type = "password";
            }
        }
    </script>
    <body>    
    <!-- Here is another comment -->    
    <nav class="navbar sticky navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index">
                <img src="/Febina/Members-Portal/assets/img/logo.png" alt="" width="60" height="60" class="d-inline-block align-top"> <span style="font-weight:800;">Febina Community</span> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link mt-2" aria-current="page" href="/Febina/Members-Portal/index">Home <i class="mdi mdi-home"></i></a>
                    </li>
                    <?php
                    if (isset($_SESSION['adminstatus']))
                    {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link mt-2" aria-current="page" href="/Febina/Members-Portal/todayspost">Today's Post <i class="fa fa-podcast"></i></a>
                        </li>
                        <li class="nav-item mt-2">
                            <form action="/Febina/Members-Portal/code" method="post">
                                <button class="btn btn-primary" type="submit" name="adminlogout">Sign Out <i class="fa fa-sign-out ms-1" aria-hidden="true"></i></button>
                            </form>
                        </li>
                </ul>
                    <?php
                    }
                    else
                    {
                    ?>
                        <li class="nav-item mt-2">
                            <a href="/Febina/Members-Portal/adminlogin" class="btn btn-primary">Admin <i class="fa fa-user-circle-o" aria-hidden="true"></i></a>
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