<?php
    session_start();
    include "./config/config.php";
    include('header.php');
    $uname = "";
    $pass = "";
    if(isset($_COOKIE['fpass']))
    {
        $pass = $_COOKIE['fpass'];
    }
    if(isset($_COOKIE['funame']))
    {
        $uname = $_COOKIE['funame'];
    }
?>

<main>
    <?php
        if(isset($_SESSION['RegisterationSuccess']))
        {
            echo '
            <script>
                swal("Congratulations..!", "'.$_SESSION['RegisterationSuccess'].'", "success");
            </script>
            ';
            unset($_SESSION['RegisterationSuccess']);
        }
        if(isset($_SESSION['loginfailure']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['loginfailure'].'", "error");
            </script>
            ';
            unset($_SESSION['loginfailure']);
        }
        if(isset($_SESSION['resetpasswordsuccess']))
        {
            echo '
            <script>
                swal("Congratulations..!", "'.$_SESSION['resetpasswordsuccess'].'", "success");
            </script>
            ';
            unset($_SESSION['resetpasswordsuccess']);
        }
    ?>


        <div class="jumbotron my-form login-form mb-0">
            <div class="form-illustration " data-aos="fade-right">
                <img src="./assets/img/illustrations/login.png" width="500" alt="">
            </div>
            <div class="form-container" data-aos="fade-left">
                <div>
                    <h1 class="mb-5 ms-2" style="font-family:'Chicle', cursive;">Sign In</h1>
                    <div class="container mb-5">
                    <form action="<?php echo $BASE_URL; ?>code" class="mt-5" method="POST">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group mb-3">
                            <input type="username" class="form-control" id="username" name="username" value="<?php echo $uname; ?>" aria-describedby="emailHelp" required>
                            <a class="btn btn-outline-secondary text-dark" role="button" onclick="showfocus()"><i class="fa fa-user" id="user" aria-hidden="true"></i></a>
                        </div>
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $pass; ?>" required>
                            <a class="btn btn-outline-secondary text-dark" role="button" onclick="showpass()"><i class="fa fa-eye" id="eye" aria-hidden="true"></i></a>
                            </button>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberme" name = "rememberme">
                            <label class="form-check-label" for="rememberme">Remember me</label>
                        </div>
                        <div>
                            <small><a href="<?php echo $BASE_URL; ?>forgetpassword" class="text-dark">forget password?</a></small>    
                        </div>
                        <button type="submit" name="login" class="btn btn-primary mt-3">signin <i class="fa fa-sign-in ms-1" aria-hidden="true"></i></button>
                    </form>
                    </div>
                </div>
            </div>
        </div>

</main>
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
        function showfocus()
        {
            var x = document.getElementById('username');
            x.focus();
        }
    </script>
<?php
    include('footer.php');
?>