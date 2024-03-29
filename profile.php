<?php
    session_start();
    include "./config/config.php";
    include ('./database/db.php');
    $sr = 0;
    $count = 0;
    $result = "";
    $cnt = 0;
    $isBirthdate = false;
    $fname = "";
    date_default_timezone_set("Asia/Kolkata");
    if(isset($_SESSION['username']) && !(isset($_GET['username'])))
    {
        $query = "select sr_no from user where username='".$_SESSION['username']."'";
        $result = mysqli_query($conn,$query);
        $r =mysqli_fetch_assoc($result);
        $sr = $r['sr_no'];
        $query = "select * from profile where username='".$_SESSION['username']."'";
        $result = mysqli_query($conn,$query);
        $query = "select * from favourit where username='".$_SESSION['username']."'";
        $result1 = mysqli_query($conn,$query);
        $cnt = mysqli_num_rows($result1);
    }
    else if((isset($_GET['username'])) && (!(isset($_SESSION['username'])) || (isset($_SESSION['username']))))
    {
        $query = "select * from profile where username = '".$_GET['username']."'";
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result)==0)
        {
            header("Location: https://www.febinaevents.com/pagenotfound");
        }
        $query = "select * from profile where username='".$_GET['username']."'";
        $result = mysqli_query($conn,$query);
        $query1 = "select * from favourit where uname='".$_GET['username']."' and username='".$_SESSION['username']."'";
        $result1 = mysqli_query($conn,$query1);
        $query = "select * from favourit where username='".$_GET['username']."'";
        $result2 = mysqli_query($conn,$query);
        $cnt = mysqli_num_rows($result2);
        $query3 = "select sr_no from user where username='".$_SESSION['username']."'";
        $result3 = mysqli_query($conn,$query3);
        $r =mysqli_fetch_assoc($result3);
        $sr = $r['sr_no'];
    }
    else
    {
        header("Location: signin");
    }
    include ('./header.php');
    function startsWith ($string, $startString) 
    { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    }
    if(isset($_SESSION['posteditfailure']))
    {
        echo '
        <script>
            swal("Error..!", "'.$_SESSION['posteditfailure'].'", "error");
        </script>
        ';
        unset($_SESSION['posteditfailure']);
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
        <?php
        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
        ?>
        <div class="jumbotron profile-jumbotron">
            <div class="container">
                <div class="profile-section">
                
                    <div class="profile-img" data-aos="zoom-out-right">
                        <img src="<?php echo $BASE_URL.ltrim($row['dppath'],"."); ?>" class="rounded-circle" width="250" height="250" alt="Profile picture">
                    </div>
                    
                    <div class="profile-details" data-aos="zoom-out-left">
                        <h1 class="mt-4" style="font-family: 'Lora', serif;"><?php echo $row['name']; ?>
                        <?php
                            if(isset($_SESSION['username']))
                            {
                                if($_SESSION['username']==$row['username'])
                                {
                                    echo '<a href="'.$BASE_URL.'editprofile">
                                        <i class="fa fa-pencil-square-o fa-xs ms-3" style="color:brown;" aria-hidden="true"></i>
                                    </a>';
                                }
                            }
                        ?>
                        </h1>
                        <a href="" class="ms-2" style="font-family: 'RocknRoll One', sans-serif;font-size:15px;">- <?php echo $row['username']; ?></a>
                        <p class="mt-2 shadow" style="border-left:3px solid orange !important;padding:7px 10px !important;border-bottom:3px solid orange;border-top:3px solid black;border-right:3px solid black;">
                        <?php echo $row['about']; ?>
                        </p>
                        <p>
                        <?php 
                            if(isset($_SESSION['username']))
                            {
                        ?>
                                <a href=
                            <?php 
                                echo $BASE_URL."favourite/".$row['username'];
                        ?>
                        class="link link-danger" style="text-decoration:none;">
                         Favourites <span class="badge badge-danger" style="border:1px solid black;color:black"><?php echo $cnt; ?></span>
                        </a>
                        </p>
                        <?php
                            }
                        ?>
                        <div style="display:flex; justify-content:center; align-items:center;">
                            <span style="font-size:1.2rem;font-weight:bold;">Social Media Links :</span>
                            <a href="<?php echo $row['fblink']; ?>"> <span class="mdi mdi-facebook" style="color: #3b5998 ; font-size: 2em;"></span></a>
                            <a href="<?php echo $row['instalink']; ?>"> <span class="mdi mdi-instagram" style="color: #e1306c ; font-size: 2em;"></span></a>
                        </div>
                        <?php
                            if(isset($_SESSION['username']))
                            {
                                if($_SESSION['username']!=$row['username'])
                                {

                                    if(mysqli_num_rows($result1)==0)
                                    {
                                        echo '<a type="button" name="'.$row['username'].'" id="'.$row['name'].'" onclick="favourite(this)"> <span id="fav" class="fa fa-heart-o fa-2x" style="color:black; font-size: 2em;"></span></a>';
                                    }
                                    else
                                    {
                                        echo '<a type="button" name="'.$row['username'].'" id="'.$row['name'].'" onclick="favourite(this)"> <span id="fav" class="fa fa-heart fa-2x" style="color:red; font-size: 2em;"></span></a>';
                                    }
                                }
                            }
                        ?>
                        <!-- <a href="#"> <span class="mdi mdi-linkedin" style="color:black; font-size: 2em;"></span></a>-->
                        <!--<a href="#"> <span class="mdi mdi-youtube" style="color:black; font-size: 2em; "></span></a> -->
                        <form action="<?php echo $BASE_URL; ?>code" id="favouritform" method="POST">
                            <input type="hidden" name="username" value="<?php
                            if(isset($_SESSION['username']))
                            { 
                             echo $_SESSION['username']; 
                            } 
                             ?>">
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
                <h1 style="padding: 30px 0;font-family: 'Concert One', cursive;">Your Posts </h1>
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
                            $count = 0;
                            $query = "select * from postlikes where postid='".$row['postid']."'";
                            $result = mysqli_query($conn,$query);
                            if (mysqli_num_rows($result) >= 0)
                            {
                                $count = mysqli_num_rows($result);
                            }
                ?>
                            <div class="card post-card" data-aos="zoom-in" style="background-color:rgb(204,255,255,0.4);">
                                <div class="dropdown d-flex justify-content-end" style="display:flex; justify-content:flex-end; margin-right:10px ;width:100%; padding:5px;">
                                <a style="margin-right:auto;color:black;font-weight:700;text-decoration:none;" href="<?php echo $BASE_URL; ?>profile/<?php echo $row['username']; ?>"><?php echo $row['name'];?></a>
                                <?php 
                                    if(isset($_SESSION['username']))
                                    {
                                ?>    
                                    <a style ="font-size :10px;border:solid orange 1px;" class="btn btn-secondary mr-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                <?php
                                    }
                                ?>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <?php
                                        if ($_SESSION['username'] == $row['username'])
                                        {
                                    ?>
                                            <li>
                                                <form action="<?php echo $BASE_URL; ?>editpost" method="post">
                                                <input type="hidden" name="postid" value=<?php echo $row['postid']; ?>>
                                                <input type="hidden" name="redirectto" value="profile">
                                                <button class="dropdown-item" type="submit" name="editposts">Edit</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="<?php echo $BASE_URL; ?>code" method="post">
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
                                                <form action="<?php echo $BASE_URL; ?>code" method="POST">
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
                                        <img 
                                    <?php
                                        if(startsWith($row['img_path'],"./"))
                                        {
                                    ?>                                     
                                            src="<?php echo $BASE_URL.ltrim($row['img_path'],"."); ?>" 
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                            src="<?php echo $row['img_path']; ?>"
                                    <?php
                                        }    
                                    ?>    
                                        alt="Post Image">

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
                                                    $flag = 0;
                                                    $post = strip_tags($row['post']); 
                                                    if (strlen($post) > 80)
                                                    {
                                                        for ($i = 0; $i < 80; $i++)
                                                        {
                                                            if ($post[$i] == ' ')
                                                                $flag = 1;
                                                            if ($i == 30 && $flag == 0)
                                                                echo "<br>";
                                                            if ($i == 60 && $flag == 0)
                                                                echo "<br>";
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
                                                <form class="post-meta" action="<?php echo $BASE_URL; ?>readmore" method="post">
                                                    
                                                    <?php    
                                                        if (isset($_SESSION['username']))
                                                        {
                                                    ?>
                                                    <?php
                                                            if(isset($_GET['username']))
                                                            {
                                                                $pid = $row['postid'];
                                                                $query5 = "select * from postlikes where postid = '$pid' and likedby = '$sr'";
                                                                $result5 = mysqli_query($conn,$query5);
                                                                    if (mysqli_num_rows($result5)>0)
                                                                    {
                                                                        echo '<a type="button" name="'.$_SESSION['username'].'" style="padding:5px;" id=like'.$row['postid'].' onclick="Like1(this.id,this)"> <span id='.$row['postid'].' class="fa fa-thumbs-up" style="font-size:20px;color: #FFAB01;"> <label id="count'.$row['postid'].'" style="font-family:Tahoma;font-size:18px;"> '.$count.'</label></span></a>';
                                                                    }
                                                                    else
                                                                    {                                                   
                                                                        echo '<a type="button" name="'.$_SESSION['username'].'" style="padding:5px;" id=like'.$row['postid'].' onclick="Like1(this.id,this)"> <span id='.$row['postid'].' class="fa fa-thumbs-o-up" style="font-size:20px;color: #FFAB01;"> <label id="count'.$row['postid'].'" style="font-family:Tahoma;font-size:18px;"> '.$count.'</label></span></a>';
                                                                    }
                                                            }
                                                            else
                                                            {
                                                                $pid = $row['postid'];
                                                                $query5 = "select * from postlikes where postid = '$pid' and likedby = '$sr'";
                                                                $result5 = mysqli_query($conn,$query5);
                                                                    if (mysqli_num_rows($result5)>0)
                                                                    {
                                                                        echo '<a type="button" name="'.$_SESSION['username'].'" style="padding:5px;" id=like'.$row['postid'].' onclick="Like(this.id,this)"> <span id='.$row['postid'].' class="fa fa-thumbs-up" style="font-size:20px;color: #FFAB01;"> <label id="count'.$row['postid'].'" style="font-family:Tahoma;font-size:18px;"> '.$count.'</label></span></a>';
                                                                    }
                                                                    else
                                                                    {                                                   
                                                                        echo '<a type="button" name="'.$_SESSION['username'].'" style="padding:5px;" id=like'.$row['postid'].' onclick="Like(this.id,this)"> <span id='.$row['postid'].' class="fa fa-thumbs-o-up" style="font-size:20px;color: #FFAB01;"> <label id="count'.$row['postid'].'" style="font-family:Tahoma;font-size:18px;"> '.$count.'</label></span></a>';
                                                                    }
                                                            }
                                                        }
                                                    ?>
                                                    <a type="button" name="readmorefeed" href="<?php echo $BASE_URL; ?>readmore.php?postid=<?php echo $row['postid']; ?>" class="btn btn-primary"> Read more</a>
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
    <script type="text/javascript">
        function favourite(obj)
        {
            console.log(obj.name);
            console.log(obj.id);
            if (document.getElementById('fav').className == "fa fa-heart-o fa-2x")
            {
                
                  
                // document.getElementById("favouritform").submit();
                $.ajax({
                    type:"POST",
                    url:"../code.php",
                    data:
                    {
                    'uname': obj.name,
                    'name': obj.id,
                    },
                    success:function(data)
                    {
                        document.getElementById('fav').className = "fa fa-heart fa-2x";
                        document.getElementById('fav').style.color = "red";
                    }  
                });
            }
            else if (document.getElementById('fav').className == "fa fa-heart fa-2x")
            {
                // document.getElementById("favouritform").submit(); 
                $.ajax({
                    type:"POST",
                    url:"../code.php",
                    data:
                    {
                        'uname': obj.name,
                        'name': obj.id,
                    },
                    success:function(data)
                    {
                        document.getElementById('fav').className = "fa fa-heart-o fa-2x";
                        document.getElementById('fav').style.color = "black";
                    }
                });
            }
        }
       
    </script>

<?php
    include "./footer.php";
?>