<?php
    session_start();
    include('./database/db.php');
    $query = "select * from posts";
    $res = mysqli_query($conn,$query);
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- SLICK SLIDER  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" />
    <title>Febina Community Members</title>

    <!-- AOS  -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- MDI  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css" integrity="sha512-vIgFb4o1CL8iMGoIF7cYiEVFrel13k/BkTGvs0hGfVnlbV6XjAA0M0oEHdWqGdAVRTDID3vIZPOHmKdrMAUChA==" crossorigin="anonymous"
    />
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./assets/img/logo.png" alt="" width="60" height="60" class="d-inline-block align-top"> Febina Community </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feed.php">Feed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addpost.php">Add Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="#">Sign In</a>
                    </li>
                </ul>
                <span class="navbar-text">
        </span>
            </div>
        </div>
    </nav>


    <main>

        <div class="jumbotron feed-top-section">

        </div>

        <div class="jumbotron feed-body-section">
            <center>
                <h1 style="padding: 30px 0;">Latest Posts</h1>
            </center>
            <div class="container feed-cards">
            <?php

                if ($res)
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        echo '
                        <div class="card mb-3 post-card">
                            <div class="row g-0">
                                <div class="post-img col-md-4">
                                    <img src="demo.jpg" alt="Post Image">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">'.$row['posttitle'].'</h5>
                                        <p class="card-text">'.$row['post'].'</p>
                                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>            
                        ';
                    }
                }
            ?>
        </div>


    </main>



    <footer class="footer-distributed">

        <div class="footer-right">
            <a href="#"><span class="mdi mdi-facebook"></span></a>
            <a href="#"><span class="mdi mdi-twitter"></span></a>
            <a href="#"><span class="mdi mdi-linkedin"></span></a>
            <a href="#"><span class="mdi mdi-instagram"></span></a>

        </div>

        <div class="footer-left">

            <p class="footer-links">
                <span class="mdi mdi-facebook-box"></span>
                <a class="link-1" href="#">Home </a>

                <a href="#">Blog</a>

                <a href="#">Pricing</a>

                <a href="#">About</a>

                <a href="#">Faq</a>

                <a href="#">Contact</a>
            </p>

            <p>Febina Community &copy; 2021</p>
        </div>

    </footer>

    <!-- BOOTSTRAP  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <!-- JQUERY  -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous"></script>
    <script src="./assets/js/script.js"></script>

    <!-- AOS  -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        $(document).ready(function() {
            AOS.init();
        });
    </script>


</body>

</html>