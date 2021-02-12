<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('./database/db.php');
    $query = "select * from posts order by posted_at desc";
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
?>

    <main>
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
                ?>
                            <div class="card post-card" data-aos="zoom-in">
                                <div class="dropdown d-flex justify-content-end" style="display:flex; justify-content:flex-end; margin-right:10px ;width:100%; padding:5px;">
                                    <p> <a href="#"><?php echo $row['name']; ?></a></p>
                                    <a style ="font-size :10px;" class="btn btn-secondary mr-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <?php
                                        if ($_SESSION['username'] == $row['username'])
                                        {
                                    ?>
                                            <li>
                                                <form action="/Febina/Members-Portal/editpost" method="post">
                                                    <input type="hidden" name="postid" value=<?php echo $row['postid']; ?>>
                                                    <input type="hidden" name="redirectto" value="feed">
                                                    <button class="dropdown-item" type="submit" name="editposts">Edit</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="/Febina/Members-Portal/code" method="post">
                                                    <input type="hidden" name="postid" value=<?php echo $row['postid']; ?>>
                                                    <input type="hidden" name="redirectto" value="feed">
                                                    <button onclick="return confirm('Are you sure you want to delete this post ?');" class="dropdown-item" type="submit" name="deletepost">Delete</button>
                                                </form>
                                            </li>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            <li>
                                                <form action="/Febina/Members-Portal/code" method="POST">
                                                    <input type="hidden" name="reportedpostid" value=<?php echo $_SESSION['username']; ?>>
                                                    <input type="hidden" name="reportedpostid" value=<?php echo $row['postid']; ?>>
                                                    <button class="dropdown-item" type="submit">Report</button>
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
                                                                    $time .= $hr." hrs ";
                                                                }
                                                                else if ($hr==1)
                                                                {
                                                                    $time .= $hr." hr ";
                                                                }
                                                                else
                                                                {
                                                                    $day = round($hr/24);
                                                                    if ($day == 1)
                                                                    {
                                                                        $time .= $day." day ";
                                                                    }
                                                                    if ($day > 1)
                                                                    {
                                                                        if ($day >= 30)
                                                                        {
                                                                            $month = (int)($day/30);
                                                                            if ($month == 1)
                                                                            {
                                                                                $time .= $month." month ";
                                                                            }
                                                                            else if ($month > 1)
                                                                            {
                                                                                if ($month > 12)
                                                                                {
                                                                                    $year = (int)($month/12);
                                                                                    if ($year == 1)
                                                                                    {
                                                                                        $time .= $year." year ";
                                                                                    }
                                                                                    else if ($year > 1)
                                                                                    {
                                                                                        $time .= $year." years ";
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    $time .= $month." months ";
                                                                                }
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time .= $day." days ";
                                                                        }

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
    </main>
    <script>
        input = document.getElementById('postdesc').value;
        console.log(input);
        var result =new Sanitizer().sanitizeToString(input);
        document.getElementById('postdesc').innerHTML = result;
    </script>
<?php
    include('footer.php');
?>