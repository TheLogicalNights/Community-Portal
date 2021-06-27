<?php
    session_start();
    include "./config/config.php";
    include('header.php');
?>
    
    <main>
    <?php
        if(isset($_SESSION['forgetpasswordfailure']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['forgetpasswordfailure'].'", "error");
            </script>
            ';
            unset($_SESSION['forgetpasswordfailure']);
        }
        if(isset($_SESSION['forgetpasswordfailure']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['forgetpasswordfailure'].'", "error");
            </script>
            ';
            unset($_SESSION['forgetpasswordfailure']);
        }
        if(isset($_SESSION['resetpasswordfailure']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['resetpasswordfailure'].'", "error");
            </script>
            ';
            unset($_SESSION['resetpasswordfailure']);
        }
    ?>

        <div class="jumbotron my-form login-form mb-0">
            <div class="form-illustration" data-aos="fade-left">
                <?php 
                    if(isset($_SESSION['forgotpasswordotpverified']))
                    {
                        echo '<img src="'.$BASE_URL.'assets/img/illustrations/resetpassword.png" width="500" alt="">';
                    }
                    else
                    {
                       echo '<img src="'.$BASE_URL.'assets/img/illustrations/forogotpassword.png" width="500" alt="">';
                    }    
                ?>
            </div>
            <div class="form-container " data-aos="fade-right">
                <div class="" data-aos="fade-right">
                    <h1 class="mb-5 ms-2">Forget Password ?</h1>
                    <div class="container mb-5">
                        <?php
                    if (!isset($_SESSION['forgetpasswordotpsuccess']) && !isset($_SESSION['forgotpasswordotpverified']))
                    {
                        ?>

                        <form action="<?php echo $BASE_URL; ?>code" method="POST" id="EmailForm">
                            <div class="mb-3">
                                <label for="email" class="   form-label" >Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    aria-describedby="emailHelp" required>
                                <div id="emailHelp" class="text-dark form-text">We'll never share your email with anyone
                                    else.</div>
                            </div>
                            <button type="submit" name="forgetpassword" class="btn btn-primary btn-sm">Generate
                                OTP</button>
                        </form>
                        <?php
                    } // End of if
                    ?>
                        <?php
                        if (isset($_SESSION['forgetpasswordotpsuccess']))
                        {
                    ?>
                        <form action="<?php echo $BASE_URL; ?>code" method="POST" id="VerifyForm">
                            <div class="mb-3 mt-5">
                                <label for="otp" class="  form-label" >Verify OTP</label>
                                <input type="number" class="form-control" id="otp" name="otp">
                            </div>
                            <button type="submit" name="forgetpasswordverifyotp" class="btn btn-primary btn-sm">Verify OTP</button>
                        </form>
                        <?php
                            unset($_SESSION['forgetpasswordotpsuccess']);
                        } // End of if
                    ?>
                        <?php
                        if ((isset($_SESSION['forgotpasswordotpverified'])))
                        {
                            unset($_SESSION['forgotpasswordotpverified']);
                    ?>
                        <form class="mt-5" action="<?php echo $BASE_URL; ?>code" method="POST">

                            <div class="mb-3">
                                <label for="newpassword" class="form-label">New Password</label>
                                <input type="text" class="form-control" minlength="8" maxlength="16" id="newpassword" name="newpassword"
                                    aria-describedby="emailHelp" required>
                            </div>

                            <div class="mb-3">
                                <label for="confirmpassword" class="form-label">Confirm Password</label>
                                <input type="text" class="form-control" id="confirmpassword" name="confirmpassword" minlength="8" maxlength="16" aria-describedby="emailHelp" onkeyup="validate(this);" required>
                                <small id="small" style="color: red;"></small>
                            </div>
                            <button type="submit" name="changepassword" class="btn btn-primary mt-3">Reset Password</button>
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