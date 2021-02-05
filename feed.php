<?php
    session_start();
    include('./database/db.php');
    $query = "select * from posts";
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
?>

    <main>

        <div class="jumbotron feed-top-section">

        </div>

        <div class="jumbotron feed-body-section">
            <center>
                <h1 style="padding: 30px 0;">Latest Posts</h1>
            </center>
            <div class="container feed-cards">
            <?php

                if ($res)
                {
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $post = '
                        <div class="card mb-3 post-card">
                            <div class="row g-0">
                                <div class="post-img col-md-4">
                                    <img src="demo.jpg" alt="Post Image">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">'.$row['posttitle'].'</h5>
                                        <p class="card-text">';
                            $p = "";
                            if (strlen($row['post'])>= 80)
                            {
                                for ($i = 0; $i < 80; $i++)
                                {
                                    $p .= $row['post'][$i];
                                }
                                $p .= ".....";
                            }
                            else
                            {
                                for ($i = 0; $i < strlen($row['post']); $i++)
                                {
                                    $p .= $row['post'][$i];
                                }
                                for ($i = 80 - strlen($row['post']); $i > 0; $i--)
                                {
                                    $p .= "";
                                }
                            }
                            $post .= $p.'</p>
                                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>            
                        ';
                        echo $post;
                    }
                }
            ?>
        </div>


    </main>

<?php
    include('footer.php');
?>