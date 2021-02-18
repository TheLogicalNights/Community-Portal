<?php
    session_start();
    if (!isset($_SESSION['adminstatus']))
    {
        header('Location: adminlogin.php');
    }
    include('./database/db.php');
    include('adminheader.php');
    if (isset($_POST['readmorefeed']))
    {
        $query = "select * from posts where postid='".$_POST['postid']."'";
        $result = mysqli_query($conn,$query);
        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
?>
<main class="bg-light">
<div class="container mt-3 ms-3">
    <p style="font-size: 45px;"><?php echo $row['posttitle']; ?><p>
    <a class="link-info" href=<?php echo "/Febina/Members-Portal/profile/".$row['username']; ?>>- <?php echo $row['username']; ?></a>
</div>
<div class="d-flex justify-content-center mt-2 bg-light">
        <img class="img-fluid" src="<?php echo $row['img_path']; ?>" width="45%" height="20%"    alt="" srcset="">
</div>
<div class="mt-1 bg-light">
    <hr class="my-2">
    <div class="container ms-3 md-4">
    <p><?php echo $row['post']; ?></p>
    </div>
    <hr class="my-2">
</div>
<br>
<div class="container ms-3" style="font-size:15px;">
    <p>
            <?php 
                    $query = "select name from user where username='".$row['username']."'";
                    $result = mysqli_query($conn,$query);
                    if ($result)
                    {
                        $row1 = mysqli_fetch_assoc($result);
                        echo "Author : ".$row1['name'];
                    }
                    $date = explode(" ",$row['posted_at']);
                    $time = date("g:i a", strtotime($date[1]));
                    echo "<br>Posted at : ".date("d-m-Y",strtotime($date[0]))." ".$time;

             ?>
    </p>
</div>

<div class="d-flex justify-content-center">
    <p class="lead">
            <a class="btn btn-primary" href="/Febina/Members-Portal/admin" role="button">Back</a>
    </p>
</div>
</main>
<?php
        }
        else
        {
            header('Location: /Febina/Members-Portal/admin');
        }
    }
    else
    {
        header('Location: /Febina/Members-Portal/admin');
    }
?>

<?php
    include('footer.php');
?>
