<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include ('header.php');
    include ('./database/db.php');
    if(isset($_SESSION['posteditfailure']))
    {
        echo '
        <script>
            swal("Oops..!", "'.$_SESSION['posteditfailure'].'", "error");
        </script>
        ';
        unset($_SESSION['posteditfailure']);
    }
    if (isset($_POST['editposts']))
    {
        $query = "select * from posts where postid ='".$_POST['postid']."'";
        $result = mysqli_query($conn,$query);
        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
        
?>
<main>
<div class="container mt-5"  id="editPost">
        <h1 class="mt-2">Edit Post</h1>
        <form action="/Febina/Members-Portal/code" method="POST">
            <input type="hidden" name="postid" value="<?php echo $row['postid']; ?>">
            <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Post title:</label>
                <input type="text" class="form-control" id="posttitleEdit" name="posttitleEdit" value="<?php echo $row['posttitle']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="message-text" class="col-form-label">Post Description:</label>
                <textarea name="postbodyEdit" id="postbodyEdit"><?php echo $row['post']; ?>
                </textarea>
                <script>
                    CKEDITOR.replace( 'postbodyEdit' );
                </script>
            </div>
            <div class="mb-3">
                <label for="formFileSm" class="form-label">Select Picture (Optional)</label>
                <input class="form-control" type="file" id="formFile" name="editeduploadpic" >
            </div>
            <hr>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a type="button" href="/Febina/Members-Portal/profile" class="btn btn-secondary">Close</a>
                <button class="btn btn-primary" name="editpost" type="submit">Edit post</button>
            </div>
        </form>
</div>
<br>
</main>
<?php
        }
        else
        {
       //     header('Location: /Febina/Members-Portal/profile');    
        }
    }
    else
    {
       // header('Location: /Febina/Members-Portal/profile');
    }
    include ('footer.php');
?>