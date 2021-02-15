<?php
    session_start();
    include ('./database/db.php');
     $query = "";

    if (isset($_GET['item']))
    {
        if ($_GET['item'] == "" || $_GET['item'] == " ")
        {
            $query = "select * from user where username in(select username from profile where isset=1)";
        }
        else
        {
            $query = "select * from user where name REGEXP '^".$_GET['item']."' and username in(select username from profile where isset=1)";   
        }
                            $result = mysqli_query($conn,$query);
                            $sno = 0;
                            $ans = "<table class='table mt-2' id='myTable'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Member name</th>
                                            <th scope='col'>Username</th>
                                            <th scope='col'>Visit</th>
                                        </tr>
                                    </thead>";
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $sno++;
                                $ans .= "
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
                            $ans .= "</table>";
                            echo $ans;
    }
    if (isset($_GET['user']))
    {
    
        if ($_GET['user'] == "" || $_GET['user'] == " ")
        {
            $query = "select * from favourit where username ='".$_GET['username']."'";
        }
        else
        {
            $query = "select * from favourit where name REGEXP '^".$_GET['user']."' and username='".$_GET['username']."'";   
        }
                            $result = mysqli_query($conn,$query);
                            $sno = 0;
                            $ans = "<table class='table mt-2' id='myTable'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>Member name</th>
                                            <th scope='col'>Username</th>
                                            <th scope='col'>Visit</th>
                                        </tr>
                                    </thead>";
                            while($row = mysqli_fetch_assoc($result))
                            {
                                $sno++;
                                $ans .= "
                                    <tr>
                                        <td>".$row['name']."</td>
                                        <td>".$row['uname']."</td>
                                        <td>
                                            <form action='/Febina/Members-Portal/code' method='POST'>
                                                <input type='hidden' name='username' id='visit' value=\"".$row['username']."\">
                                                <button type='submit' name='VisitMember' class='visit btn btn-primary'>Visit</button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                            $ans .= "</table>";
                            echo $ans;
    }
?>
                