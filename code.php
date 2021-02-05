<?php
    session_start();
    include "./database/db.php";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          OTP Generation
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_POST['generateotp']))
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
            
            if($otp == $otpbyuser)
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
        if (isset($_SESSION['email']))
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

            if (!$result) 
            {
                $_SESSION['RegisterFailure'] = "This VA key is not generated yet please contact admin.";
            } 
            else 
            {
                while ($row = $result->fetch_assoc()) 
                {
                    if ($row['valid'] == "0" || $row['valid'] == "1") 
                    {
                        $present = true;
                    }
                    else
                    {
                        $_SESSION['RegisterFailure'] = "This VA key is not generated yet please contact admin.";
                    }
                }
            }

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
                                header('Location: /Febina/Members-Portal/signup');   
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
            $query = "select * from posts";

            $result = mysqli_query($conn,$query);
            while($row = $result->fetch_assoc())
            {
                $postid = $row['postid'];
            }
            $postid = $postid + 1;
            $target_dir = "./postuploads/$postid/";
            $target_file = $target_dir . basename($_FILES["postimg"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $posttitle = $_POST['posttitle'];
            $postbody = $_POST['postbody'];
            date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d h:i:s");
            $name = $_SESSION['name'];
            $username = $_SESSION['username'];
            
            if(isset($_FILES['postimg']) && !empty($_FILES['postimg']['name']))
            {
                //check if folder is exists or not if not then create it
                if (!file_exists($target_dir)) 
                { 
                    mkdir($target_dir, 0777, true);
                }
                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["postimg"]["tmp_name"]);
                if($check !== false) 
                {
                  //  echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } 
                else 
                {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) 
                {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) 
                {
                    echo "Sorry, your file was not uploaded.";

                } 
                // if everything is ok, try to upload file
                else  
                {
                        if (move_uploaded_file($_FILES["postimg"]["tmp_name"], $target_file)) 
                        {
                            echo $name." ";
                            echo $username." ";
                            echo $posttitle." ";
                            echo $postbody." ";
                            echo $date." ";
                            echo $target_file." ";
                            $query = "insert into posts(name,username,posttitle,post,postid,posted_at,img_path) values('$name','$username','$posttitle','$postbody','$postid','$date','$target_file')";
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
                $target_file = "-";
                $query = "insert into posts(name,username,posttitle,post,postid,posted_at,img_path) values('$name','$username','$posttitle','$postbody','$postid','$date','$target_file')";
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
            $query = "select * from user where username = '$username' and password = '$password'";

            $result = mysqli_query($conn, $query);
            
            if ($result) 
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
                    //header("Location: /Febina/Community/setupprofile");
                }
                else
                {
                    header("location: /Febina/Members-Portal/feed");
                }
            } 
            else 
            {
                $_SESSION['loginfailure'] = "Invalid username, please try again...";
                header("location: /Febina/Members-Portal/signin");
            }
        }
                
    }
?>