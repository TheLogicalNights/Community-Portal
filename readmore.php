<?php
    session_start();
    // if (!isset($_SESSION['status']))
    // {
    //     header('Location: signin.php');
    // }
    include "./config/config.php";
    include('./database/db.php');
    include('header.php');
    if (isset($_GET['postid']))
    {
        $query = "select * from posts where postid='".$_GET['postid']."'";
        $result = mysqli_query($conn,$query);
        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
            $query = "select name from user where username='".$row['username']."'";
            $result1 = mysqli_query($conn,$query);
            if ($result1)
            {
                $row1 = mysqli_fetch_assoc($result1);
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
        <button type="button" style="font-weight:bold;font-size:14px;color:grey;background-color:antiquewhite;border:none;" data-bs-toggle="tooltip" data-bs-html="true" title="Author">
        · <?php echo $row1['name']; ?>
        </button>

        <p class="mt-1 p-3" style="font-size: 27px;"><strong><?php echo $row['posttitle']; ?></strong><br><a class="link-info" style="text-decoration:none;font-size: 14px;" href=<?php echo $BASE_URL."profile/".$row['username']; ?>>- <?php echo $row['username']; ?></a><p>
        
    </div>
    <div class="d-flex justify-content-center bg-light">
            <img class="img-fluid img-responsive"
            style="max-width:100%;min-width:300px;height=auto;max-height:300px;"
             src="<?php echo $row['img_path']; ?>" width="45" height="20" alt="" srcset="">
    </div>
    <div class="mt-1 bg-light" style="font-size: 14px;">
        <hr class="my-2">
        <div class="container ms-3 md-4">
        <p><?php echo $row['post']; ?></p>
        </div>
        <hr class="my-2">
    </div>
    <div class="container ms-3 mt-1">
        <i class="fa fa-calendar" aria-hidden="true" style="font-size:20px;color:rgb(0,255,255);"> </i>
        <small style="color:gray;font-weight:650;">
             <?php echo $months[0]." ".$monthArray[$m-1]." ".$months[2]; ?>  ·
                
              <?php echo $time; ?>
        </small>
    </div>
    <div class="container ms-3 mt-1">
        <small style="color:gray;font-weight:650;">
                <h6 class="mt-2"><a style="color:rgb(253, 89, 30);font-weight:650;text-decoration:none;" data-bs-toggle="collapse" href="#collapseExample" rel="noopener noreferrer">
                    <i class="fa fa-thumbs-up ms-2" aria-hidden="true"></i>
                     Liked by <span class="badge bg-dark text-white rounded-circle ms-1">
                    <?php
                        $query1 = "select * from postlikes where postid='".$_GET['postid']."'";
                        $result1 = mysqli_query($conn,$query1);
                        if (mysqli_num_rows($result1) >=0 )
                        {
                            echo mysqli_num_rows($result1);
                        }
                        
                    ?>
                    </span></a></h6>
                <div class="collapse" id="collapseExample">
                    <?php
                    $cnt = 0;
                    $query1 = "select * from user where sr_no in (select likedby from postlikes where postid ='".$_GET['postid']."')";
                    $result1 = mysqli_query($conn,$query1);
                     if ($result1)
                     {
                         
                        while($row = $result1->fetch_assoc())
                        {
                                    if ($cnt == 0)
                                    {
                ?>
                                        <a class="link-info" style="text-decoration:none;" href=<?php echo $BASE_URL."profile/".$row['username']; ?>><?php echo $row['username']; ?></a>
                <?php   
                                    }
                                    else
                                    {
                                        if($cnt<=3)
                                        {
                                            echo " , ";
                ?>
                                        <a class="link-info" style="text-decoration:none;" href=<?php echo $BASE_URL."profile/".$row['username']; ?>><?php echo $row['username']; ?></a>
                <?php
                                        }
                                    }
                                    $cnt++;
                        }
                    }
                 ?>      
                </div>
        </small>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <p class="lead">
                <a class="btn btn-primary btn-lg" href="<?php echo $BASE_URL; ?>feed" role="button">Back</a>
        </p>
    </div>
</div>
</main>
<?php
            }
        }
        else
        {
            header('Location: ./feed');
        }
    }
    else
    {
        header('Location: ./feed');
    }
?>

<?php
    include('footer.php');
?>
