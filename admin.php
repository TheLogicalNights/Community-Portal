<?php
    session_start();
    include "./database/db.php";
    include('adminheader.php');
    if (!isset($_SESSION['adminstatus']))
    {
        header('Location: /Febina/Members-Portal/adminlogin');
    }
    if(isset($_SESSION['newadharnofailure']))
    {
        echo '
        <script>
            swal("Oops..!", "'.$_SESSION['newadharnofailure'].'", "error");
        </script>
        ';
        unset($_SESSION['newadharnofailure']);
    }
    if(isset($_SESSION['newvakeysuccess']))
    {
        echo '
        <script>
            swal("Yeahh..!", "'.$_SESSION['newvakeysuccess'].'", "success");
        </script>
        ';
        unset($_SESSION['newvakeysuccess']);
    }
    if(isset($_SESSION['userdeletedsuccess']))
    {
        echo '
        <script>
            swal("Yeahh..!", "'.$_SESSION['userdeletedsuccess'].'", "success");
        </script>
        ';
        unset($_SESSION['userdeletedsuccess']);
    }
?>
<div class="jumbotron usp-section mt-5">
    <div class="container mt-5">
        <form class="mt-5" action="/Febina/Members-Portal/code" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Member's email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="adharno" class="form-label">Member's adhar number</label>
                <input type="text" class="form-control" id="adharno" name="adharno" minlength="12" maxlength="12" aria-describedby="emailHelp">
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" name="addvakey" type="submit">Add new VA key</button>
            </div>
        </form>
    </div>
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
                                    <form action=\"/Febina/Members-Portal/code\" method=\"POST\">
                                        <input type=\"hidden\" name=\"username\" value=\"".$row['username']."\">
                                        <button type=\"submit\" name=\"removeuser\" class=\"remove btn btn-primary btn-sm\">Remove</button>
                                    </form>
                                </td>
                                <td>
                                <form action='/Febina/Members-Portal/code' method='POST'>
                                    <input type='hidden' name='username' id='visit' value=".$row['username'].">
                                    <button type='submit' name='adminVisitMember' class='visit btn btn-primary'>Visit</button>
                                </form>
                                </td>
                            </tr>";
            }
            ?>
        </table>
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
<?php
    include('footer.php');
?>