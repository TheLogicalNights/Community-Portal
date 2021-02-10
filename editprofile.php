<?php
    session_start();
    include('header.php');
    include('./database/db.php');
    $dppath = "";
    $username = $_SESSION['username'];
    $query = "select * from profile where username = '$username'";
    $result = mysqli_query($conn,$query);
    while($row = $result->fetch_assoc())
    {
        $name = $row['name'];
        $dppath = $row['dppath'];
        $about = $row['about'];
        $instalink = $row['instalink'];
        $fblink = $row['fblink'];
        $birthdate = $row['birthdate'];
    }
    $dppath = "/Febina/Members-Portal".ltrim($dppath,".");
    if(isset($_SESSION['profileupdated']))
    {
        echo '
        <script>
            swal("Yeah..!", "'.$_SESSION['profileupdated'].'", "success");
        </script>
        ';
        unset($_SESSION['profileupdated']);
    }
    if(isset($_SESSION['changepasswordfailure']))
    {
        echo '
        <script>
            swal("Oops..!", "'.$_SESSION['changepasswordfailure'].'", "error");
        </script>
        ';
        unset($_SESSION['changepasswordfailure']);
    }
    if(isset($_SESSION['changepasswordsuccess']))
    {
        echo '
        <script>
            swal("Yeah..!", "'.$_SESSION['changepasswordsuccess'].'", "success");
        </script>
        ';
        unset($_SESSION['changepasswordsuccess']);
    }
?>
<main>
    <div class="jumbotron usp-section">
        <h2 class="text-center mt-4 border-bottom-left-radius">Update Profile Picture</h2>
        <div class="d-flex justify-content-center">
            <img src="<?php echo $dppath; ?>" height="150" width="150" class="rounded-circle mt-5" alt="Profile Picture">
        </div>
        <div class="d-flex justify-content-center mt-4 mb-5">
            <form action="/Febina/Members-Portal/code" method="POST">
                <input type="hidden" name="remove" value="<?php echo $_SESSION['username']; ?>">
                <button type="submit" class="btn btn-primary btn-sm ms-3">Remove Profile Picture</button>
            </form>    
        </div>
        <div class="d-flex justify-content-center mb-5">
            <form action="/Febina/Members-Portal/code"  method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFileSm" class="form-label">Select Profile Picture</label>
                    <input type="hidden" name="uploadimg" value="<?php echo $_SESSION['username']; ?>">
                        <input class="form-control" type="file" id="formFile" name="uploadfile" required>
                        <button type="submit" class="btn btn-primary btn-sm mt-2 removeprofile">Update Profile Picture</button>
                </div>
            </form>
        </div>
        <hr>
        <h2 class="text-center mt-4 border-bottom-left-radius">Change Password</h2>
        <div class="container">
            <form class="mt-5" action="/Febina/Members-Portal/code" method="POST">
                <input type="hidden" name="username" value="<?php echo $username; ?>">
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
        </div>
        <hr>
        <h2 class="text-center mt-4 border-bottom-left-radius">Update Name</h2>
        <form action="/Febina/Members-Portal/code" id="updatename" method="POST">
            <div class="container mb-5">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required> 
                    <input type="hidden" name="updatename" value="<?php echo $_SESSION['username']; ?>">
                    <button type="submit" class="btn btn-primary btn-sm mt-3">Update Name</button>
                </div>
            </div>
        </form>
        <h2 class="text-center mt-4 border-bottom-left-radius">Update About</h2>
        <form action="/Febina/Members-Portal/code" method="POST">
            <div class="container mb-5">
                <div class="form-floating">
                    <input type="hidden" name="updateabout" value="<?php echo $_SESSION['username']; ?>">
                    <textarea class="form-control" name="about" id="floatingTextarea2" style="height: 100px" maxlength="200" onkeyup="limit(this);" required><?php echo $about; ?></textarea>
                    <label for="floatingTextarea2">About</label>
                    <small id="limit">200/200</small><br>
                    <button type="submit" class="btn btn-primary btn-sm mt-3">Update About</button>
                </div>
            </div>
        </form>
        <hr>
        <h2 class="text-center mt-4 border-bottom-left-radius">Update Birthdate</h2>
        <form action="/Febina/Members-Portal/code" method="POST">
            <div class="container mb-5">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo $birthdate; ?>" required> 
                    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                    <button type="submit" name="updatebirthdate" class="btn btn-primary btn-sm mt-3">Update Birthdate</button>
            </div>
        </form>
        <h2 class="text-center mt-4 border-bottom-left-radius">Update Instagram Link</h2>
        <form action="/Febina/Members-Portal/code" method="POST">
            <div class="container mb-5">
                    <label for="instalink" class="form-label">Instagram Link</label>
                    <input type="text" class="form-control" id="instalink" name="instalink" value="<?php echo $instalink; ?>" required> 
                    <input type="hidden" name="updateinstalink" value="<?php echo $_SESSION['username']; ?>">
                    <button type="submit" class="btn btn-primary btn-sm mt-3">Update Instagram Link</button>
            </div>
        </form>
        <h2 class="text-center mt-4 border-bottom-left-radius">Update Facebook Link</h2>
        <form action="/Febina/Members-Portal/code" method="POST">
            <div class="container mb-5">
                    <label for="instalink" class="form-label">Facebook Link</label>
                    <input type="text" class="form-control" id="fblink" name="fblink" value="<?php echo $fblink; ?>" required> 
                    <input type="hidden" name="updatefblink" value="<?php echo $_SESSION['username']; ?>">
                    <button type="submit" class="btn btn-primary btn-sm mt-3">Update Facebook Link</button>
            </div>
        </form>
    </div>
</main>

<?php
    include('footer.php');
?>