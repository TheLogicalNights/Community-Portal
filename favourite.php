<?php
    session_start();
    include "./config/config.php";
    include "./config/userexist.php";
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('header.php');
    include('./database/db.php');
    $query = "select * from favourit where username = '".$_GET['username']."'";
    $result = mysqli_query($conn,$query);
    $sno = 0;
?>

<main style="background:url('<?php echo $BASE_URL; ?>assets/img/banner.jpg')">
    <div class="jumbotron usp-section" style="padding:80px 0 !important;">
        <div class="container">
            <center>
                <h1>Favourites</h1>
                <br>
            </center>
            <div>
                <div class="container mt-3">
                        <table class='table mt-2' id="myTable2">
                                        <thead>
                                            <tr>
                                                <th scope='col'>Name</th>
                                                <th scope='col'>Username</th>
                                                <th scope='col'>Visit</th>
                                            </tr>
                                        </thead>
                        <?php
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    $sno++;
                        ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['uname']; ?></td>
                                            <td>
                                                <form action='<?php echo $BASE_URL; ?>code' method='POST'>
                                                    <input type='hidden' name='username' id='visit' value=<?php echo $row['uname']; ?>>
                                                    <button type='submit' name='VisitMember' class='visit btn btn-primary'>Visit</button>
                                                </form>
                                            </td>
                                        </tr>
                        <?php
                                }
                        ?>
                        </table>
                   
                </div>
            </div>
        </div>
    </div>
</main>
    <script type="text/javascript">
        
    </script>
<?php
    include('footer.php');
?>

