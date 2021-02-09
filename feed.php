<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('./database/db.php');
    $query = "select * from posts";
    $res = mysqli_query($conn,$query);
    include('header.php');
    if(isset($_SESSION['postedsuccessfully']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['postedsuccessfully'].'", "success");
        </script>
        ';
        unset($_SESSION['postedsuccessfully']);
    }

    if(isset($_SESSION['setupprofilsuccessfully']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['setupprofilsuccessfully'].'", "success");
        </script>
        ';
        unset($_SESSION['setupprofilsuccessfully']);
    }
    if(isset($_SESSION['postededitsuccessfully']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['postededitsuccessfully'].'", "success");
        </script>
        ';
        unset($_SESSION['postededitsuccessfully']);
    }
    if(isset($_SESSION['reportsuccess']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['reportsuccess'].'", "success");
        </script>
        ';
        unset($_SESSION['reportsuccess']);
    }
    if(isset($_SESSION['reportfailure']))
    {
        echo '
        <script>
            swal("Error..!", "'.$_SESSION['reportfailure'].'", "error");
        </script>
        ';
        unset($_SESSION['reportfailure']);
    }
?>

    <main>

        <div class="jumbotron feed-top-section">
        </div>

        <div class="jumbotron feed-body-section">
            <center>
                <h1 style="padding: 30px 0;">Latest Posts</h1>
            </center>
            <div class="container feed-cards">
            <?php

                if ($res)
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $post = '
                        <div class="card mb-3 post-card">
                            <div class="dropdown d-flex justify-content-end" style="display:flex; justify-content:flex-end; margin-right:10px ;width:100%; padding:5px;">
                                <a style ="font-size :10px;" class="btn btn-secondary mr-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                ';
                                if ($row['username'] == $_SESSION['username'])
                                {
                                    $post .= '
                                    <li>
                                        <form action="/Febina/Members-Portal/editpost" method="post">
                                        <input type="hidden" name="postid" value="'.$row['postid'].'">
                                        <button class="dropdown-item" type="submit" name="editposts">Edit</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/Febina/Members-Portal/code" method="post">
                                        <input type="hidden" name="postid" value="'.$row['postid'].'">
                                        <button onclick="return confirm("Are you sure you want to delete this post ?");" class="dropdown-item" type="submit" name="deletepost">Delete</button>
                                        </form>
                                    </li>';
                                }
                                else
                                {
                                   $post .= '<li>
                                                    <form action="/Febina/Members-Portal/code" method="POST">
                                                        <input type="hidden" name="reportedpostid" value="'.$_SESSION['username'].'">
                                                        <input type="hidden" name="reportedpostid" value="'.$row['postid'].'">
                                                        <button class="dropdown-item" type="submit">Report</button>
                                                    </form>
                                            </li>';
                                }
                            $post .= '</ul>
                            </div>
                            <div class="row g-0">
                                <div class="post-img col-md-4">
                                    <img src="'.$row['img_path'].'" alt="Post Image">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">'.$row['posttitle'].'</h5>
                                        <p class="card-text">';
                            $p = "";
                            if (strlen($row['post'])>= 80)
                            {
                                for ($i = 0; $i < 80; $i++)
                                {
                                    $p .= $row['post'][$i];
                                }
                                $p .= ".....";
                            }
                            else
                            {
                                for ($i = 0; $i < strlen($row['post']); $i++)
                                {
                                    $p .= $row['post'][$i];
                                }
                                for ($i = 80 - strlen($row['post']); $i > 0; $i--)
                                {
                                    $p .= "";
                                }
                            }
                            $post .= $p.'
                            <form action="/Febina/Members-Portal/readmore" method="post">
                                <input type="hidden" name="postid" value='.$row['postid'].'>
                                <button type="submit" name="readmorefeed" href="readmore.php" class="btn btn-primary"> Read more</button>
                            </form>
                            </p>
                            <p class="card-text"><small class="text-muted">Last updated '; 
                            date_default_timezone_set('Asia/Kolkata');
                            $datetime2 = strtotime($row['posted_at']);
                            $datetime1 = strtotime(date("y-m-d H:i:s"));
                            
                            $interval = abs($datetime1 - $datetime2);
                            $min = round($interval/60);
                            if ($min >= 60)
                            {
                                $hr = round($min/60);
                                $min = $min%60;
                                $p .= $hr;
                                if ($hr>1)
                                {
                                    $post .= " hrs ".$min;
                                }
                                else if ($hr==1)
                                {
                                    $post .= " hr ".$min;
                                }
                            }
                            else
                            {
                                $post .= $min;
                            }
                                $post .= ' mins ago</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>       
                        ';
                        echo $post;
                    }
                }
            ?>
        </div>
    </main>
<?php
    include('footer.php');
?>