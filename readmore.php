<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('./database/db.php');
    include('header.php');
    if (isset($_POST['readmorefeed']))
    {
        $query = "select * from posts where postid='".$_POST['postid']."'";
        $result = mysqli_query($conn,$query);
        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
?>
<main>
<div class="jumbotron mt-3 p-4">
    <img src="<?php echo $row['img_path']; ?>" alt="" srcset="">
    <h1 class="display-4"><?php echo $row['posttitle']; ?></h1>
    <small class="">- <?php echo $row['username']; ?></small>
    <hr class="my-2">
    <p><?php echo $row['post']; ?></p>
    <hr class="my-4">
    <p class="lead">
        <a class="btn btn-primary" href="/Febina/Members-Portal/feed" role="button">Back</a>
    </p>
</div>
</main>
<?php
        }
    }
    else
    {
        header('Location: /Febina/Members-Portal/feed.php');
    }
?>

<?php
    include('footer.php');
?>
