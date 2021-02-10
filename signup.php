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
    ?>

        <div class="jumbotron my-form login-form mb-0">
            <div class="form-illustration" data-aos="fade-left">
                <img src="/Febina/Members-Portal/assets/img/illustrations/signup.png" width="500" alt="">
            </div>
            <div class="form-container " data-aos="fade-right">
            <div class="" data-aos="fade-right">
                    <h1 class="mb-5 ms-2">Sign Up</h1>
                    <div class="container mb-5">
                        <?php
                    if (!isset($_SESSION['otpsuccess']) && !isset($_SESSION['otpverified']))
                    {
                        ?>

                        <form action="/Febina/Members-Portal/code.php" method="POST" id="EmailForm">
                            <div class="mb-3">
                                <label for="email" class="   form-label" >Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    aria-describedby="emailHelp" required>
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
                                <label for="otp" class="  form-label" >Verify OTP</label>
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
                            unset($_SESSION['otpverified']);
                    ?>
                        <form class="mt-5" action="/Febina/Members-Portal/code.php" method="POST">
                           
                            <div class="row">
                                <div class="col">
                                    <label for="name" class="form-label  ">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        aria-describedby="emailHelp" required>
                                </div>
                                <div class="col mb-3">
                                    <label for="contactnumber" class="form-label  ">Contact number</label>
                                    <input type="text" class="form-control" id="contactnumber" name="contactnumber"
                                        aria-describedby="emailHelp" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label  ">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    aria-describedby="emailHelp" required>
                            </div>
                         
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="username" class="form-label  ">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        aria-describedby="emailHelp" required onkeyup="check(this);">
                                    <small id="small" style="color: red;"></small>
                                </div>
                                <div class="col mb-3">
                                    <label for="password" class="form-label  ">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">

                                <label for="key" class="form-label">VA key</label>
                                <input type="text" class="form-control" id="key" name="key" minlength="12" maxlength="12" aria-describedby="emailHelp"
                                    required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary mt-3">REGISTER</button>
                        </form>
                        <?php
                        } // End of if
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
    include('footer.php');
?>