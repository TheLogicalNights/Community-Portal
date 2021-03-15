<?php
    session_start();
    include "./database/db.php";
    include "./config/config.php";
    include "./config/userexist.php";
    $sr = 0;
    if(isset($_SESSION['username']))
    {
        $query = "select sr_no from user where username='".$_SESSION['username']."'";
        $result = mysqli_query($conn,$query);
        $r =mysqli_fetch_assoc($result);
        $sr = $r['sr_no'];
        
    }
    $cnt = 0;
    function startsWith ($string, $startString) 
    { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    }
    if(isset($_POST['limit']))
    {
        $offset = $_POST['offset'];
        $limit = $_POST['limit'];
        $query = "select * from posts order by posted_at DESC limit {$limit} offset {$offset} ";
        $res = mysqli_query($conn,$query);
        $count = 0;
            if ($res)
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    $cnt = 0;
                    $query = "select * from postlikes where postid='".$row['postid']."'";
                    $result = mysqli_query($conn,$query);
                    if (mysqli_num_rows($result) > 0)
                    {
                        $cnt = mysqli_num_rows($result);
                    }
                    echo '<div class="card post-card" data-aos="zoom-in">
                        <div class="dropdown d-flex justify-content-end" style="display:flex; justify-content:flex-end; margin-right:10px ;width:100%; padding:5px;">
                            <a class="ms-3" style="margin-right:auto;color:black;text-decoration:none;font-size:15px;" href="'.$BASE_URL.'profile/'.$row['username'].'"><strong>'.$row['username'] .'</strong></a>';
                            if (isset($_SESSION['username']))
                            {
                                echo '<a  style ="font-size :10px;border:solid rgb(205,178,102) 1px;" class="btn btn-secondary mr-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v" style="font-size:14px;color:black;" aria-hidden="true"></i>
                            </a>';
                            
                            
                               echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">';
                                
                                    if ($_SESSION['username'] == $row['username'])
                                    {
                                
                                        echo'
                                        <li>
                                            <form action="'.$BASE_URL.'editpost" method="post">
                                                <input type="hidden" name="postid" value='.$row['postid'].' >
                                                <input type="hidden" name="redirectto" value="feed">
                                                <button class="dropdown-item" type="submit" name="editposts">Edit</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="'.$BASE_URL.'code" method="post">
                                                <input type="hidden" name="postid" value='.$row['postid'].' >
                                                <input type="hidden" name="redirectto" value="feed">
                                                <button onclick="return confirm(\'Are you sure you want to delete this post ?\');" class="dropdown-item" type="submit" name="deletepost">Delete</button>
                                            </form>
                                        </li>
                                        ';
                                    }
                                    else
                                    {
                                
                                        echo '<li>
                                            <form action="'.$BASE_URL.'code" method="POST">
                                                <input type="hidden" name="reportedpostid" value='.$_SESSION['username'].' >
                                                <input type="hidden" name="reportedpostid" value='.$row['postid'].' >
                                                <button class="dropdown-item" type="submit">Report</button>
                                            </form>
                                        </li>
                                        ';
                                    }
                                
                                echo '
                                        <li>
                                            <a href="whatsapp://send?text='.$BASE_URL.'readmore?postid='.$row['postid'].'" class="dropdown-item mobileView">Share on <i style="color:rgb(37,211,102);" class="fa fa-whatsapp" aria-hidden="true"></i></a>        
                                        </li>
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u='.$BASE_URL.'readmore?postid='.$row['postid'].'" target="_blank" rel="noopener" class="dropdown-item">Share on <i style="color: #1877f2;" class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                </ul>';
                            }
                        echo '</div>
                        
                        <div class="card-inner-box">
                            <div class="post-img">
                                <img src="';
                                if (startsWith($row['img_path'],"./"))
                                {
                                    echo $row['img_path'];
                                } 
                                else
                                {
                                    echo $row['img_path'];
                                }
                                
                            echo '" alt="Post Image">
                            </div>
                            <div class="">
                                <div class="card-body">
                                
                                    <h5 class="card-title">';
                                       
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
                                        
                                    echo '</h5>
                                    <div class="post-desc-container" id="postdesc">';   
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
                                        
                                    echo '</div>
                                    <hr>
                                    <div>
                                    
                                        <form class="post-meta" action="'.$BASE_URL.'readmore" method="GET">
                                            ';
                                            if (isset($_SESSION['username']))
                                            {
                                                $pid = $row['postid'];
                                                $query5 = "select * from postlikes where postid = '$pid' and likedby = '$sr'";
                                                $result5 = mysqli_query($conn,$query5);
                                                    if (mysqli_num_rows($result5)>0)
                                                    {
                                                        echo '<a type="button" name="'.$_SESSION['username'].'" style="padding:5px;" id=like'.$row['postid'].' onclick="Like(this.id,this)"> <span id='.$row['postid'].' class="fa fa-thumbs-up" style="font-size:20px;color: #FFAB01;"> <label id="count'.$row['postid'].'" style="font-family:Tahoma;font-size:18px;"> '.$cnt.'</label></span></a>';
                                                    }
                                                    else
                                                    {                                                   
                                                        echo '<a type="button" name="'.$_SESSION['username'].'" style="padding:5px;" id=like'.$row['postid'].' onclick="Like(this.id,this)"> <span id='.$row['postid'].' class="fa fa-thumbs-o-up" style="font-size:20px;color: #FFAB01;"> <label id="count'.$row['postid'].'" style="font-family:Tahoma;font-size:18px;"> '.$cnt.'</label></span></a>';
                                                    }
                                               
                                            }
                                            echo '<a type="button" name="readmorefeed" href="readmore.php?postid='.$row['postid'].'" class="btn btn-primary"> Read more</a>
                                            <small>';
                                                
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
                                                
                                            echo 'ago';
                                            echo '</small>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                    ';
                }
            }
        
    }
?>