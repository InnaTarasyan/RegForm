<html>
<head>
    <link rel="stylesheet" type="text/css" href="myStyles.css">
    <!--<script src="myScript.js"></script>-->
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}
error_reporting(0);
if(isset($_SESSION['user_id']))
{
    echo "<div class='centerText title'>".$_SESSION['first_name']."</div>";
    echo "<div class='centerText title'>".$_SESSION['last_name']."</div>";
    echo "<div class='centerText title'><img class='simpleImage' src='images/". $_SESSION['image_name']."'></div>";
}
?>
<div class="rightTopCorner"><a href="myLogOut.php">Log Out</a></div>
<!--
<div class="rightTopCorner">
    <select id="drop_down" onchange="logOut(this)">
        <option value="" ></option>
        <option value="logout" >Log Out</option>
    </select>
</div>
-->

</body>
</html>