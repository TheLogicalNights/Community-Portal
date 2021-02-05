<?php
    session_start();
    include('header.php');
?>
    
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
        if(isset($_SESSION['RegisterationSuccess']))
        {
            echo '
            <script>
                swal("Congratulations..!", "'.$_SESSION['RegisterationSuccess'].'", "success");
            </script>
            ';
            unset($_SESSION['RegisterationSuccess']);
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
<?php
    include('footer.php');
?>