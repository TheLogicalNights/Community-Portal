<?php
    session_start();
    if (!isset($_SESSION['adminstatus']))
    {
        header('Location: adminlogin.php');
    }
    date_default_timezone_set("Asia/Kolkata");
    include ('./adminheader.php');
    include ('./database/db.php');
    $result = "";
    if(isset($_SESSION['adminpostdeleted']))
    {
        echo '
        <script>
            swal("Deleted..!", "'.$_SESSION['postdeleted'].'", "success");
        </script>
        ';
        unset($_SESSION['postdeleted']);
    }
    if(isset($_SESSION['adminpostnotdeleted']))
    {
        echo '
        <script>
            swal("Error..!", "'.$_SESSION['postnotdeleted'].'", "error");
        </script>
        ';
        unset($_SESSION['postnotdeleted']);
    }
    if(isset($_GET['username']))
    {
        $query = "select * from profile where username='".$_GET['username']."'";
        $result = mysqli_query($conn,$query);
        $query1 = "select * from favourit where uname='".$_GET['username']."' and username='".$_SESSION['username']."'";
        $result1 = mysqli_query($conn,$query1);
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
                    <div class="profile-img" data-aos="zoom-out-right">
                        <img src="<?php echo "/Febina/Members-Portal".ltrim($row['dppath'],"."); ?>" class="rounded-circle" width="250" height="250" alt="Profile picture">
                    </div>
                    <div class="profile-details" data-aos="zoom-out-left">
                        <h1 class="mt-4"><?php echo $row['name']; ?>
                        </h1>
                        <small><a href=""><?php echo $row['username']; ?></a></small>
                        <p>
                        <br>
                        <?php echo $row['about']; ?>
                        </p>
                        <a href="<?php echo $row['fblink']; ?>"> <span class="mdi mdi-facebook" style="color:black; font-size: 2em;"></span></a>
                        <a href="<?php echo $row['instalink']; ?>"> <span class="mdi mdi-instagram" style="color:black; font-size: 2em;"></span></a>
                        <!-- <a href="#"> <span class="mdi mdi-linkedin" style="color:black; font-size: 2em;"></span></a>
                        <a href="#"> <span class="mdi mdi-youtube" style="color:black; font-size: 2em; "></span></a> -->
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

            <div class="container feed-cards" >
                <?php
                    $result1 = 0;
                    if(isset($_GET['username']))
                    {
                        $query1 = "select * from posts where username='".$_GET['username']."'";
                        $result1 = mysqli_query($conn,$query1);
                    }
                    if ($result1)
                    {
                        while ($row = mysqli_fetch_assoc($result1))
                        {
                ?>
                            <div class="card post-card" data-aos="zoom-in">
                                <div class="dropdown d-flex justify-content-end" style="display:flex; justify-content:flex-end; margin-right:10px ;width:100%; padding:5px;">
                                    <a style ="font-size :10px;" class="btn btn-secondary mr-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <?php
                                        if ($_SESSION['adminstatus'])
                                        {
                                    ?>
                                            <li>
                                                <form action="/Febina/Members-Portal/code" method="post">
                                                    <input type="hidden" name="postid" value=<?php echo $row['postid']; ?>>
                                                    <input type="hidden" name="username" value=<?php echo $row['username']; ?>>
                                                    <button onclick="return confirm('Are you sure you want to delete this post ?');" class="dropdown-item" type="submit" name="deletepost">Delete</button>
                                                </form>
                                            </li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                </div>
                                <div class="card-inner-box">
                                    <div class="post-img">
                                        <img src=<?php echo $row['img_path']; ?> alt="Post Image">
                                    </div>
                                    <div class="">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                <?php 
                                                    $title = strip_tags($row['posttitle']);
                                            
                                                    if (strlen($title) > 20)
                                                    {
                                                        for ($i = 0; $i < 20; $i++)
                                                        {
                                                            echo $title[$i];
                                                        }
                                                        echo "...";
                                                    }
                                                    else
                                                    {
                                                        echo $title;
                                                    }

                                                ?>
                                            </h5>
                                            <div class="post-desc-container" id="postdesc">   
                                                <?php 
                                                    $post = strip_tags($row['post']); 
                                                    if (strlen($post) > 80)
                                                    {
                                                        for ($i = 0; $i < 80; $i++)
                                                        {
                                                            echo $post[$i];
                                                        }
                                                        echo "...";
                                                    }
                                                    else
                                                    {
                                                        echo $post;
                                                    }
                                                ?>
                                            </div>
                                            <div>
                                                <form class="post-meta" action="/Febina/Members-Portal/readmore" method="post">
                                                    <input type="hidden" name="postid" value=<?php echo $row['postid']; ?>>
                                                    <button type="submit" name="readmorefeed" href="readmore.php" class="btn btn-primary"> Read more</button>
                                                    <small>
                                                        <?php
                                                            date_default_timezone_set('Asia/Kolkata');
                                                            $datetime2 = strtotime($row['posted_at']);
                                                            $datetime1 = strtotime(date("y-m-d H:i:s"));
                                                            
                                                            $interval = abs($datetime1 - $datetime2);
                                                            $min = round($interval/60);
                                                            $time = "";
                                                            if ($min >= 60)
                                                            {
                                                                $hr = round($min/60);
                                                                $min = $min%60;
                                                                if ($hr>1 && $hr<24)
                                                                {
                                                                    $time .= " hrs ";
                                                                }
                                                                else if ($hr==1)
                                                                {
                                                                    $time .= " hr ";
                                                                }
                                                                else
                                                                {
                                                                    $day = round($hr/24);
                                                                    $hr = $hr%24;
                                                                    if ($day <= 1)
                                                                    {
                                                                        $time .= $day." day";
                                                                    }
                                                                    else
                                                                    {
                                                                        $time .= $day." days";
                                                                    }
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $time .= $min." mins ";
                                                            }
                                                            echo $time;
                                                        ?>
                                                    ago
                                                    </small>
                                                </form>
                                            </div>
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
        <div id="f">
                    
        </div>

    </main>
<?php
    include "./footer.php";
?>