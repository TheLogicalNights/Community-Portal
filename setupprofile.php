<?php
    session_start();
    include "./config/config.php";
    include('header.php');
    
    if(!isset($_SESSION['status']))
    {
        header("Location: /Febina/Members-Portal/signin");
    }
    if(!isset($_SESSION['setupprofile']))
    {
        header("Location: /Febina/Members-Portal/feed");
    }
?>

<main>
    <?php
        if(isset($_SESSION['notimage']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['notimage'].'", "error");
            </script>
            ';
            unset($_SESSION['notimage']);
        }
        if(isset($_SESSION['imgformatfailure']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['imgformatfailure'].'", "error");
            </script>
            ';
            unset($_SESSION['imgformatfailure']);
        }
        if(isset($_SESSION['profilepictureuploaded']))
        {
            echo '
            <script>
                swal("Yeahh..!", "'.$_SESSION['profilepictureuploaded'].'", "success");
            </script>
            ';
        }
        if(isset($_SESSION['profilepictureuploadfailure']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['profilepictureuploadfailure'].'", "error");
            </script>
            ';
            unset($_SESSION['profilepictureuploadfailure']);
        }
        if(isset($_SESSION['setupprofilefailure']))
        {
            echo '
            <script>
                swal("Oops..!", "'.$_SESSION['setupprofilefailure'].'", "error");
            </script>
            ';
            unset($_SESSION['setupprofilefailure']);
        }
    ?>
        <div class="setup-section">
            <div class="container setup-container">
                <div class="hero-text col-lg-10 col-md-10 col-sm-10" data-aos="zoom-in">
                    <h2 class="mb-5 ms-2">Setup Profile</h2>
                    <div class="container mb-5">
                    <?php
                        if(isset($_SESSION['profilepictureuploaded']))
                        {
                            echo '<img src="'.$_SESSION['profilepath'].'" class="rounded-circle" height="100" width="100" alt="Profile picture">';
                            unset($_SESSION['profilepictureuploaded']);
                            unset($_SESSION['profilepath']);
                        }
                        else
                        {
                            echo '<img src="'.$BASE_URL.'/img/user.png" class="rounded-circle" height="100" width="100" alt="Profile picture">';
                        }
                    ?>
                    
                    <form action="<?php echo $BASE_URL; ?>code" method="POST" enctype="multipart/form-data">
                        <label for="profileimg" class="col-form-label">Select profile picture:</label>
                            <input class="form-control" type="file" id="profileimg" name="profileimg">
                        <div class="mt-3">
                        <label for="birthdate" class="col-form-label">Birthdate:</label>
                            <input class="form-control" type="date" id="birthdate" name="birthdate" required>
                        </div>
                        <div class="form-floating mt-3">
                            <textarea class="form-control" placeholder="" id="about" name="about" style="height: 100px" maxlength="200" onkeyup="limit(this);" required></textarea>
                            <label for="about">Something about you</label>
                            <small id="limit">200/200</small>
                        </div>
                        <div class="form-floating mt-3">
                            <textarea class="form-control" placeholder="Leave a comment here" id="insta" name="insta" required></textarea>
                            <label for="insta"><i class="fa fa-instagram" aria-hidden="true"></i> Drop link here</label>
                        </div>
                        <div class="form-floating mt-3">
                            <textarea class="form-control" placeholder="Leave a comment here" id="fb" name="fb" required></textarea>
                            <label for="fb"><i class="fa fa-facebook-official" aria-hidden="true"> </i> Drop link here</label>
                        </div>
                        <button class="btn btn-primary mt-4" type="Submit" name="setupprofile">Submit</button>
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