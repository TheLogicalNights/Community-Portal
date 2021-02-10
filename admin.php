<?php
    session_start();
    include('adminheader.php');
    if (!isset($_SESSION['adminstatus']))
    {
        header('Location: /Febina/Members-Portal/adminlogin');
    }
?>
<div class="jumbotron usp-section">
</div>
<?php
    include('footer.php');
?>