<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('header.php');
    include('./database/db.php');
?>
<div class="jumbotron usp-section">
    <div class="container">
        <center>
            <h1>Members</h1>
        </center>
        <div class="cards-section">
            <div class="container">
                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Member name</th>
                            <th scope="col">Username</th>
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
                            echo "
                                <tr>
                                    <td>".$row['name']."</td>
                                    <td>".$row['username']."</td>
                                    <td>
                                        <form action='/Febina/Members-Portal/code' method='POST'>
                                            <input type='hidden' name='username' id='visit' value=\"".$row['username']."\">
                                            <button type='submit' name='VisitMember' class='visit btn btn-primary'>Visit</button>
                                        </form>
                                    </td>
                                </tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
    include('footer.php');
?>