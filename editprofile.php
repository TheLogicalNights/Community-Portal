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
        $dppath = $row['dppath'];
        $about = $row['about'];
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
        <form action="/Febina/Community/code"  method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFileSm" class="form-label">Select Profile Picture</label>
                    <input type="hidden" name="uploadimg" value="1">
                    <input class="form-control" type="file" id="formFile" name="uploadfile" required>
                    <button type="submit" class="btn btn-primary btn-sm mt-2 removeprofile">Update Profile Picture</button>
            </div>
        </form>
    </div>
    </div>
</main>

<?php
    include('footer.php');
?>