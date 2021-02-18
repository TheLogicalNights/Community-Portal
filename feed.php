<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include('./database/db.php');
    $isBirthdate = false;
    $fname = "";
    $query = "select * from profile where username='".$_SESSION['username']."'";
    $result1 = mysqli_query($conn,$query);
    if ($result1)
    {
        $row = mysqli_fetch_assoc($result1);
        $birthDate = $row['birthdate'];
        $fname = $row['name'];
        $time = strtotime($birthDate);
        if(date('m-d') == date('m-d', $time)) 
        {
            $isBirthdate = true;
        }
    }
    $query = "select * from posts order by posted_at desc";
    $res = mysqli_query($conn,$query);
    include('header.php');
    if(isset($_SESSION['postedsuccessfully']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['postedsuccessfully'].'", "success");
        </script>
        ';
        unset($_SESSION['postedsuccessfully']);
    }

    if(isset($_SESSION['setupprofilsuccessfully']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['setupprofilsuccessfully'].'", "success");
        </script>
        ';
        unset($_SESSION['setupprofilsuccessfully']);
    }
    if(isset($_SESSION['postededitsuccessfully']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['postededitsuccessfully'].'", "success");
        </script>
        ';
        unset($_SESSION['postededitsuccessfully']);
    }
    if(isset($_SESSION['reportsuccess']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['reportsuccess'].'", "success");
        </script>
        ';
        unset($_SESSION['reportsuccess']);
    }
    if(isset($_SESSION['reportfailure']))
    {
        echo '
        <script>
            swal("Error..!", "'.$_SESSION['reportfailure'].'", "error");
        </script>
        ';
        unset($_SESSION['reportfailure']);
    }
    if(isset($_SESSION['postdeleted']))
    {
        echo '
        <script>
            swal("Deleted..!", "'.$_SESSION['postdeleted'].'", "success");
        </script>
        ';
        unset($_SESSION['postdeleted']);
    }
    if(isset($_SESSION['postnotdeleted']))
    {
        echo '
        <script>
            swal("Error..!", "'.$_SESSION['postnotdeleted'].'", "error");
        </script>
        ';
        unset($_SESSION['postnotdeleted']);
    }
    
    
?>
<style>
@keyframes example {
 
}
.main-content :hover
{
    outline-offset: -4px;
    transform: scale(1.01);
}
.dash
{
    border-top: 2px solid goldenrod;
}
</style>
    <main>
            <center>
                <h1 style="padding: 30px 0;">Latest Posts</h1>
            </center>
        <?php
            if ($isBirthdate)
            {
        ?>
        <div class="container mt-3">
            <div class="card mb-3 main-content" style="background-color:#c70000 ; color:goldenrod;border-style: solid;border-color:goldenrod;border-width:2px;animation-name:example;animation-duration:2s;">
                
                <div class="row g-0">
                    <div class="col-md-12">
                        <hr class="dash">
                        <div class="card-body" style="padding:20px;">
                            <h3 class="card-title text-center" style="font-family: 'Great Vibes', cursive;font-size:40px;">Happy Birthday <?php echo $fname; ?></h3>
                            <p class="card-text text-center" >A wish for you on your birthday, whatever you ask may you receive, whatever you seek may you find, whatever you wish may it be fulfilled on your birthday and always. Happy birthday! 
                            </p>
                            <p class="card-text text-white">- Febina Group</p>
                        </div>
                        <hr class="dash">
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <?php
            }
        ?>    

            <div class="container feed-cards" id="posts"></div>

        </div>
    </main>
    <script>
        input = document.getElementById('postdesc').value;
        console.log(input);
        var result =new Sanitizer().sanitizeToString(input);
        document.getElementById('postdesc').innerHTML = result;
    </script>
    
<?php
    include('footer.php');
?>