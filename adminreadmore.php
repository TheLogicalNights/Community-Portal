<?php
    session_start();
    include "./config/config.php";
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
            $query = "select name from user where username='".$row['username']."'";
            $result1 = mysqli_query($conn,$query);
            if ($result1)
            {
                $row1 = mysqli_fetch_assoc($result1);
                echo "Author : ".$row1['name'];
                $monthArray = Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
                $date = explode(" ",$row['posted_at']);
                $time = date("g:i a", strtotime($date[1]));
                $d = date("d/m/Y",strtotime($date[0]));
                $months = explode("/",$d);
                $m = (int)$months[1]; 
?>
<main class="bg-light">
<div class="container mt-2 mb-3" style="border:solid 1px black;border-radius:10px;">
    <div class="container mt-3 ms-3">
        <button type="button" style="font-weight:520;font-size:14px;color:grey;background-color:antiquewhite;border:none;" data-bs-toggle="tooltip" data-bs-html="true" title="Author">
        · <?php echo $row1['name']; ?>
        </button>

        <p class="mt-1" style="font-size: 27px;"><?php echo $row['posttitle']; ?><p>
        <a class="link-info" style="text-decoration:none;" href=<?php echo $BASE_URL."profile/".$row['username']; ?>>- <?php echo $row['username']; ?></a>
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
    <div class="container ms-3 mt-1">
        <small style="color:gray;font-weight:650;">
                POSTED AT : <?php echo $months[0]." ".$monthArray[$m-1]." ".$months[2]; ?>  ·  <?php echo $time; ?>
        </small>
    </div>

    <div class="d-flex justify-content-center mt-2">
        <p class="lead">
                <a class="btn btn-primary" href="<?php echo $BASE_URL; ?>admin" role="button">Back</a>
        </p>
    </div>
</div>
</main>
<?php
        }
        else
        {
            header('Location: ./admin');
        }
    }
    else
    {
        header('Location: ./admin');
    }
}
?>

<?php
    include('footer.php');
?>
