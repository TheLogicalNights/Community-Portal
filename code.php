<?php
    session_start();


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
            $subject = "Email Verification";
            $message = "Hello sir/mam your OTP for email verifivation is ".$otptosend;
            $headers = "From: swapnil.febina1@gmail.com";
            
            if(mail($to,$subject,$message,$headers))
            {
                
                $_SESSION['otp'] = $otptosend;
                $_SESSION['email'] = $to;
              
                $_SESSION['otpsuccess'] = "success";
                header('Location: /Febina/Members-Portal/signup.php');
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
                header('Location: /Febina/Members-Portal/signup.php');
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
            $srno = 0;

            $query = "select * from adharno where adhar = '$key'";

            $result = mysqli_query($conn, $query);

                if (!$result) 
                {
                    echo "error : 5";
                } 
                else 
                {
                    while ($row = $result->fetch_assoc()) 
                    {
                        if ($row['valid'] == "0" || $row['valid'] == "1") 
                        {
                            $present = true;
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

                            if (!$result) 
                            {
                                
                            } 
                            else 
                            {
                                $success = true;   
                                unset($_SESSION['email']);
                                header("Location: index.php");
                            }
                        }
                     }
                }
                else
                {
                    $_SESSION['RegisterFailure'] = "This VA key is not generated, please contact to admin.";
                }
            }
    
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //
        //          User Login
        //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
?>