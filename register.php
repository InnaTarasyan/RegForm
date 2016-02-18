<html>
<head>
    <link rel="stylesheet" type="text/css" href="myStyles.css">
</head>
<body>
<div class="centerText">
    <h1>Registration</h1>
    <table  class="center">
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <tr>
                <td>
                    <label>First Name*: </label>
                </td>
                <td>
                    <input id="user_name" type="text" name="first_name"  value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" />
                </td>

            </tr>

            <tr><td><label>Last Name: </label></td>
                <td><input id="last_name" type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /></td>

            </tr>

            <tr>
                <td>
                    <label>E-Mail*: </label></td>
                <td>
                    <input id="email" type="text" name="email"  value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                </td>

            </tr>
            <tr>
                <td>
                    <label>Password*: </label>
                </td>
                <td>
                    <input id="password1" type="password" name="password1" value="<?php if (isset($_POST['password1'])) echo $_POST['password1']; ?>" />
                </td>

            </tr>

            <tr><td><label>Confirm Password*: </label></td>
                <td>
                    <input id="password2" type="password" name="password2" value="<?php if (isset($_POST['password2'])) echo $_POST['password2']; ?>" />
                </td>

            </tr>


            <tr>
                <td>Upload Image*: </td>
                <!--<input type="hidden" name="size" value="350000">-->
                <td><input type="file" name="image" ></td>

            </tr>

            <tr >
                <td >
                    <input  type="submit" name="submit" value="SAVE" />
                </td>
            </tr>
        </form>
    </table>

</div>


<div  class="centerText">
<?php
error_reporting(0);
$userErrors="";
$check=1;
if (isset($_POST["submit"])) {
$first_name = $_POST['first_name'];
if(!$first_name)
{
    $userErrors.= "Input First Name<br/>";
    $check=0;
}
$last_name = $_POST['last_name'];
    if(!$last_name)
    {
        $userErrors.= "Input Last Name<br/>";
        $check=0;
    }

    $email = $_POST['email'];
    if(!$email)
    {
        $userErrors.= "Input Email<br/>";
        $check=0;
    }
    else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $userErrors .= "Invalid email format<br/>";
            $check=0;
        }
    }

    $user_password = $_POST['password1'];

    if(!$user_password)
    {
        $userErrors.= "Input Password<br/>";
        $check=0;
    }

    $conf_password= $_POST['password2'];

    if(!$conf_password)
    {
        $userErrors.= "Confirm Password<br/>";
        $check=0;
    }

    if($user_password && $conf_password && !($user_password==$conf_password))
    {
        $userErrors.= "Passwords do not match<br/>";
        $check=0;
    }

    if ($user_password && (!preg_match('/([a-z]{1,})/', $user_password))) {

        $userErrors.="Password does not contain lowercase<br>";
        $check=0;
    }

    if ($user_password && (!preg_match('/([A-Z]{1,})/', $user_password))) {

        $userErrors.="Password does not contain uppercase<br>";
        $check=0;
    }

    if ($user_password && (!preg_match('/([\d]{1,})/', $user_password))) {

        $userErrors.="Password does not contain digit<br>";
        $check=0;
    }

    if ($user_password && (strlen($user_password) < 5)) {

        $userErrors.="Password length is less than 5.<br>";
        $check=0;

    }

    if(isset($_FILES['image'])) {

    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

    $expensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $expensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 2 MB';
    }

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, "images/" . $file_name);
        //  echo "Success"." ".$file_name;


    } else {
        //print_r($errors);
        $userErrors.= "Select Image<br/>";
    }

    echo "<span class='error'>".$userErrors."</span>";

    $server_name = "localhost";
    $username = "root";
    $password = "";
    $db_name = "users";

    $conn = new mysqli($server_name, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

       if($check==1) {

           $sql = "INSERT INTO person (first_name, last_name, email,password,image_name)
VALUES ('$first_name', '$last_name', '$email',MD5('$user_password'),'$file_name')";

           if ($conn->query($sql) === TRUE) {
               //echo "registered";
           } else {
               //echo "Error: " . $sql . "<br>" . $conn->error;
           }
       }
    }

    $conn->close();
}

}
?>
</div>
</body>
</html>
