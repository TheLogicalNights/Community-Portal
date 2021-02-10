<?php
    session_start();
    include('header.php');

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
                swal("Oops..!", "'.$_SESSION['loginfailure'].'", "error"");
            </script>
            ';
            unset($_SESSION['loginfailure']);
        }
    ?>


        <div class="jumbotron my-form login-form mb-0">
            <div class="form-illustration " data-aos="fade-right">
                <img src="/Febina/Members-Portal/assets/img/illustrations/login.png" width="500" alt="">
            </div>
            <div class="form-container" data-aos="fade-left">
                <div>
                    <h2 class="mb-5 ms-2">Sign In</h2>
                    <div class="container mb-5">
                    <form action="/Febina/Members-Portal/code" class="mt-5" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="username" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>
                        </div>
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <a class="btn btn-outline-secondary text-dark" role="button" onclick="showpass()"><i class="fa fa-eye" id="eye" aria-hidden="true"></i></a>
                            </button>
                        </div>
                        <div>
                            <small><a href="/Febina/Members-Portal/forgetpassword" class="text-dark">forget password?</a></small>    
                        </div>
                        <button type="submit" name="login" class="btn btn-primary mt-3">Submit</button>
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
    </script>
<?php
    include('footer.php');
?>