<?php
    session_start();
    include "./database/db.php";
    date_default_timezone_set("Asia/Kolkata");
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
                header('Location: /Febina/Members-Portal/signup');
            }
            else
            {
                $otptosend = rand(99999,999999);
                $to = $_POST['email'];
                $_SESSION['email'] = $_POST['email'];
                $subject = "Email Verification";
                $message = "Hello sir/mam your OTP for email verifivation is ".$otptosend;
                $headers = "From: swapnil.febina1@gmail.com";
                
                if(mail($to,$subject,$message,$headers))
                {

                    $_SESSION['otp'] = $otptosend;
                    $_SESSION['email'] = $to;
                    $_SESSION['otpsuccess'] = "success";
                    header('Location: /Febina/Members-Portal/signup');
                }
                else
                {
                    $_SESSION['RegisterFailure'] = "OTP not send..! Please try again.";
                    header('Location: /Febina/Members-Portal/signup');
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
                header("Location: /Febina/Members-Portal/signup.php");
            }
            else
            {
                $_SESSION['RegisterFailure'] = "Mismatch OTP..! Please try again.";
                header('Location: /Febina/Members-Portal/signup');
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
            $password = $_POST['password'];
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
                header('Location: /Febina/Members-Portal/signup');
            } 
            else 
            {
                $present = true;
                $query = "select * from user where username = '$username'";
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
                    header('Location: /Febina/Members-Portal/signup');
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
                            header('Location: /Febina/Members-Portal/signup');
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
                                    header('Location: /Febina/Members-Portal/signin');   
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
            $target_file = $target_dir . basename($_FILES["postimg"]["name"]);
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
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) 
                {
                    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) 
                {
                    // echo "Sorry, your file was not uploaded.";

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
                                header('Location: /Febina/Members-Portal/feed');
                                
                            }     
                            else
                            {
                                die("error".mysqli_error($conn));
                                $_SESSION['postfailure'] = "We have error while posting your thoughts,sorry for inconvenience.";
                                header('Location: /Febina/Members-Portal/addpost');
                            }
                            
                        } 
                        else 
                        {
                            $_SESSION['postfailure'] = "We have error while posting your thoughts, sorry for inconvenience.";
                            header('Location: /Febina/Members-Portal/addpost');
                        }
                }
            }
            else
            {
                $target_file = "https://images.pexels.com/photos/1680172/pexels-photo-1680172.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260";
                $query = "insert into posts(name,username,posttitle,post,posted_at,img_path,postid) values('$name','$username','$posttitle','$postbody','$date','$target_file','$postid')";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $_SESSION['postedsuccessfully'] = "Your post is on feed, Stay connected with us..!";
                    header('Location: /Febina/Members-Portal/feed');
                    
                }
                else
                {
                    $_SESSION['postfailure'] = "We have error while posting your thoughts, sorry for inconvenience.";
                    header('Location: /Febina/Members-Portal/addpost');
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
            $password = $_POST['password'];
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
                if($isset==0)
                {
                    $_SESSION['setupprofile'] = "true";
                    header("Location: /Febina/Members-Portal/setupprofile");
                }
                else
                {
                    header("Location: /Febina/Members-Portal/feed");
                }
            } 
            else 
            {
                $_SESSION['loginfailure'] = "Invalid username, please try again...";
                header("Location: /Febina/Members-Portal/signin");
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
            header('Location: /Febina/Members-Portal/signin');
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
                    // echo "File is not an image.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) 
                {
                    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) 
                {
                    // echo "Sorry, your file was not uploaded.";

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
                                header('Location: /Febina/Members-Portal/'.$_POST['redirectto']);
                                
                            }     
                            else
                            {
                                die("error".mysqli_error($conn));
                                $_SESSION['posteditfailure'] = "Post edit failure.";
                                header('Location: /Febina/Members-Portal/editpost');
                            }
                            
                        } 
                        else 
                        {
                            $_SESSION['posteditfailure'] = "Post edit failure, sorry for inconvenience.";
                            header('Location: /Febina/Members-Portal/editpost');
                        }
                }
            }
            else
            {
                if ($_POST['removeimage'])
                {
                    $target_file = "https://images.pexels.com/photos/1680172/pexels-photo-1680172.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260";
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
                    header('Location: /Febina/Members-Portal/'.$_POST['redirectto']);
                    
                }
                else
                {
                    die("error".mysqli_error($conn));
                    $_SESSION['posteditfailure'] = "Post edit failure, sorry for inconvenience.";
                    header('Location: /Febina/Members-Portal/editpost');
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
                        rmdir('./postuploads/'.$postid);
                    }
                }
            }
            $query = "delete from posts where postid='$postid'";
            $res = mysqli_query($conn,$query);
            if ($res)
            {
                $_SESSION['postdeleted'] = "Post deleted..";
                header('Location: /Febina/Members-Portal/'.$_POST['redirectto']);
            }
            else
            {
               $_SESSION['postnotdeleted'] = "Post not deleted..";
                header('Location: /Febina/Members-Portal/'.$_POST['redirectto']);
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Upload profile picture
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['uploadprofilepicture']))
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
                                header('Location: /Febina/Members-Portal/setupprofile');
                                
                            }     
                            else
                            {
                                die("error".mysqli_error($conn));
                                $_SESSION['profilepictureuploadfailure'] = "We have error while uploading your profile picture";
                                header('Location: /Febina/Members-Portal/setupprofile');
                            }
                            
                        } 
                        else 
                        {
                            $_SESSION['profilepictureuploadfailure'] = "We have error while uploading your profile picture";
                            header('Location: /Febina/Members-Portal/setupprofile');
                        }
                }
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Setup Profile
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['setupprofile']))
        {
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
                header("Location:/Febina/Members-Portal/feed");
            }
            else
            {
                die("Error:".mysqli_error($conn));
                $_SESSION['setupprofilefailure'] = "Unable to setup your profile please try again..";
                header("Location:/Febina/Members-Portal/setupprofile");
            }
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Visit Profile
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['VisitMember']))
        {
            header("Location:/Febina/Members-Portal/profile/".$_POST['username']);
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
                if($rowcount2==0)
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
                        header("Location:/Febina/Members-Portal/feed");
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
                        header("Location:/Febina/Members-Portal/feed");
                    }                  
                }
            }
            else
            {
                $_SESSION['reportfailure'] = "You have already reported this post you can't report it again.";
                header("Location:/Febina/Members-Portal/feed");
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
                header("Location:/Febina/Members-Portal/editprofile");
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
                header("Location:/Febina/Members-Portal/editprofile");
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
            $path ="";
            $query = "select username from user where username='$newusername'";
            $res = mysqli_query($conn,$query);
            if (mysqli_num_rows($res) == 0)
            {
                $query = "select dppath from profile where username='$username'";
                $res= mysqli_query($conn,$query);
                if ($res)
                {
                    $row = mysqli_fetch_assoc($res);
                    $dppath = $row['dppath'];
                    $arr = explode("/",$dppath);
                    $file = $arr[3];
                    $path = "./profilepictures/".$newusername."/".$file;
                    $query = "update user set username='$newusername' where username='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update profile set username='$newusername',dppath='$path' where username='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update posts set username='$newusername' where username='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update report set username='$newusername' where username='$username'";
                    $res = mysqli_query($conn,$query);
                    $query = "update reportuser set username='$newusername' where username='$username'";
                    $res = mysqli_query($conn,$query);
                
                    rename('./profilepictures/'.$username,'./profilepictures/'.$newusername);
                    $_SESSION['username'] = $newusername;
                    $_SESSION['profileupdated'] = "Your username successfully updated..!";
                    header("Location:/Febina/Members-Portal/editprofile");
                }
            }
            else
            {
                $_SESSION['profileupdatefailure'] = "Username already exists , try another username.";
                header("Location:/Febina/Members-Portal/editprofile");
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
            header("Location:/Febina/Members-Portal/editprofile");
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
            $query = "update profile set about = '$about' where username = '$username'";
            $result = mysqli_query($conn,$query);
            $_SESSION['profileupdated'] = "Your about successfully updated..!";
            header("Location:/Febina/Members-Portal/editprofile");
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
            header("Location:/Febina/Members-Portal/editprofile");
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
            header("Location:/Febina/Members-Portal/editprofile");
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
            header("Location:/Febina/Members-Portal/editprofile");
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
                header('Location: /Febina/Members-Portal/forgetpassword');
            }
            else
            {
                $otptosend = rand(99999,999999);
                $to = $_POST['email'];
                $_SESSION['email'] = $_POST['email'];
                $subject = "Email Verification";
                $message = "Hello sir/mam your OTP for email verifivation is ".$otptosend;
                $headers = "From: swapnil.febina1@gmail.com";
                
                if(mail($to,$subject,$message,$headers))
                {

                    $_SESSION['otp'] = $otptosend;
                    $_SESSION['email'] = $to;
                    $_SESSION['forgetpasswordotpsuccess'] = "success";
                    header('Location: /Febina/Members-Portal/forgetpassword');
                }
                else
                {
                    $_SESSION['forgetpasswordfailure'] = "OTP not send..! Please try again.";
                    header('Location: /Febina/Members-Portal/forgetpassword');
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
                header("Location: /Febina/Members-Portal/forgetpassword");
            }
            else
            {
                $_SESSION['forgetpasswordfailure'] = "Mismatch OTP..! Please try again.";
                header('Location: /Febina/Members-Portal/forgetpassword');
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
                $newpassword = $_POST['newpassword'];
                $email =  $_SESSION['email'];
                $query = "update user set password = '$newpassword' where email = '$email'";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $_SESSION['resetpasswordsuccess'] = "Your reset password successfully done. Now you can signin.";
                    unset($_SESSION['email']);
                    header("Location:/Febina/Members-Portal/signin");
                }
                else
                {
                    $_SESSION['resetpasswordfailure'] = "Unable to reset password please try again.";
                    unset($_SESSION['email']);
                    header("Location: /Febina/Members-Portal/forgetpassword");
                }
            }
            if(isset($_POST['username']))
            {
                $newpassword = $_POST['newpassword'];
                $username = $_POST['username'];
                $query = "update user set password = '$newpassword' where username = '$username'";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $_SESSION['changepasswordsuccess'] = "Your password changed successfully.";
                    header("Location:/Febina/Members-Portal/editprofile");
                }
                else
                {
                    $_SESSION['changepasswordfailure'] = "Unable to reset password please try again.";
                    header("Location: /Febina/Members-Portal/editprofile");
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
                    header("Location: /Febina/Members-Portal/admin");
                } 
                else 
                {
                    $_SESSION['adminloginfailure'] = "Unable to login check your username or password";
                    header("Location: /Febina/Members-Portal/adminlogin");
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
            header('Location: /Febina/Members-Portal/adminlogin');
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
                    $message = "Hello sir/mam your VA for Febina community is ".$newadharno;
                    $headers = "From: swapnil.febina1@gmail.com";
                    
                    if(mail($to,$subject,$message,$headers))
                    {
                        $_SESSION['newvakeysuccess'] = "New VA key added successfully..!";
                        header('Location: /Febina/Members-Portal/admin');
                    }
                }
            }
            else
            {
                $_SESSION['newadharnofailure'] = "This adhar number is already in use please enter another one";
                header('Location: /Febina/Members-Portal/admin');
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
            header('Location: /Febina/Members-Portal/admin');
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          Add or Remove favourit
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['uname']))
        {
            $username = $_POST['username'];
            $uname = $_POST['uname'];
            $name = $_POST['name'];
            $query = "select * from favourit where username='$username' and uname='$uname'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)==0)
            {
                $query = "insert into favourit(name,username,uname) values('$name','$username','$uname')";
                $result = mysqli_query($conn,$query);
                header("Location:/Febina/Members-Portal/profile/".$uname);
            }
            else
            {
                $query = "delete from favourit where username='$username' and uname='$uname'";
                $result = mysqli_query($conn,$query);
                header("Location:/Febina/Members-Portal/profile/".$uname);
            }
        }
    }
?>