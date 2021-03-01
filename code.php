<?php
    session_start();
    include "./config/config.php";

    include "./database/db.php";
    require './PHPMailer/PHPMailerAutoload.php';
    require './PHPMailer/class.phpmailer.php'; 
    require './PHPMailer/class.smtp.php';
    date_default_timezone_set("Asia/Kolkata");
    $from = "admin@febinaevents.com";
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    //          Mail Sender
    //
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function smtpMailer($to,$from,$from_name,$subject,$body)
    {
        $mail = new PHPMailer();
        $mail->SMTPDebug = 3;                                   // Enable verbose debug output
        
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->SMTPSecure = 'tls';
        $mail->Mailer = "mail";
        $mail->Host = 'mail.febinaevents.com';              // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $from;                 // SMTP username
        $mail->Password = '8446736267@123';                           // SMTP password
        $mail->Port = 465;                                    // TCP port to connect to
        
        $mail->setFrom($from,$from_name);
        $mail->addAddress($to);               // Name is optional
        $mail->addReplyTo($from, 'Information');
        
        $mail->isHTML(true);                              // Set email format to HTML
        
        $mail->Subject = $subject;
        $mail->Body    = $body;
        
        
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } 
        else 
        {
            echo 'Message has been sent';
        }
        return true;
    }
    
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
           
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          OTP Generation
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['generateotp']))
        {
            $email = $_POST['email'];
            $query = "select * from user where email='$email'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)>0)
            {
                $_SESSION['RegisterFailure'] = "This email address is already used please try another one.";
                header('Location: '.$BASE_URL.'signup');
            }
            else
            {
                $otptosend = rand(99999,999999);
                $to = $_POST['email'];
                $_SESSION['email'] = $_POST['email'];
                $subject = "Email Verification";
                $message = "Hello sir/mam your OTP for email verifivation is ".$otptosend;
                $from_name = "Febina Jagriti Foundation";
                
                if(smtpMailer($to,$from,$from_name,$subject,$message))
                {

                    $_SESSION['otp'] = $otptosend;
                    $_SESSION['email'] = $to;
                    $_SESSION['otpsuccess'] = "success";
                    header('Location: '.$BASE_URL.'signup');
                }
                else
                {
                    $_SESSION['RegisterFailure'] = "OTP not send..! Please try again.";
                    header('Location: '.$BASE_URL.'signup');
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          OTP Verification
        //
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['verifyotp']))
        {
            $otpbyuser = $_POST['otp'];
            $otp = $_SESSION['otp'];
            
            if ($otp == $otpbyuser)
            {
                unset($_SESSION['otp']);
               
                $_SESSION['otpverified'] = "success";
                header('Location: '.$BASE_URL.'signup.php');
            }
            else
            {
                $_SESSION['RegisterFailure'] = "Mismatch OTP..! Please try again.";
                header('Location: '.$BASE_URL.'signup');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          User Registration
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['register']))
        {
            $name = $_POST['name'];
            $contact = $_POST['contactnumber'];
            $email = $_SESSION['email'];
            $address = $_POST['address'];
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $key = $_POST['key'];
            $present = false;
            $invalidkey = false;
            $duplicateuser = false;
            $srno = 0;

            $query = "select * from adharno where adhar = '$key'";

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result)==0) 
            {
                $_SESSION['RegisterFailure'] = "This VA key is not generated yet please contact admin.";
                unset($_SESSION['email']);
                header('Location: '.$BASE_URL.'signup');
            } 
            else 
            {
                $present = true;
                $query = "select * from user order by sr_no ASC";
                $result = mysqli_query($conn, $query);
                while ($row = $result->fetch_assoc()) 
                {
                    if ($username == $row['username']) 
                    {
                        $duplicateuser = true;
                        break;
                    }
                    $srno = $row['sr_no'];
                }
                $srno = $srno + 1;
                if ($duplicateuser) 
                {
                    $_SESSION['RegisterFailure'] = " This username already taken please try another one.";
                    unset($_SESSION['email']);
                    header('Location: '.$BASE_URL.'signup');
                }
                else 
                {
                    if ($present) 
                    {
                        $query = "select * from adharno where adhar = '$key'";
                        $result = mysqli_query($conn, $query);
                        while ($row = $result->fetch_assoc()) 
                        {
                            if ($row['valid'] == "1") 
                            {
                                $invalidkey = true;
                                break;
                            }
                        }
                        if ($invalidkey) 
                        {
                            $_SESSION['RegisterFailure'] = "This VA key is used, you can use one VA ket at only once.";
                            unset($_SESSION['email']);
                            header('Location: '.$BASE_URL.'signup');
                        } 
                        else 
                        {
                            $query = "insert into user(sr_no,name,contact_number,email,address,username,password,seckey) values('$srno','$name','$contact','$email','$address','$username','$password','$key')";
                            $result = mysqli_query($conn, $query);
                            if (!$result) 
                            {
                                die("Error : " . mysqli_error($conn));
                            } 
                            else 
                            {
                                $query = "update adharno set valid = '1' where adhar = '$key'";
                                $result = mysqli_query($conn, $query);
                                if ($result) 
                                {
                                    $_SESSION['RegisterationSuccess'] = "You have registered successfully, now you can login into community.";   
                                    unset($_SESSION['email']);
                                    unset($_SESSION['otpverified']);
                                    header('Location: '.$BASE_URL.'signin');   
                                } 
                            }
                        }
                    }
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Add Post
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['addpost']))
        {
            $postid = 0;
            $query = "select max(postid) as postid from posts";

            $result = mysqli_query($conn,$query);
            
            if(mysqli_num_rows($result) == 1)
            {
                $row = $result->fetch_assoc();
                $postid = $row['postid'];
            }
            $postid = $postid + 1;
            echo "postid :".$postid;
            $target_dir = "./postuploads/$postid/";
            $target_file = $target_dir . $_FILES["postimg"]["name"];
            echo $target_file;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $posttitle = $_POST['posttitle'];
            $postbody = $_POST['postbody'];
            date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d H:i:s");
            $name = $_SESSION['name'];
            $username = $_SESSION['username'];
            
            if(isset($_FILES['postimg']) && !empty($_FILES['postimg']['name']))
            {
                //check if folder is exists or not if not then create it
                if (!file_exists($target_dir)) 
                { 
                    mkdir($target_dir, 0777, true);
                    echo " dir :".$target_dir;
                }
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["postimg"]["tmp_name"]);
                if($check !== false) 
                {
                    $uploadOk = 1;
                } 
                else 
                {
                    $_SESSION['notimage'] = "File is not an image, please select valid file";
                    $uploadOk = 0;
                    $_SESSION['postfailure'] .= "File is not an image, please select valid file.";
                    
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) 
                {
                    $_SESSION['postfailure'] .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) 
                {
                    $_SESSION['postfailure'] .= "Sorry, your file was not uploaded.";
                    header('Location: '.$BASE_URL.'addpost');
                } 
                // if everything is ok, try to upload file
                else  
                {
                        if (move_uploaded_file($_FILES["postimg"]["tmp_name"], $target_file)) 
                        {
                            $query = "insert into posts(name,username,posttitle,post,posted_at,img_path,postid) values('$name','$username','$posttitle','$postbody','$date','$target_file','$postid')";
                            $result = mysqli_query($conn,$query);
                            if($result)
                            {
                                $_SESSION['postedsuccessfully'] = "Your post is on feed, Stay connected with us..!";
                                header('Location: '.$BASE_URL.'feed');
                                
                            }     
                            else
                            {
                                die("error".mysqli_error($conn));
                                $_SESSION['postfailure'] = "We have error while posting your thoughts,sorry for inconvenience.";
                                header('Location: '.$BASE_URL.'addpost');
                            }
                            
                        } 
                        else 
                        {
                            $_SESSION['postfailure'] = "We have error while posting your thoughts, sorry for inconvenience.";
                            header('Location: '.$BASE_URL.'addpost');
                        }
                }
            }
            else
            {
                $target_file = "https://images.pexels.com/photos/1527934/pexels-photo-1527934.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940";
                $query = "insert into posts(name,username,posttitle,post,posted_at,img_path,postid) values('$name','$username','$posttitle','$postbody','$date','$target_file','$postid')";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $_SESSION['postedsuccessfully'] = "Your post is on feed, Stay connected with us..!";
                    header('Location: '.$BASE_URL.'feed');
                    
                }
                else
                {
                    $_SESSION['postfailure'] = "We have error while posting your thoughts, sorry for inconvenience.";
                    header('Location: '.$BASE_URL.'addpost');
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          User Login
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['login']))
        {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $name = "";
            $isset = 0;
            $matched = true;
            $query = "select * from user where username = '$username' and password='$password'";

            $result = mysqli_query($conn, $query);
            
            if ($num = mysqli_num_rows($result) == 1) 
            {
                $row = $result->fetch_assoc();
                $name = $row['name'];

                $query = "select * from profile where username = '$username'";

                $result = mysqli_query($conn,$query);
                while($row = $result->fetch_assoc())
                {
                    $isset = $row['isset'];
                }
                $_SESSION['status'] = "login";
                $_SESSION['name'] = $name;
                $_SESSION['username'] = $username;
                if(isset($_POST['rememberme']))
                {
                    setcookie("funame",$_POST['username'], time() + (86400 * 30), "/");
                    setcookie("fpass",$_POST['password'], time() + (86400 * 30), "/");
                }
                if($isset==0)
                {
                    $_SESSION['setupprofile'] = "true";
                    header('Location: '.$BASE_URL.'setupprofile');
                }
                else
                {
                    header('Location: '.$BASE_URL.'feed');
                }
            } 
            else 
            {
                $_SESSION['loginfailure'] = "Invalid username or password, please try again...";
                header('Location: '.$BASE_URL.'signin');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          User Logout
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['logout']))
        {
            unset($_SESSION['status']);
            unset($_SESSION['username']);
            unset($_SESSION['name']);
            header('Location: '.$BASE_URL.'signin');
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          User edit post
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['editpost']))
        {
            $postid = $_POST['postid'];
            $posttitle = $_POST['posttitleEdit'];
            $postbody = $_POST['postbodyEdit'];
            date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d H:i:s");
            $name = $_SESSION['name'];
            $username = $_SESSION['username'];
            
            if(isset($_FILES['editeduploadpic']) && !empty($_FILES['editeduploadpic']['name']))
            {
                $target_dir = "./postuploads/$postid/";
                $target_file = $target_dir . basename($_FILES["editeduploadpic"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
                //check if folder is exists or not if not then create it
                if (!file_exists($target_dir)) 
                { 
                    mkdir($target_dir, 0777, true);
                }
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["editeduploadpic"]["tmp_name"]);
                if($check !== false) 
                {
                    $uploadOk = 1;
                } 
                else 
                {
                    $_SESSION['posteditfailure'] .= "File is not an image.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) 
                {
                    $_SESSION['posteditfailure'] .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) 
                {
                    $_SESSION['posteditfailure'] .= "Sorry, your file was not uploaded.";
                    header('Location: '.$BASE_URL.''.$_POST['redirectto']);
                } 
                // if everything is ok, try to upload file
                else  
                {
                        if (move_uploaded_file($_FILES["editeduploadpic"]["tmp_name"], $target_file)) 
                        {
                            $query = "update posts set name='$name',username='$username',posttitle='$posttitle',post='$postbody',posted_at='$date',img_path='$target_file' where postid='$postid'";
                            $result = mysqli_query($conn,$query);
                            if($result)
                            {
                                $dir = "./postuploads/".$postid."/";
                                
                                if (is_dir($dir))
                                {
                                    if ($fd = opendir($dir))
                                    {
                                        while (($file = readdir($fd)) !== false)
                                        {
                                            if ($file != "." && $file != "..")
                                            {
                                                $file = $dir.$file;
                                                if ($file != $target_file)
                                                {    
                                                   unlink($file);
                                                }
                                            }
                                        }           
                                        closedir($fd);
                                    }
                                }
                                $_SESSION['postededitsuccessfully'] = "Edited successfully";
                                header('Location: '.$BASE_URL.''.$_POST['redirectto']);
                                
                            }     
                            else
                            {
                                die("error".mysqli_error($conn));
                                $_SESSION['posteditfailure'] = "Post edit failure.";
                                header('Location: '.$BASE_URL.''.$_POST['redirectto']);
                            }
                            
                        } 
                        else 
                        {
                            $_SESSION['posteditfailure'] = "Post edit failure, sorry for inconvenience.";
                            header('Location: '.$BASE_URL.''.$_POST['redirectto']);
                        }
                }
            }
            else
            {
                if ($_POST['removeimage'])
                {
                    $target_file = "https://images.pexels.com/photos/1527934/pexels-photo-1527934.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940";
                    $query = "update posts set name='$name',username='$username',posttitle='$posttitle',post='$postbody',posted_at='$date',img_path='$target_file' where postid='$postid'";
                }
                else
                {
                    $query = "update posts set name='$name',username='$username',posttitle='$posttitle',post='$postbody',posted_at='$date' where postid='$postid'";
                }
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $_SESSION['postededitsuccessfully'] = "Edit successfully.";
                    header('Location: '.$BASE_URL.''.$_POST['redirectto']);
                    
                }
                else
                {
                    die("error".mysqli_error($conn));
                    $_SESSION['posteditfailure'] = "Post edit failure, sorry for inconvenience.";
                    header('Location: '.$BASE_URL.''.$_POST['redirectto']);
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          User delete post
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['deletepost']))
        {
            $postid = $_POST['postid'];

            $query = "delete from report where postid='$postid'";
            $res = mysqli_query($conn,$query);
            $query = "delete from reportuser where postid='$postid'";
            $res = mysqli_query($conn,$query);
            $query = "select img_path from posts where postid='$postid'";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $row = $result->fetch_assoc();
                $target_file = $row['img_path'];
                if (file_exists($target_file)) 
                { 
                    if(unlink($target_file))
                    {
                        rmdir(''.$BASE_URL.'postuploads/'.$postid);
                    }
                }
            }
            $query = "delete from posts where postid='$postid'";
            $res = mysqli_query($conn,$query);
            if ($res)
            {
                $_SESSION['postdeleted'] = "Post deleted..";
                header('Location: '.$BASE_URL.''.$_POST['redirectto']);
            }
            else
            {
               $_SESSION['postnotdeleted'] = "Post not deleted..";
                header('Location: '.$BASE_URL.''.$_POST['redirectto']);
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Setup Profile
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['setupprofile']))
        {
            $username = $_SESSION['username'];
            $name = $_SESSION['name'];
            $target_dir = "./profilepictures/$username/";
            $target_file = $target_dir . basename($_FILES["profileimg"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if(isset($_FILES['profileimg']) && !empty($_FILES['profileimg']['name']))
            {
                //check if folder is exists or not if not then create it
                if (!file_exists($target_dir)) 
                { 
                    mkdir($target_dir, 0777, true);
                }
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["profileimg"]["tmp_name"]);
                if($check !== false) 
                {
                    //File is an image
                    $uploadOk = 1;
                } 
                else 
                {
                   $_SESSION['notimage'] = "File is not an image, please select valid file";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") 
                {
                    $_SESSION['imgformatfailure'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                if ($uploadOk == 0) 
                {
                    // echo "Sorry, your file was not uploaded.";

                } 
                // if everything is ok, try to upload file
                else  
                {
                        if (move_uploaded_file($_FILES["profileimg"]["tmp_name"], $target_file)) 
                        {
                            $query = "insert into profile(name,username,about,dppath,instalink,fblink,isset,birthdate) values('$name','$username','about','$target_file','insta','fb',1,0000-00-00)";
                            $result = mysqli_query($conn,$query);
                            if($result)
                            {
                                $_SESSION['profilepictureuploaded'] = "Profile picture successfully uploaded..!";
                                $_SESSION['profilepath'] = $target_file;
                                header('Location: '.$BASE_URL.'setupprofile');
                                
                            }     
                            else
                            {
                                die("error".mysqli_error($conn));
                                $_SESSION['profilepictureuploadfailure'] = "We have error while uploading your profile picture";
                                header('Location: '.$BASE_URL.'setupprofile');
                            }
                        } 
                        else 
                        {
                            $_SESSION['profilepictureuploadfailure'] = "We have error while uploading your profile picture";
                            header('Location: '.$BASE_URL.'setupprofile');
                        }
                }
            }
            else
            {
                $target_file = "./img/user.png";
                $query = "insert into profile(name,username,about,dppath,instalink,fblink,isset,birthdate) values('$name','$username','about','$target_file','insta','fb',1,0000-00-00)";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $_SESSION['profilepictureuploaded'] = "Profile picture successfully uploaded..!";
                    $_SESSION['profilepath'] = $target_file;
                    header('Location: '.$BASE_URL.'setupprofile');
                    
                }     
                else
                {
                    die("error".mysqli_error($conn));
                    $_SESSION['profilepictureuploadfailure'] = "We have error while uploading your profile picture";
                    header('Location: '.$BASE_URL.'setupprofile');
                }
            }
            $birthdate = $_POST['birthdate'];
            $about = $_POST['about'];
            $instalink = $_POST['insta'];
            $fblink = $_POST['fb'];
            $username = $_SESSION['username']; 
            $query = "update profile set about='$about' , instalink='$instalink' , fblink='$fblink', username='$username' , birthdate='$birthdate' where username = '$username';";

            $result = mysqli_query($conn,$query);
            if($result)
            {
                $_SESSION['setupprofilsuccessfully'] = "Your profile set successfully";
                unset($_SESSION['setupprofile']);
                header('Location: '.$BASE_URL.'feed');
            }
            else
            {
                die("Error:".mysqli_error($conn));
                $_SESSION['setupprofilefailure'] = "Unable to setup your profile please try again..";
                header('Location: '.$BASE_URL.'setupprofile');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Visit Profile
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['VisitMember']))
        {
            header('Location:'.$BASE_URL.'profile/'.$_POST['username']);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Report Post
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['reportedpostid']))
        {
            $postid = $_POST['reportedpostid'];
            $reportedby = $_SESSION['username'];
            $reportedposttitle = "";
            $reportedpost = "";
            $reportcount = 0;
            $query = "select * from reportuser where username = '$reportedby' and postid = '$postid'";
            $result = mysqli_query($conn,$query);
            $rowcount = mysqli_num_rows($result);
            if($rowcount==0)
            {
                $query = "select * from posts where postid = '$postid'";
                $result = mysqli_query($conn,$query);
                if($row = $result->fetch_assoc())
                {
                    $reportedposttitle = $row['posttitle'];
                    $reportedpost = $row['post'];
                }
                $query = "insert into reportuser(username,postid) values('$reportedby','$postid')";
                $result = mysqli_query($conn,$query);
                if(!$result)
                {
                    die("Error : ".mysqli_error($conn));
                }
                $query = "select * from report where postid = '$postid'";
                $result = mysqli_query($conn,$query);
                $rowcount = mysqli_num_rows($result);
                if($rowcount==0)
                {
                    $query = "insert into report(postid,posttitle,post,reportcount,reportedby) values('$postid','$reportedposttitle','$reportedpost','1','$reportedby')";
                    $result = mysqli_query($conn,$query);
                    if(!$result)
                    {
                        die("Error : ".mysqli_error($conn));
                    }
                    else
                    {
                        $_SESSION['reportsuccess'] = "You have successfully reported this post.";
                        header('Location:'.$BASE_URL.'feed');
                    }
                }
                else
                {
                    if($row = $result->fetch_assoc())
                    {
                        $reportcount = $row['reportcount'];
                    }
                    $reportcount = $reportcount+1;
                    $query = "update report set reportcount = '$reportcount' WHERE postid = '$postid'";
                    $result = mysqli_query($conn,$query);
                    if(!$result)
                    {
                        die("Error :".mysqli_error($conn));
                    }
                    else
                    {
                        $_SESSION['reportsuccess'] = "You have successfully reported this post.";
                        header('Location:'.$BASE_URL.'feed');
                    }                  
                }
            }
            else
            {
                $_SESSION['reportfailure'] = "You have already reported this post you can't report it again.";
                header('Location:'.$BASE_URL.'feed');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Remove Profile Picture
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['remove']))
        {
            $username = $_POST['remove'];
            $query = "select dppath from profile where username = '$username'";
            $result = mysqli_query($conn,$query);
            if($row = $result->fetch_assoc())
            {
                if($row['dppath'] != "./img/user.png")
                {
                    unlink($row['dppath']);
                }

            }
            $query = "update profile set dppath = './img/user.png' where username = '$username'";
            $result = mysqli_query($conn,$query);
            if(!$result)
            {
                die("error".mysqli_error($conn));
            }
            else
            {
                $_SESSION['profileupdated'] = "Your profile picture successfully removed..!";
                header('Location:'.$BASE_URL.'editprofile');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Update Profile Picture
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['uploadimg']))
        {
            $username = $_POST['uploadimg'];
            $filename = $_FILES["uploadfile"]["name"]; 
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            if (!file_exists("./profilepictures/$username/")) 
            { 
                mkdir("./profilepictures/$username/", 0777, true);
            }     
            $folder = "./profilepictures/$username/".$filename; 
            if (move_uploaded_file($tempname, $folder))  
            {
                $dir = "./profilepictures/$username/";
                                
                if (is_dir($dir))
                {
                    if ($fd = opendir($dir))
                    {
                        while (($file = readdir($fd)) !== false)
                        {
                            if ($file != "." && $file != "..")
                            {
                                $file = $dir.$file;
                                if ($file != $folder)
                                {    
                                    unlink($file);
                                }
                            }
                        }           
                        closedir($fd);
                    }
                }
                $query = "update profile set dppath = '$folder' where username = '$username'";
                $result = mysqli_query($conn,$query);
                $_SESSION['profileupdated'] = "Your profile picture successfully updated..!";
                header('Location:'.$BASE_URL.'editprofile');
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Update Username
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['updateusername']))
        {
            $username = $_SESSION['username'];
            $newusername = $_POST['username'];
            
            $query = "select username from user where username='$newusername'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) == 0)
            {
                
                $query = "select dppath from profile where username='$username'";
                $res= mysqli_query($conn,$query);
                if ($res)
                {
                    $row = mysqli_fetch_assoc($res);
                    $dppath = $row['dppath'];
                    $arr = explode("/",$dppath);
                    $file = $arr[3];
                    if($arr[2]=="user.png")
                    {
                       $path = $dppath; 
                    }
                    else
                    {
                        $path = "./profilepictures/".$newusername."/".$file;   
                    }
                    $query = "update favourit set uname='$newusername' where uname='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update user set username='$newusername' where username='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update profile set username='$newusername',dppath='$path' where username='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update posts set username='$newusername' where username='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update report set reportedby='$newusername' where reportedby='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update reportuser set username='$newusername' where username='$username'";
                    $res = mysqli_query($conn,$query);
                    rename('./profilepictures/'.$username,'./profilepictures/'.$newusername);
                    $_SESSION['username'] = $newusername;
                    if(isset($_COOKIE['funame']))
                    {
                        setcookie("funame",$newusername, time() + (86400 * 30), "/");
                    }
                    $_SESSION['profileupdated'] = "Your username successfully updated..!";
                    header('Location:'.$BASE_URL.'editprofile');
                }
            }
            else
            {
                $_SESSION['profileupdatefailure'] = "Username already exists , try another username.";
                header('Location:'.$BASE_URL.'editprofile');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Update Name
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['updatename']))
        {
            $name = $_POST['name'];
            $username = $_POST['updatename'];
            $query = "update profile set name = '$name' where username = '$username'";
            $result = mysqli_query($conn,$query);
            $query = "update user set name = '$name' where username = '$username'";
            $result = mysqli_query($conn,$query);
            $_SESSION['profileupdated'] = "Your name successfully updated..!";
            header('Location:'.$BASE_URL.'editprofile');
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Update About
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['updateabout']))
        {
            $username = $_POST['updateabout'];
            $about = $_POST['about'];
            $about = nl2br($about);
            $query = "update profile set about = '$about' where username = '$username'";
            $result = mysqli_query($conn,$query);
            $_SESSION['profileupdated'] = "Your about successfully updated..!";
            header('Location:'.$BASE_URL.'editprofile');
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Update Birthdate
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['updatebirthdate']))
        {
            $username = $_POST['username'];
            $birthdate = $_POST['birthdate'];
            $query = "update profile set birthdate = '$birthdate' where username = '$username'";
            $result = mysqli_query($conn,$query);
            $_SESSION['profileupdated'] = "Your birthdate successfully updated..!";
            header('Location:'.$BASE_URL.'editprofile');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Update Instagram Link
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['updateinstalink']))
        {
            $username = $_POST['updateinstalink'];
            $instalink = $_POST['instalink'];
            $query = "update profile set instalink = '$instalink' where username = '$username'";
            $result = mysqli_query($conn,$query);
            $_SESSION['profileupdated'] = "Your instagram link successfully updated..!";
            header('Location:'.$BASE_URL.'editprofile');
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Update Facebook Link
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['updatefblink']))
        {
            $username = $_POST['updatefblink'];
            $fblink = $_POST['fblink'];
            $query = "update profile set fblink = '$fblink' where username = '$username'";
            $result = mysqli_query($conn,$query);
            $_SESSION['profileupdated'] = "Your facebook link successfully updated..!";
            header('Location:'.$BASE_URL.'editprofile');
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Forget Password OTP generation
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['forgetpassword']))
        {
            $email = $_POST['email'];
            $query = "select * from user where email='$email'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)==0)
            {
                $_SESSION['forgetpasswordfailure'] = "This email address is not registered please try another one.";
                header('Location: '.$BASE_URL.'forgetpassword');
            }
            else
            {
                $otptosend = rand(99999,999999);
                $to = $_POST['email'];
                $subject = "VA key alert";
                $message = "Hello sir/mam your OTP for email verifivation is ".$otptosend;
                
                $from_name = "Febina Jagriti Foundation";
                    
                
                if(smtpMailer($to,$from,$from_name,$subject,$message))
                {

                    $_SESSION['otp'] = $otptosend;
                    $_SESSION['email'] = $to;
                    $_SESSION['forgetpasswordotpsuccess'] = "success";
                    header('Location: '.$BASE_URL.'forgetpassword');
                }
                else
                {
                    $_SESSION['forgetpasswordfailure'] = "OTP not send..! Please try again.";
                    header('Location: '.$BASE_URL.'forgetpassword');
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Forget Password OTP verification
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['forgetpasswordverifyotp']))
        {
            $otpbyuser = $_POST['otp'];
            $otp = $_SESSION['otp'];
            
            if ($otp == $otpbyuser)
            {
                unset($_SESSION['otp']);
                $_SESSION['forgotpasswordotpverified'] = "success";
                header('Location: '.$BASE_URL.'forgetpassword');
            }
            else
            {
                $_SESSION['forgetpasswordfailure'] = "Mismatch OTP..! Please try again.";
                header('Location: '.$BASE_URL.'forgetpassword');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Reset Password & Change password
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['changepassword']))
        {
            if(isset($_SESSION['email']))
            {
                $newpassword = md5($_POST['newpassword']);
                $email =  $_SESSION['email'];
                $query = "update user set password = '$newpassword' where email = '$email'";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $_SESSION['resetpasswordsuccess'] = "Your reset password successfully done. Now you can signin.";
                    unset($_SESSION['email']);
                    setcookie("funame", "", time() - 3600);
                    setcookie("fupass", "", time() - 3600);
                    header('Location:'.$BASE_URL.'signin');
                }
                else
                {
                    $_SESSION['resetpasswordfailure'] = "Unable to reset password please try again.";
                    unset($_SESSION['email']);
                    header('Location: '.$BASE_URL.'forgetpassword');
                }
            }
            if(isset($_POST['username']))
            {
                $newpassword = md5($_POST['newpassword']);
                $username = $_POST['username'];
                $query = "update user set password = '$newpassword' where username = '$username'";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $_SESSION['changepasswordsuccess'] = "Your password changed successfully.";
                    if(isset($_COOKIE['fpass']))
                    {
                        setcookie("fpass",$_POST['newpassword'], time() + (86400 * 30), "/");
                    }
                   
                    header('Location:'.$BASE_URL.'editprofile');
                }
                else
                {
                    $_SESSION['changepasswordfailure'] = "Unable to reset password please try again.";
                    header('Location: '.$BASE_URL.'editprofile');
                }
            }   
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Admin Login
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['adminlogin']))
        {
            if ($_SERVER['REQUEST_METHOD'] == "POST") 
            {
                $username = $_POST['username'];
                $password = $_POST['password'];
            
                if ($username == "admin" && $password == "admin") 
                {
                    
                    $_SESSION['adminstatus'] = "login";
                    header('Location: '.$BASE_URL.'admin');
                } 
                else 
                {
                    $_SESSION['adminloginfailure'] = "Unable to login check your username or password";
                    header('Location: '.$BASE_URL.'adminlogin');
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Admin Logout
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['adminlogout']))
        {
            unset($_SESSION['adminstatus']);
            header('Location: '.$BASE_URL.'adminlogin');
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Add new VA key
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['addvakey']))
        {
            $newadharno = $_POST['adharno'];
            $query = "select * from adharno where adhar='$newadharno'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)==0)
            {
                $query = "insert into adharno(adhar,valid) values('$newadharno','0')";
                $result = mysqli_query($conn, $query);
                if ($result) 
                {
                    $to = $_POST['email'];
                    $_SESSION['email'] = $_POST['email'];
                    $subject = "VA key alert";
                    $message = "<h2 style='color:black;font-size: 18px;'>Hello sir/mam welcome to <a href='https://febinaevents.com'>Febina Community</a></h2><p style='color:black;font-size: 18px;'>Your VA key for registration is : ".$newadharno."  Don't share this key with anyone else.</p><h2 style='color:red;'>Steps to follow to join us...</h2><br><ol style='color:blue;font-size: 18px;'><li>Visit <a href='https://febinaevents.com/signup'>signup link</a></li><li>Enter your email id and generate OTP</li><li>Check inbox or spam for the OTP and verify it.</li><li>After vefification of OTP you will redirect to next page.</li><li>fill all the personal details and in the section VA key fill above VA key.</li><li>Once you get registered visit <a href='https://febinaevents.com/signin'>signin</a> to SIGNIN</li><li>After successfull signin setup your profile and enjoy our community...!</li></ol>";
                   $from = "fadmin@febinaevents.com";
                $from_name = "Febina Jagriti Foundation";
                    
                    if(smtpMailer($to,$from,$from_name,$subject,$message))
                    {
                        $_SESSION['newvakeysuccess'] = "New VA key added successfully..!";
                        header('Location: '.$BASE_URL.'admin');
                    }
                }
            }
            else
            {
                $_SESSION['newadharnofailure'] = "This adhar number is already in use please enter another one";
                header('Location: '.$BASE_URL.'admin');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Remove User
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['removeuser']))
        {
            $username = $_POST['username'];
            $query = "select * from user where username = '$username'";
            $result = mysqli_query($conn,$query);
            $row = $result->fetch_assoc();
            $seckey = $row['seckey'];
            
            $query = "delete from postlikes where likedby in (select sr_no from user where username = '$username')";
            $result = mysqli_query($conn,$query);
            
            $query = "delete from postlikes where postid in (select postid from posts where username = '$username')";
            $result = mysqli_query($conn,$query);
            
            $query = "delete from reportuser where postid in (select postid from posts where username='$username')";
            $result = mysqli_query($conn,$query);
            $query = "select * from report where postid in (select postid from posts where username='$username')";
            $result = mysqli_query($conn,$query);
            $query = "delete from favourit where username='$username' or uname='$username'";
            $result = mysqli_query($conn,$query);
            $query = "delete from reportuser where username = '$username'";
            $result = mysqli_query($conn,$query);
            $query = "delete from report where reportedby = '$username'";
            $result = mysqli_query($conn,$query);
            $query = "delete from profile where username = '$username'";
            $result = mysqli_query($conn,$query);
            $query = "delete from posts where username = '$username'";
            $result = mysqli_query($conn,$query);
            $query = "delete from user where username = '$username'";
            $result = mysqli_query($conn,$query);
            $query = "delete from adharno where adhar = '$seckey'";
            $result = mysqli_query($conn,$query);
            $_SESSION['userdeletedsuccess'] = "Member removed successfully...!";
            header('Location: '.$BASE_URL.'admin');
         }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Add or Remove favourit
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['uname']))
        {
            $username = $_SESSION['username'];
            $uname = $_POST['uname'];
            $name = $_POST['name'];
            $query = "select * from favourit where username='$username' and uname='$uname'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)==0)
            {
                $query = "insert into favourit(name,username,uname) values('$name','$username','$uname')";
                $result = mysqli_query($conn,$query);
                // header('Location:'.$BASE_URL.'profile/'.$uname);
            }
            else
            {
                $query = "delete from favourit where username='$username' and uname='$uname'";
                $result = mysqli_query($conn,$query);
                // header('Location:'.$BASE_URL.'profile/'.$uname);
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Admin Visit Profile
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['adminVisitMember']))
        {
            header('Location:'.$BASE_URL.'adminprofilevisit/'.$_POST['username']);
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Admin delete post
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['admindeletepost']))
        {
            $postid = $_POST['postid'];

            $query = "delete from report where postid='$postid'";
            $res = mysqli_query($conn,$query);
            $query = "delete from reportuser where postid='$postid'";
            $res = mysqli_query($conn,$query);
            $query = "select img_path from posts where postid='$postid'";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $row = $result->fetch_assoc();
                $target_file = $row['img_path'];
                if (file_exists($target_file)) 
                { 
                    if(unlink($target_file))
                    {
                        rmdir('./postuploads/'.$postid);
                    }
                }
            }
            $query = "delete from posts where postid='$postid'";
            $res = mysqli_query($conn,$query);
            if ($res)
            {
                $_SESSION['adminpostdeleted'] = "Post deleted..";
                header('Location:'.$BASE_URL.'adminprofilevisit/'.$_POST['username']);
            }
            else
            {
                $_SESSION['adminpostnotdeleted'] = "Post not deleted..";
                header('Location: '.$BASE_URL.'adminprofilevisit/'.$_POST['username']);
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Delete Reported post
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_POST['admindeletereportedpost']))
        {
            $postid = $_POST['postid'];

            $query = "delete from report where postid='$postid'";
            $res = mysqli_query($conn,$query);
            $query = "delete from reportuser where postid='$postid'";
            $res = mysqli_query($conn,$query);
            $query = "select img_path from posts where postid='$postid'";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $row = $result->fetch_assoc();
                $target_file = $row['img_path'];
                if (file_exists($target_file)) 
                { 
                    if(unlink($target_file))
                    {
                        rmdir('./postuploads/'.$postid);
                    }
                }
            }
            $query = "delete from posts where postid='$postid'";
            $res = mysqli_query($conn,$query);
            if ($res)
            {
                $_SESSION['adminreportedpostdeleted'] = "Post deleted..";
                header('Location:'.$BASE_URL.'admin');
            }
            else
            {
                $_SESSION['adminreportedpostnotdeleted'] = "Post not deleted..";
                header('Location: '.$BASE_URL.'admin');
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //         Like posts
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['likedby']))
        {
            $username = $_POST['likedby'];
            $postid = $_POST['postid'];
            $srno = 0;
            $likedby = "";
            $count = 0;
            $query = "select * from user where username = '$username'";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                $row = $result->fetch_assoc();
                $srno = $row['sr_no'];
            }
            $query = "select * from postlikes where postid = '$postid' and likedby = '$srno'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)==0)
            {
                $query = "insert into postlikes(likedby,postid) values('$srno','$postid')";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $count = 1;
                }
                else
                {
                    die("Error : ".mysqli_error($conn));
                }
            }
            $query = "select * from postlikes where postid = '$postid'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) >= 0)
            {
                echo mysqli_num_rows($result);   
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //         Unlike posts
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['unlikedby']))
        {
            $username = $_POST['unlikedby'];
            $postid = $_POST['postid'];
            $srno = 0;
            $query = "select * from user where username = '$username'";
            $result = mysqli_query($conn,$query);
            if($result)
            {
                
                $row = $result->fetch_assoc();
                $srno = $row['sr_no'];
            }
            $query = "select * from postlikes where postid = '$postid' and likedby = '$srno'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)!=0)
            {
                $query = "delete from postlikes where postid = '$postid' and likedby = '$srno'";
                $result = mysqli_query($conn,$query);
                    
            }
            else
            {
                die("Error : ".mysqli_error($conn));
            }
            $query = "select * from postlikes where postid = '$postid'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result) >= 0)
            {
                echo mysqli_num_rows($result);   
            }                                        
            
            
            
        }
    }
?>