<?php

@include 'config.php';
$nameError = $emailError = $passwordError = $cpasswordError = '';
$validForm = false;
if (isset($_POST['submit'])) {

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "images/" . $filename;
    move_uploaded_file($tempname, $folder);


    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];
    //$image_name = $_POST['image_name'];



    // Check name field
    if (empty($name)) {
        $nameError = 'Name is required.';
    }

    // Check email field
    if (empty($email)) {
        $emailError = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Invalid email format.';
    }

    // Check password field
    if (empty($password)) {
        $passwordError = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $passwordError = 'Password must be at least 8 characters long.';
    }

    // Check confirm password field
    if (empty($cpassword)) {
        $cpasswordError = 'Confirm Password is required.';
    } elseif ($cpassword !== $password) {
        $cpasswordError = 'Passwords do not match.';
    }



    if ($nameError == '' && $emailError == '' && $passwordError == '' && $cpasswordError == '') {
        $validForm = true;
    }


    if ($validForm) {
        $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$password' ";

        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {

            $error[] = 'user already exist!';
        } else {

            if ($password != $cpassword) {
                $error[] = 'password not matched!';
            } else {
                $insert = "INSERT INTO user_form(name, email, password, image, user_type) VALUES('$name','$email','$password','$folder','$user_type')";
                mysqli_query($conn, $insert);
                header('location:login_form.php');
            }
        }
    }
};


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register form</title>

    <!-- custom css file link > -->
    <link rel="stylesheet" href="./style.css">

</head>

<body>

    <div class="form-container">

        <form action="" method="post" onsubmit=" validateForm(event)" enctype="multipart/form-data">
            <h3>register now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                };
            };
            ?>
            <input type="text" name="name" id="name" placeholder="Enter Your Name">
            <span id="nameError" style="color: red;"><?php echo $nameError; ?></span>

            <input type="email" name="email" id="email" placeholder="Enter Your Email">
            <span id="emailError" style="color: red;"><?php echo $emailError; ?></span>

            <input type="password" name="password" id="password" placeholder="Enter Your Password">
            <span id="passwordError" style="color: red;"><?php echo $passwordError; ?></span>

            <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Your Password">
            <span id="cpasswordError" style="color: red;"><?php echo $cpasswordError; ?></span>

            <input type="file" name="uploadfile">

            <select name="user_type">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
            <input type="submit" name="submit" value="register now" class="form-btn">
            <p>Already have an account? <a href="login_form.php" style="display: inline-block; padding: 5px 10px; background-color: #ff0000; color: #fff; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease-in-out;" onmouseover="this.style.backgroundColor='#006400'" onmouseout="this.style.backgroundColor='#ff0000'">Login now</a></p>




        </form>

        <script>
            function validateForm(event) {
                //event.preventDefault();

                let name = document.getElementById("name").value;
                let email = document.getElementById("email").value;
                let password = document.getElementById("password").value;
                let cpassword = document.getElementById("cpassword").value;

                let flag = true;

                // Reset error messages
                document.getElementById("nameError").textContent = "";
                document.getElementById("emailError").textContent = "";
                document.getElementById("passwordError").textContent = "";
                document.getElementById("cpasswordError").textContent = "";

                // Validate Name (Should not be empty)
                if (name === "") {
                    document.getElementById("nameError").textContent = "Name is Required";
                    flag = false;
                }

                // Validate Email
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    document.getElementById("emailError").textContent = "Invalid Email Format";
                    flag = false;
                }

                // Validate Password (At least 8 characters)
                if (password.length < 8) {
                    document.getElementById("passwordError").textContent = "Password should be at least 8 characters";
                    flag = false;
                }

                // Validate Confirm Password (Should match Password)
                if (password !== cpassword) {
                    document.getElementById("cpasswordError").textContent = "Passwords do not match";
                    flag = false;
                }

                if (flag) {
                    // If all validations pass, you can submit the form
                    document.getElementById("nameError").textContent = ""; // Clear any previous error message
                    document.getElementById("emailError").textContent = "";
                    document.getElementById("passwordError").textContent = "";
                    document.getElementById("cpasswordError").textContent = "";
                    document.forms[0].submit();
                }

                if (flag) {
                    return true;

                } else {
                    event.preventDefault();
                    return false;
                }
            }
        </script>


    </div>

</body>

</html>