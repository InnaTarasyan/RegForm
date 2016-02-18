<html>
<head>
    <link rel="stylesheet" type="text/css" href="myStyles.css">
</head>
<body>
<div class="centerText">
<h1>Login</h1>
    <table class="center">
        <form action="login.php" method="POST">
            <tr>
                <td>
                    <label>E-Mail*: </label></td>
                <td>
                    <input id="email" type="text" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>Password*: </label>
                </td>
                <td>
                    <input id="password" type="password" name="password" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" />
                </td>
            </tr>

            <tr >
                <td >
                    <input  type="submit" name="submit" value="LOGIN" />
                </td>
            </tr>

        </form>
    </table>
</div>

<div class="centerText">
    <?php

    session_start();
    error_reporting(0);

    if (isset($_POST["submit"])) {

        $email = $_POST['email'];
        $check=1;
        $userErrors="";

        if(!$email)
        {
            $userErrors.= "Empty email<br>";
            $check=0;
        }
        $user_password = $_POST['password'];

        if(!$user_password)
        {
            $userErrors.="Empty Password<br/>";
            $check=0;
        }
        echo "<span class='error'>".$userErrors."</span>";
        if ($check==1) {

            $email = $_POST['email'];
            $user_password = $_POST['password'];
            $email = stripslashes($email);

            $server_name = "localhost";
            $username = "root";
            $password = "";
            $db_name = "users";

            $conn = new mysqli($server_name, $username, $password, $db_name);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                $sql = "SELECT * FROM person where email='" . $email . "' and password='" . md5($user_password) . "'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if($rowCount==0)
                {
                    echo "<span class='error'>Wrong Email/Password.</color>";
                }
                else {
                    while ($row = mysqli_fetch_array($result)) {
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['password'] = MD5($row['password']);
                        $_SESSION['image_name'] = $row['image_name'];

                        header("Location: http://localhost/test/myProfile.php");
                    }
                }
                mysqli_close($conn);
            }
        }
    }
    ?>
</div>
</body>
</html>