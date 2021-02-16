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
    $cnt = 0;
    if(!isset($_GET['username']))
    {
        if(isset($_SESSION['username']))
        {
            $query = "select * from profile where username='".$_SESSION['username']."'";
            $result = mysqli_query($conn,$query);
            $query = "select * from favourit where username='".$_SESSION['username']."'";
            $result1 = mysqli_query($conn,$query);
            $cnt = mysqli_num_rows($result1);
        }
    }
    if(isset($_GET['username']))
    {
        $query = "select * from profile where username='".$_GET['username']."'";
        $result = mysqli_query($conn,$query);
        $query1 = "select * from favourit where uname='".$_GET['username']."' and username='".$_SESSION['username']."'";
        $result1 = mysqli_query($conn,$query1);
        $query = "select * from favourit where username='".$_GET['username']."'";
        $result2 = mysqli_query($conn,$query);
        $cnt = mysqli_num_rows($result2);
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
                        <?php
                            if($_SESSION['username']==$row['username'])
                            {
                                echo '<a href="/Febina/Members-Portal/editprofile">
                                    <i class="fa fa-pencil-square-o fa-xs ms-3" aria-hidden="true"></i>
                                </a>';
                            }
                        ?>
                        </h1>
                        <small><a href=""><?php echo $row['username']; ?></a></small>
                        <p class="mt-2">
                        <?php echo $row['about']; ?>
                        </p>
                        <p>
                        <a href=
                        <?php 
                                echo "/Febina/Members-Portal/favourite/".$row['username'];
                        ?>
                        class="link link-danger" style="text-decoration:none;">
                         Favourites <span class="badge badge-danger" style="border:1px solid black;color:black"><?php echo $cnt; ?></span>
                        </a>
                        </p>
                        <a href="<?php echo $row['fblink']; ?>"> <span class="mdi mdi-facebook" style="color:black; font-size: 2em;"></span></a>
                        <a href="<?php echo $row['instalink']; ?>"> <span class="mdi mdi-instagram" style="color:black; font-size: 2em;"></span></a>
                        <?php
                            if($_SESSION['username']!=$row['username'])
                            {
                                
                                if(mysqli_num_rows($result1)==0)
                                {
                                    echo '<a type="button" onclick="favourite(this.id)"> <span id="fav" class="fa fa-heart-o fa-2x" style="color:black; font-size: 2em;"></span></a>';
                                }
                                else
                                {
                                    echo '<a type="button" onclick="favourite(this.id)"> <span id="fav" class="fa fa-heart fa-2x" style="color:red; font-size: 2em;"></span></a>';
                                }
                            }
                        ?>
                        <!-- <a href="#"> <span class="mdi mdi-linkedin" style="color:black; font-size: 2em;"></span></a>
                        <a href="#"> <span class="mdi mdi-youtube" style="color:black; font-size: 2em; "></span></a> -->
                        <form action="/Febina/Members-Portal/code" id="favouritform" method="POST">
                            <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                            <input type="hidden" name="uname" value="<?php echo $row['username']; ?>">
                            <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="jumbotron feed-body-section">
            <center>
                <h1 style="padding: 30px 0;">Your Posts </h1>
            </center>

            <div class="container feed-cards" >
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
                                        if ($_SESSION['username'] == $row['username'])
                                        {
                                    ?>
                                            <li>
                                                <form action="/Febina/Members-Portal/editpost" method="post">
                                                <input type="hidden" name="postid" value=<?php echo $row['postid']; ?>>
                                                <input type="hidden" name="redirectto" value="profile">
                                                <button class="dropdown-item" type="submit" name="editposts">Edit</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="/Febina/Members-Portal/code" method="post">
                                                    <input type="hidden" name="postid" value=<?php echo $row['postid']; ?>>
                                                    <input type="hidden" name="redirectto" value="profile">
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
                                        <img src=<?php echo "/Febina/Members-Portal".ltrim($row['img_path'],"."); ?> alt="Post Image">
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
    <script type="text/javascript">
        function favourite(id)
        {
            if (document.getElementById('fav').className == "fa fa-heart-o fa-2x")
            {
                document.getElementById('fav').className = "fa fa-heart fa-2x"
                document.getElementById('fav').style.color = "red";  
                document.getElementById("favouritform").submit();  
            }
            else if (document.getElementById('fav').className == "fa fa-heart fa-2x")
            {
                document.getElementById('fav').className = "fa fa-heart-o fa-2x";
                document.getElementById('fav').style.color = "black";
                document.getElementById("favouritform").submit(); 
            }
        }
    </script>

<?php
    include "./footer.php";
?>