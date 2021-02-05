<?php
    session_start();
    include('./database/db.php');
    include('header.php');  
?>
<main>
<div class="container mt-3">
    <h2 class="mb-3">Add Post</h2>
    <form action="/Febina/Community/code" method="POST" enctype="multipart/form-data">
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" name="addpost" type="submit">Add new post</button>
        </div>
    </form>
</div>
<br>
</main>

<?php
    include('footer.php');
?>