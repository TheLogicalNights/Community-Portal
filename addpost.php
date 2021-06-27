<?php
    session_start();
    include "./config/config.php";
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include "./database/db.php";
    include('header.php'); 
    if(isset($_SESSION['postfailure']))
    {
        echo '
        <script>
            swal("Oops..!", "'.$_SESSION['postfailure'].'", "error");
        </script>
        ';
        unset($_SESSION['postfailure']);
    }
?>
<main>
<div class="container mt-3">
    <h1 class="mb-3" style="font-family: 'Concert One', cursive;">Add Post</h1>
    <form action="<?php echo $BASE_URL; ?>code" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="posttitle" class="col-form-label" style="font-family: 'Patrick Hand', cursive;">Post title:</label>
            <input type="text" class="form-control" id="posttitle" name="posttitle" style="" required>
        </div>
        <div class="mb-3">
            <label for="postbody" class="col-form-label" style="font-family: 'Patrick Hand', cursive;">Post:</label>
            <textarea type="text" name="postbody" class="form-control" id="postbody" required></textarea>
        </div>
        <div class="mb-3">
            <label for="postimg" class="col-form-label" style="font-family: 'Patrick Hand', cursive;">Choose a picture</label>
            <input type="file" class="form-control" id="postimg" name="postimg">
        </div>
        <hr>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a type="button" class="btn btn-secondary" href="<?php echo $BASE_URL; ?>feed.php" data-bs-dismiss="modal" style="font-family: 'Patrick Hand', cursive;">Close</a>
            <button class="btn btn-primary" name="addpost" type="submit" style="font-family: 'Patrick Hand', cursive;">Add new post</button>
        </div>
    </form>
</div>
<br>
</main>

<?php
    include('footer.php');
?>