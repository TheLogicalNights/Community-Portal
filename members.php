<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('header.php');
    include('./database/db.php');
    $query = "select * from user where username in(select username from profile where isset=1)";
    $result = mysqli_query($conn,$query);
    $sno = 0;
?>
<div class="jumbotron usp-section" >
    <div class="container">
        <center>
            <h1>Members</h1>
        </center>
        <div class="cards-section">
            <div class="container">
                <div class="d-flex justify-content-start me-3">
                    <input type="text" onkeyup="getSuggestion(this.value)" autocomplete="off" style="width: 45%;" class="form-control" name="search" placeholder="Enter name">
                </div>
                <div id="data">
                    <table class='table mt-2' id='myTable'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Member name</th>
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
                                        <td><?php echo $row['username']; ?></td>
                                        <td>
                                            <form action='/Febina/Members-Portal/code' method='POST'>
                                                <input type='hidden' name='username' id='visit' value=<?php echo $row['username']; ?>>
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
    <script type="text/javascript">
        function getSuggestion(q)
        {
            $.ajax({
                type: "GET",
                url: "suggestion.php",
                data: {item:q},
                success:function(data){
                $("#data").html(data);
                }
            });
        
        }
    </script>
<?php
    include('footer.php');
?>

