<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include "./config/config.php";
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
    <form action="<?php echo $BASE_URL; ?>code" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="redirectto" value="<?php echo $_POST['redirectto']; ?>">
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
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="removeimage" id="removeimage">
                <label class="form-check-label" for="removeimage">Remove image</label>
            </div>
          
            <hr>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a type="button" href="<?php echo $BASE_URL; ?>profile" class="btn btn-secondary">Close</a>
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
            header('Location: ./'.$_POST['redirectto']);    
        }
    }
    else
    {
        header('Location: ./'.$_POST['redirectto']);
    }
    include ('footer.php');
?>