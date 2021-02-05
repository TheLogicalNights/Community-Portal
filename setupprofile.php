<?php
    include('header.php');
    session_start();
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
        <div class="slick-go">
            <div class="banner"
            style="background-image : url(./assets/img/banner.jpg);">
                <div class="hero-text col-lg-5" data-aos="fade-right">
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
                            echo '<img src="./img/user.png" class="rounded-circle" height="100" width="100" alt="Profile picture">';
                        }
                    ?>
                    <form action="/Febina/Members-Portal/code"  method="POST" enctype="multipart/form-data">
                        <div class="mt-3">
                            <label for="profileimg" class="col-form-label">Select profile picture:</label>
                            <input class="form-control" type="file" id="profileimg" name="profileimg" required>
                            <button type="submit" name="uploadprofilepicture" class="btn btn-primary mt-3">Upload</button>
                        </div>
                    </form>
                    <form action="/Febina/Members-Portal/code" method="POST">
                        <div class="mt-3">
                        <label for="birthdate" class="col-form-label">Birthdate:</label>
                            <input class="form-control" type="date" id="birthdate" name="birthdate" max="2021-01-01" required>
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
                        <div class="d-grid gap-2 mt-4">
                          <button class="btn btn-primary" type="Submit" name="setupprofile">Submit</button>
                        </div>
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