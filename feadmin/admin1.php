<?php
include('adminheader.php');
include "./database/db.php";
$duplicateadhar = false;
$success = false;
$adharremoved = false;
$userremoved = false;
$profileremoved = false;
$postremoved = false;
$postdeleted = false;
session_start();
if (isset($_SESSION['adminstatus'])) 
{
} 
else 
{
    echo ("<script>
            var answer = alert(\"You are not logged in please login first\");
            </script>");

    $answer = "<script>
        window.write(answer);
        ";
        if ($answer) {
            echo("<script>window.location.replace(\"./adminlogin\");</script>");
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
    $logout = $_POST['logout1'];
    if ($logout == "1") 
    {
        unset($_SESSION['status1']);
        echo ("<script>window.location.replace(\"/Febina/Community/adminlogin\");</script>");
    } 
    else 
    {
        if(!isset($_POST['removeuser']))
        {
            if(isset($_POST['adharno']))
            {
                $adhar = $_POST['adharno'];

                $query = "select * from adharno";

                $result = mysqli_query($conn, $query);

                if (!$result) {
                    echo "error..";
                } else {
                    while ($row = $result->fetch_assoc()) {
                        if ($adhar == $row["adhar"]) {
                            $duplicateadhar = true;
                            break;
                        }
                    }
                    if ($duplicateadhar == true) {
                    } else {
                        $query = "insert into adharno(adhar,valid) values('$adhar','0')";

                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            die("Error : " . mysqli_errno($conn));
                        } else {
                            $success = true;
                        }
                    }
                }
            }
        }
        else
        {
            if(isset($_POST['removeuser']))
            {
                $removeuser = $_POST['removeuser'];
                $removeusername = $_POST['removeusername'];
                $issetpost = 0;
                $issetprofile = 0;

                $query = "select * from posts where username = '$removeusername'";
                $result = mysqli_query($conn,$query);
                while($row = $result->fetch_assoc())
                {
                    $issetpost = $row['postid'];
                }
                if($issetpost>0)
                {
                    $query = "delete from posts where username = '$removeusername'";
                    $result = mysqli_query($conn,$query);
                    if($result)
                    {
                        $postremoved = true;
                    }
                    else
                    {
                        die("Error :".mysqli_error($conn));
                    }
                }

                $query = "select * from profile where username = '$removeusername'";
                $result = mysqli_query($conn,$query);
                while($row = $result->fetch_assoc())
                {
                    $issetprofile = $row['isset'];
                }
                if($issetprofile>0)
                {
                    $query = "delete from profile where username = '$removeusername'";
                    $result = mysqli_query($conn,$query);
                    if($result)
                    {
                        $profileremoved = true;
                    }
                    else
                    {
                        die("Error :".mysqli_error($conn));
                    }
                }

                $query = "delete from user where username = '$removeusername'";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $userremoved = true;
                }
                else
                {
                    die("Error :".mysqli_error($conn));
                }

                $query = "delete from adharno where adhar = '$removeuser'";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    $adharremoved = true;
                }
                else
                {
                    die("Error :".mysqli_error($conn));
                }
            }
        }
        if(isset($_POST['deletepostid']))
        {
            $reportdeletepostid = $_POST['deletepostid'];
            $query = "delete from report where postid = '$reportdeletepostid'";
            $result = mysqli_query($conn,$query);

            $query = "delete from reportuser where postid = '$reportdeletepostid'";
            $result = mysqli_query($conn,$query);

            $query = "delete from posts where postid = '$reportdeletepostid'";
            $result = mysqli_query($conn,$query);
            
            if($result)
            {
                $postdeleted = true;
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <title>Admin Panel</title>

    <script>
        function validate() {
                               var adhar = document.getElementById('adharno').value;

                               if (adhar == "") {
                                   alert("please fill all the details....");
                                   return false;
                               }
                           }
    </script>
</head>

<body>
    <?php
    if ($duplicateadhar) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error...!</strong> This adhar number is already used please try with another one.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($success) 
    {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success...!</strong> Member\'s adhar number successfully added.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
      if ($adharremoved) 
      {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success...!</strong> Member successfully removed.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($userremoved) 
      {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success...!</strong> Member successfully removed.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($profileremoved) 
      {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success...!</strong> Member successfully removed.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($postremoved) 
      {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success...!</strong> Member successfully removed.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if ($postdeleted) 
      {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success...!</strong> Post successfully removed.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>

    <div class="container">
        
        <form class="mt-5" action="/Febina/Community/admin" method="POST" onsubmit="return validate()">
            <div class="mb-3">
                <label for="adharno" class="form-label">Enter adhar number here</label>
                <input type="text" class="form-control" id="adharno" name="adharno" aria-describedby="emailHelp">
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" type="submit">Add new member</button>
                <input type="hidden" name="logout" value="0">
            </div>
        </form>
        <form id="form" method="POST">
            <input type="hidden" name="logout1" value="0">
            <input type="hidden" name="removeuser" id="removeuser">
            <input type="hidden" name="removeusername" id="removeusername">
        </form>
        <form id="userprofile" method="POST">
            <input type="hidden" name="visituser" id="visituser">
        </form>
        <div class="container my-5">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Member name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Remove</th>
                        <th scope="col">Visit</th>
                    </tr>
                </thead>
                <?php
                    $query = "select * from user";
                    $result = mysqli_query($conn,$query);
                    $sno = 0;
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $sno++;
                        echo"
                                <tr>
                                    <th scope='row'>".$sno."</th>
                                    <td>".$row['name']."</td>
                                    <td>".$row['username']."</td>
                                    <td>
                                        <button type=\"button\" id=".$row['seckey']." class=\"remove btn btn-primary btn-sm\">Remove</button>
                                    </td>
                                    <td>
                                        <button type=\"button\" class=\"visit btn btn-primary btn-sm\">Visit Profile</button>
                                    </td>
                                </tr>";
                }
                ?>
            </table>
        </div>
        <div class="d-grid gap-2 mt-3">
            <a class="btn btn-primary" href="/Febina/Community/viewtodaysposts" role="button">View Today's Posts</a>
        </div>
        <div class="container my-5">
            <table class="table" id="myTable1">
                <thead>
                    <tr>
                        <th scope="col">Post id</th>
                        <th scope="col">Post Title</th>
                        <th scope="col" hidden>Post</th>
                        <th scope="col">Report Count</th>
                        <th scope="col">View</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <?php
                    $query = "select * from report order by reportcount desc";
                    $result = mysqli_query($conn,$query);
                    $sno = 0;
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $sno++;
                        echo"
                                <tr>
                                    <td>".$row['postid']."</td>
                                    <td>".$row['posttitle']."</td>
                                    <td hidden>".$row['post']."</td>
                                    <td>".$row['reportcount']."</td>
                                    <td>
                                        <button type=\"button\" id=".$row['postid']." class=\"modalbutton btn btn-primary btn-sm\" data-bs-toggle=\"modal\" data-bs-target=\"#staticBackdrop\">
                                        View Post
                                        </button>
                                    </td>
                                    <td>
                                    <button type=\"button\" class=\"deletepost btn btn-primary btn-sm\">Delete</button>
                                    </td>
                                </tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalbody">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <form id="reportedpost" method="POST">
        <input type="hidden" name="deletepostid" id="deletepostid">
        <input type="hidden" name="logout1" value="0">
    </form>
    <?php include('footer.php'); ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        var remove = document.getElementsByClassName('remove');
            Array.from(remove).forEach((element) => {
                element.addEventListener("click", (e) => {
                    removeuser.value = e.target.id;
                    removeusername.value = e.target.parentNode.parentNode.getElementsByTagName("td")[1].innerText;
                    form.action = "./admin";
                    document.getElementById("form").submit();
                })
            })
    </script>
    <script>
            var visit = document.getElementsByClassName('visit');
            Array.from(visit).forEach((element) => {
                element.addEventListener("click", (e) => {
                    visituser.value = e.target.parentNode.parentNode.getElementsByTagName("td")[1].innerText;
                    userprofile.action = "/Febina/Members-Portal/adminprofilevisit1.php/" + visituser.value;
                    document.forms['userprofile'].submit();
                })
            })
    </script>
    <script>
            $(document).ready(function () {
                $('#myTable').DataTable();
            });
    </script>
    <script>
            $(document).ready(function () {
                $('#myTable1').DataTable();
            });
    </script>
    <script>
            var modal = document.getElementsByClassName('modalbutton');
            Array.from(modal).forEach((element) => {
                element.addEventListener("click", (e) => {
                    staticBackdropLabel.innerText = e.target.parentNode.parentNode.getElementsByTagName("td")[1].innerText;
                    modalbody.innerText = e.target.parentNode.parentNode.getElementsByTagName("td")[2].innerText;
                })
            })
    </script>
    <script>
        var deletepost = document.getElementsByClassName('deletepost');
            Array.from(deletepost).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log(e.target.parentNode.parentNode.getElementsByTagName("td")[0].innerText);
                    deletepostid.value = e.target.parentNode.parentNode.getElementsByTagName("td")[0].innerText;
                    console.log(deletepostid.value);
                    reportedpost.action = "/Febina/Members-Portal/admin1.php";
                    document.getElementById("reportedpost").submit();
                })
            })
    </script>
</body>

</html>