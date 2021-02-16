<?php
    session_start();
    if (isset($_SESSION['adminstatus']))
    {
        header('Location: admin.php');
    }
    include('adminheader.php');
    if(isset($_SESSION['adminloginfailure']))
    {
        echo '
        <script>
            swal("Oops..!", "'.$_SESSION['adminloginfailure'].'", "error"");
        </script>
        ';
        unset($_SESSION['adminloginfailure']);
    }
?>
<main class="bg-light">
    <div class="jumbotron my-form login-form mb-0" data-aos="fade-right">
        <div class="form-illustration " data-aos="fade-right">
                <img src="/Febina/Members-Portal/assets/img/illustrations/admin.png" width="500" alt="">
        </div>
        <div class="form-container" data-aos="fade-left">
                <div>
                    <h2 class="mb-5 ms-2">Sign In</h2>
                    <div class="container mb-5">
                    <form action="/Febina/Members-Portal/code" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="username" class="form-control" id="username" name="username" required>
                        </div>
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <a class="btn btn-outline-secondary" role="button" onclick="showpass()"><i class="fa fa-eye" id="eye" aria-hidden="true"></i></a>
                            </button>
                        </div>
                        <button type="submit" name="adminlogin" class="btn btn-primary mt-3">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
</main>
<?php
    include('footer.php');
?>
