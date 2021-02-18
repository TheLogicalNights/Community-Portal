<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('./database/db.php');
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
    <h2 class="mb-3">Add Post</h2>
    <form action="/Febina/Members-Portal/code" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="posttitle" class="col-form-label">Post title:</label>
            <input type="text" class="form-control" id="posttitle" name="posttitle" required>
        </div>
        <div class="mb-3">
            <label for="postbody" class="col-form-label">Post:</label>
            <textarea type="text" name="postbody" class="form-control" id="postbody" required></textarea>
        </div>
        <div class="mb-3">
            <label for="postimg" class="col-form-label">Choose a picture</label>
            <input type="file" class="form-control" id="postimg" name="postimg">
        </div>
        <hr>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a type="button" class="btn btn-secondary" href="./feed.php" data-bs-dismiss="modal">Close</a>
            <button class="btn btn-primary" name="addpost" type="submit">Add new post</button>
        </div>
    </form>
</div>
<br>
</main>

<?php
    include('footer.php');
?>