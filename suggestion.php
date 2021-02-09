<?php
    session_start();
    include ('./database/db.php');
     $_GET['item'];
     $query = "";

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
?>
                