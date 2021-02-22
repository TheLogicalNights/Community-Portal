<?php
    include "./database/db.php";
    session_start();
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
        
        echo '<div class="container feed-cards">';
            if ($res)
            {
                while ($row = mysqli_fetch_assoc($res))
                {
                    echo '<div class="card post-card" data-aos="zoom-in">
                        <div class="dropdown d-flex justify-content-end" style="display:flex; justify-content:flex-end; margin-right:10px ;width:100%; padding:5px;">
                            <a style="margin-right:auto;color:black;font-weight:700;text-decoration:none;" href="/Febina/Members-Portal/profile/'.$row['username'].'">'.$row['name'] .'</a>
                            <a  style ="font-size :10px;" class="btn btn-secondary mr-0" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </a>';
                            echo '<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">';
                            if (isset($_SESSION['username']))
                            {
                               
                                
                                    if ($_SESSION['username'] == $row['username'])
                                    {
                                
                                        echo'
                                        <li>
                                            <form action="/Febina/Members-Portal/editpost" method="post">
                                                <input type="hidden" name="postid" value='.$row['postid'].' >
                                                <input type="hidden" name="redirectto" value="feed">
                                                <button class="dropdown-item" type="submit" name="editposts">Edit</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="/Febina/Members-Portal/code" method="post">
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
                                            <form action="/Febina/Members-Portal/code" method="POST">
                                                <input type="hidden" name="reportedpostid" value='.$_SESSION['username'].' >
                                                <input type="hidden" name="reportedpostid" value='.$row['postid'].' >
                                                <button class="dropdown-item" type="submit">Report</button>
                                            </form>
                                        </li>
                                        ';
                                    }
                                
                                echo '
                                        <li>
                                            <a href="https://web.whatsapp.com://send?text=http://localhost/Febina/Members-Portal/readmore?postid='.$row['postid'].'" class="dropdown-item mobileView">Share on <i style="color:rgb(37,211,102);" class="fa fa-whatsapp" aria-hidden="true"></i></a>        
                                        </li>
                                        <li>
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=localhost/Febina/Members-Portal/readmore?postid='.$row['postid'].'" target="_blank" rel="noopener" class="dropdown-item mobileView">Share on <i style="color: #1877f2;" class="fa fa-facebook" aria-hidden="true"></i>
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
                                    echo "/Febina/Members-Portal".ltrim($row['img_path'],".");
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
                                    
                                    <div>
                                    
                                        <form class="post-meta" action="/Febina/Members-Portal/readmore" method="GET">
                                            ';
                                            if (isset($_SESSION['username']))
                                            {
                                                echo '<a type="button" name="'.$_SESSION['username'].'" style="padding:5px;border-radius:25%;border: solid 1px orange;" id=like'.$row['postid'].' onclick="Like(this.id,this)"> <span id='.$row['postid'].' class="fa fa-thumbs-o-up fa-2x" style="color: #FFAB01;"></span></a>';
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
        
            echo '</div>';
    }
?>