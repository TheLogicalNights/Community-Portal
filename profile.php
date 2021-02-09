<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    date_default_timezone_set("Asia/Kolkata");
    include ('./header.php');
    include ('./database/db.php');
    if(isset($_SESSION['postededitsuccessfully']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['postededitsuccessfully'].'", "success");
        </script>
        ';
        unset($_SESSION['postededitsuccessfully']);
    }
    if(isset($_SESSION['postdeleted']))
    {
        echo '
        <script>
            swal("Deleted..!", "'.$_SESSION['postdeleted'].'", "success");
        </script>
        ';
        unset($_SESSION['postdeleted']);
    }
    if(isset($_SESSION['postnotdeleted']))
    {
        echo '
        <script>
            swal("Error..!", "'.$_SESSION['postnotdeleted'].'", "error");
        </script>
        ';
        unset($_SESSION['postnotdeleted']);
    }
    $result = "";
    if(!isset($_GET['username']))
    {
        if(isset($_SESSION['username']))
        {
            $query = "select * from profile where username='".$_SESSION['username']."'";
            $result = mysqli_query($conn,$query);
        }
    }
    if(isset($_GET['username']))
    {
        $query = "select * from profile where username='".$_GET['username']."'";
        $result = mysqli_query($conn,$query);
    }
?>
    <main>
        <?php
        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
        ?>
        <div class="jumbotron profile-jumbotron">
            <div class="container">
                <div class="profile-section">
                    <div class="profile-img">
                        <img src="<?php echo "/Febina/Members-Portal".ltrim($row['dppath'],"."); ?>" class="rounded-circle" width="250" height="250" alt="Profile picture">
                    </div>
                    <div class="profile-details">
                        <h1 class="mt-4"><?php echo $row['name']; ?><a href="/Febina/Members-Portal/editprofile"><i class="fa fa-pencil-square-o fa-xs ms-3" aria-hidden="true"></i></a></h1>
                        <small><a href=""><?php echo $row['username']; ?></a></small>
                        <p>
                        <br>
                        <?php echo $row['about']; ?>
                        </p>
                        <a href="<?php echo $row['fblink']; ?>"> <span class="mdi mdi-facebook" style="color:black; font-size: 2em;"></span></a>
                        <a href="<?php echo $row['instalink']; ?>"> <span class="mdi mdi-instagram" style="color:black; font-size: 2em;"></span></a>
                        <a href="#"> <span class="mdi mdi-linkedin" style="color:black; font-size: 2em;"></span></a>
                        <a href="#"> <span class="mdi mdi-youtube" style="color:black; font-size: 2em; "></span></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="jumbotron feed-body-section">
            <center>
                <h1 style="padding: 30px 0;">Latest Posts </h1>
            </center>

            <div class="container feed-cards" data-aos="fade-left">
                <?php
                    $result1 = 0;
                    if(!isset($_GET['username']))
                    {
                        if(isset($_SESSION['username']))
                        {
                            $query1 = "select * from posts where username='".$_SESSION['username']."'";
                            $result1 = mysqli_query($conn,$query1);
                        }
                    }
                    if(isset($_GET['username']))
                    {
                        $query1 = "select * from posts where username='".$_GET['username']."'";
                        $result1 = mysqli_query($conn,$query1);
                    }
                    if ($result1)
                    {
                        while ($row1 = mysqli_fetch_assoc($result1))
                        {
                ?>
                <div class="card mb-3 post-card">
                    <div class="row g-0">
                    <div class="dropdown d-flex justify-content-end" style="display:flex; justify-content:flex-end; margin-right:10px ;width:100%; padding:5px;">
                                <a style ="font-size :10px;" class="btn btn-secondary mr-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <?php    if ($row1['username'] == $_SESSION['username'])
                                {
                            ?>
                                    <li>
                                        <form action="/Febina/Members-Portal/editpost" method="post">
                                        <input type="hidden" name="postid" value="<?php echo $row1['postid']; ?>">
                                        <button class="dropdown-item" type="submit" name="editposts">Edit</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/Febina/Members-Portal/code" method="post">
                                        <input type="hidden" name="postid" value="<?php echo $row1['postid']; ?>">
                                        <button onclick="return confirm('Are you sure you want to delete this post ?');" class="dropdown-item" type="submit" name="deletepost">Delete</button>
                                        </form>
                                    </li>
                             <?php 
                                }
                                else
                                {
                            ?>
                                  <li><button class="dropdown-item" type="button">Report</button></li>
                            <?php
                                }
                            ?>
                            </ul>
                            </div>
                        <div class="post-img col-md-4">
                            <img src="<?php echo "/Febina/Members-Portal".ltrim($row1['img_path'],"."); ?>" alt="Post Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row1['posttitle']; ?></h5>
                                <p class="card-text">
                                <?php 
                                    $post = "";
                                    if (strlen($row1['post'])>= 80)
                                    {
                                        for ($i = 0; $i < 80; $i++)
                                        {
                                            $post .= $row1['post'][$i];
                                        }
                                        $post .= ".....";
                                    }
                                    else
                                    {
                                        for ($i = 0; $i < strlen($row1['post']); $i++)
                                        {
                                            $post .= $row1['post'][$i];
                                        }
                                    }
                                    echo $post;
                                ?>
                                </p>
                                <form action="/Febina/Members-Portal/readmore" method="post">
                                    <input type="hidden" name="postid" value=<?php echo $row1['postid'] ?>>
                                    <button type="submit" name="readmorefeed" href="readmore.php" class="btn btn-primary"> Read more</button>
                                </form>
                                <p class="card-text mt-2"><small class="text-muted">Last updated 
                                <?php
                                $time = "";
                                date_default_timezone_set('Asia/Kolkata');
                                $datetime2 = strtotime($row1['posted_at']);
                                $datetime1 = strtotime(date("y-m-d H:i:s"));
                                $interval = abs($datetime1 - $datetime2);
                                $min = round($interval/60);
                                if ($min >= 60)
                                {
                                    $hr = round($min/60);
                                    $min = $min%60;
                                    $time .= $hr;
                                    if ($hr>1)
                                    {
                                        $time .= " hrs ".$min;
                                    }
                                    else if ($hr==1)
                                    {
                                        $time .= " hr ".$min;
                                    }
                                }
                                else
                                {
                                    $time .= $min;
                                }
                                echo $time;
                                ?>
                                 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>

        </div>


    </main>

<?php
    include "./footer.php";
?>