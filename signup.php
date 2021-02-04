<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- SLICK SLIDER  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"
        integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css"
        integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
        crossorigin="anonymous" />
    <title>Febina Community Members</title>

    <!-- AOS  -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Sweet alert js -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- MDI  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.9.55/css/materialdesignicons.min.css"
        integrity="sha512-vIgFb4o1CL8iMGoIF7cYiEVFrel13k/BkTGvs0hGfVnlbV6XjAA0M0oEHdWqGdAVRTDID3vIZPOHmKdrMAUChA=="
        crossorigin="anonymous" />
</head>

<body>

    <!-- Here is another comment -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./assets/img/logo.png" alt="" width="60" height="60" class="d-inline-block align-top"> Febina
                Community </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
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
    <?php
        if(isset($_SESSION['RegisterFailure']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['RegisterFailure'].'", "error");
            </script>
            ';
            unset($_SESSION['RegisterFailure']);
        }
    ?>
        <div class="slick-go">
            <div class="banner"
                style="background:url(https://images.pexels.com/photos/853168/pexels-photo-853168.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);">
                <div class="hero-text col-lg-5" data-aos="fade-right">
                    <h1 class="mb-5 ms-2">Sign Up</h1>
                    <div class="container mb-5">
                        <?php
                    if (!isset($_SESSION['otpsuccess']) && !isset($_SESSION['otpverified']))
                    {
                ?>

                        <form action="/Febina/Members-Portal/code.php" method="POST" id="EmailForm">
                            <div class="mb-3">
                                <label for="email" class=" text-white form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    aria-describedby="emailHelp">
                                <div id="emailHelp" class="text-dark form-text">We'll never share your email with anyone
                                    else.</div>
                            </div>
                            <button type="submit" name="generateotp" class="btn btn-primary btn-sm">Generate
                                OTP</button>
                        </form>
                        <?php
                    } // End of if
                    ?>
                        <?php
                        if (isset($_SESSION['otpsuccess']))
                        {
                    ?>
                        <form action="/Febina/Members-Portal/code.php" method="POST" id="VerifyForm">
                            <div class="mb-3 mt-5">
                                <label for="otp" class="text-white form-label">Verify OTP</label>
                                <input type="number" class="form-control" id="otp" name="otp">
                            </div>
                            <button type="submit" name="verifyotp" class="btn btn-primary btn-sm">Verify OTP</button>
                        </form>
                        <?php
                            unset($_SESSION['otpsuccess']);
                        } // End of if
                    ?>
                        <?php
                        if (isset($_SESSION['otpverified']))
                        {
                    ?>
                        <form class="mt-5" action="/Febina/Members-Portal/code.php" method="POST">
                            <div class="mb-3 mt-5">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                                <label for="contactnumber" class="form-label">Contact number</label>
                                <input type="text" class="form-control" id="contactnumber" name="contactnumber"
                                    aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    aria-describedby="emailHelp" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    aria-describedby="emailHelp" required onkeyup="check(this);">
                                <small id="small" style="color: red;"></small>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="key" class="form-label">VA key</label>
                                <input type="text" class="form-control" id="key" name="key" aria-describedby="emailHelp"
                                    required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary mt-3">REGISTER</button>
                        </form>
                        <?php
                            unset($_SESSION['otpverified']);
                        } // End of if
                    ?>
                    </div>
                </div>
            </div>
            <div class="banner" style="background:url(https://images.pexels.com/photos/862848/pexels-photo-862848.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);">
                <div class="hero-text col-lg-5" data-aos="fade-right">
                    <h1>Grow Learn Think Share and Prosper With Us Together</h1>
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Non molestiae temporibus voluptatibus fugit eius aut accusamus officia porro aliquam placeat vitae quod, quisquam, magnam quas quaerat voluptatum. Labore, beatae placeat.</p>
                    <a href="#" class="btn btn-primary">Know More</a>
                </div>
            </div>
        </div>

        <div class="jumbotron usp-section">
            <div class="container">
                <center>
                    <h1>Why Join Febina Community</h1>
                </center>
                <div class="cards-section">
                    <div class="card" data-aos="fade-up">
                        <img src="https://cdn2.iconfinder.com/data/icons/free-version/128/workplace-256.png"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="100">
                        <img src="https://cdn2.iconfinder.com/data/icons/free-version/128/workplace-256.png"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="200">
                        <img src="https://cdn2.iconfinder.com/data/icons/free-version/128/workplace-256.png"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="300">
                        <img src="https://cdn2.iconfinder.com/data/icons/free-version/128/workplace-256.png"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="400">
                        <img src="https://cdn2.iconfinder.com/data/icons/free-version/128/workplace-256.png"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>
                    <div class="card" data-aos="fade-up" data-aos-delay="500">
                        <img src="https://cdn2.iconfinder.com/data/icons/free-version/128/workplace-256.png"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="jumbotron story-section">
            <div class="col-lg-6 p-4" data-aos="fade-in" data-aos-delay="200">
                <h1>Our Aim is to Make Every Women Independent and Self Sufficient</h1>
            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
    <!-- JQUERY  -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous"></script>
    <script src="./assets/js/script.js"></script>

    <!-- AOS  -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        $(document).ready(function () {
            AOS.init();
        });
    </script>

</body>

</html>