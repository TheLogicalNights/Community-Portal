<?php
    //session_start();
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
    <title>Febina Community Members</title>    <!-- AOS  -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />    <!-- MDI  -->
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
    
    <Script>
        function limit(obj) 
        {
            document.getElementById('limit').innerHTML = 200 - obj.value.length + "/200";
        }
    </script>

    </head>
    <body>    
    <!-- Here is another comment -->    
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/Febina/Members-Portal/assets/img/logo.png" alt="" width="60" height="60" class="d-inline-block align-top"> Febina Community </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link me-2 mt-2" aria-current="page" href="/Febina/Members-Portal/index">Home <i class="mdi mdi-home"></i>
</a>
                    </li>
                    <?php
                    if (isset($_SESSION['status']))
                    {
                    ?>
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="/Febina/Members-Portal/feed">Feed <i class="mdi mdi-television-guide"></i>
</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="/Febina/Members-Portal/addpost">Add Post <i class="mdi mdi-pen"></i>
</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="/Febina/Members-Portal/profile">Profile<i class="mdi mdi-account"></i></a>
                        </li>
                        <li class="nav-item mt-2">
                            <a class="nav-link" href="/Febina/Members-Portal/members">Members <i class="fa fa-users"></i></a>
                        </li>
                        <li class="nav-item mt-2">
                            <form action="/Febina/Members-Portal/code" method="post">
                                <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                                <button class="btn btn-primary" type="submit" name="logout">Sign Out</button>
                            </form>
                        </li>
                        
                    <?php
                    }
                    else
                    {
                    ?>
                        <li class="nav-item me-3 mt-2">
                            <a class="btn btn-primary" href="/Febina/Members-Portal/signin">Sign In</a>
                        </li>
                        <li class="nav-item mt-2">
                            <a href="/Febina/Members-Portal/signup" class="btn btn-primary">Sign Up</a>
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