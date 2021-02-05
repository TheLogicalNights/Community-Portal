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
            $target_dir = "postuploads/";
            $target_file = $target_dir . basename($_FILES["postimg"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $posttitle = $_POST['posttitle'];
            $postbody = $_POST['postbody'];

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) 
            {
                echo "File is an image - " . $check["mime"] . ".";
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
                            $query = "insert into posts values("                        
                    } 
                    else 
                    {
                        echo "Sorry, there was an error uploading your file.";
                    }
            }
        }
    }
?>