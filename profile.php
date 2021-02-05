<?php
    session_start();
    if (!isset($_SESSION['status']))
    {
        header('Location: signin.php');
    }
    include ('header.php');

    include ('./database/db.php');
    
    if(isset($_SESSION['postededitsuccessfully']))
    {
        echo '
        <script>
            swal("Congratulations..!", "'.$_SESSION['postededitsuccessfully'].'", "success");
        </script>
        ';
        unset($_SESSION['postededitsuccessfully']);
    }
    $query = "select * from profile where username='".$_SESSION['username']."'";
    $result = mysqli_query($conn,$query);
    
?>
    <main>
        <?php
        if ($result)
        {
            $row = mysqli_fetch_assoc($result);
        ?>
        <div class="jumbotron profile-jumbotron">
            <div class="container">
                <div class="profile-section">
                    <div class="profile-img">
                        <img style="max-width:100%; min-height:190px; max-height:200px; border-radius:50%;" src="<?php echo $row['dppath']; ?>" alt="">
                    </div>
                    <div class="profile-details">
                        <h1><?php echo $row['name']; ?></h1>
                        <small><?php echo $row['username']; ?></small>
                        <p>
                        <br>
                        <?php echo $row['about']; ?>
                        </p>
                        <a href="<?php echo $row['fblink']; ?>"> <span class="mdi mdi-facebook" style="color:black; font-size: 2em;"></span></a>
                        <a href="<?php echo $row['instalink']; ?>"> <span class="mdi mdi-instagram" style="color:black; font-size: 2em;"></span></a>
                        <a href="#"> <span class="mdi mdi-linkedin" style="color:black; font-size: 2em;"></span></a>
                        <a href="#"> <span class="mdi mdi-youtube" style="color:black; font-size: 2em; "></span></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <div class="jumbotron feed-body-section">
            <center>
                <h1 style="padding: 30px 0;">Latest Posts </h1>
            </center>

            <div class="container feed-cards">
                <?php
                    $query1 = "select * from posts where username='".$_SESSION['username']."'";
                    $result1 = mysqli_query($conn,$query1);
                    
                    if ($result1)
                    {
                        while ($row1 = mysqli_fetch_assoc($result1))
                        {
                ?>
                <div class="card mb-3 post-card">
                    <div class="row g-0">
                        <div class="post-img col-md-4">
                            <img src="https://images.pexels.com/photos/217250/pexels-photo-217250.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="Post Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row1['posttitle']; ?></h5>
                                <p class="card-text">
                                <?php 
                                    $post = "";
                                    if (strlen($row1['post'])>= 80)
                                    {
                                        for ($i = 0; $i < 80; $i++)
                                        {
                                            $post .= $row1['post'][$i];
                                        }
                                        $post .= ".....";
                                    }
                                    else
                                    {
                                        for ($i = 0; $i < strlen($row1['post']); $i++)
                                        {
                                            $post .= $row1['post'][$i];
                                        }
                                    }
                                    echo $post;
                                ?></p>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                            <form action="/Febina/Members-Portal/editpost" method="post">
                            <input type="hidden" name="postid" value="<?php echo $row1['postid']; ?>">
                            <button type="submit" class="btn btn-primary" name="editposts">Edit Post</button>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                        }
                    }
                ?>
            </div>

        </div>


    </main>

<?php
    include('footer.php');
?>