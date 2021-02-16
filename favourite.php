<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('header.php');
    include('./database/db.php');
    if (isset($_GET['username']))
    {
        $username = $_GET['username'];
    } 
    $query = "select * from favourit where username ='$username'";
    $result = mysqli_query($conn,$query);
?>
<main style="background:url('./assets/img/banner.jpg')">
    <div class="jumbotron usp-section" style="padding:80px 0 !important;">
        <div class="container">
            <center>
                <h1>Your Favourites</h1>
            </center>
            <div>
                <div class="container">
                    <div class="d-flex justify-content-start me-3">
                        <input type="hidden" name="username" id="username" value=<?php echo $username; ?> >
                        <input data-aos="fade-right" type="text" onkeyup="getSuggestion(this.value)" autocomplete="off" style="width: 45%;" class="form-control" name="search" placeholder="Enter name">
                    </div>
                    <div id="data">
                        <table class='table mt-2'>
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
                                  
                        ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['uname']; ?></td>
                                            <td>
                                                <form action='/Febina/Members-Portal/code' method='POST'>
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
    </div>
</main>
<script type="text/javascript">
        function getSuggestion(q)
        {
            username = document.getElementById('username').value;
            $.ajax({
                type: "GET",
                url: "suggestion.php",
                data: {user:q,uname:username},
                success:function(data){
                $("#data").html(data);
                }
            });
        
        }
    </script>
<?php
    include ('./footer.php');
?>