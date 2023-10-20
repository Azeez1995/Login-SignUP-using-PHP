<?php
@include 'config.php';

 $id = $_GET['id'];

 $query = "SELECT * FROM user_form where id='$id'";
 $data = mysqli_query($conn, $query);

 $total = mysqli_num_rows($data);
 $result = mysqli_fetch_assoc($data);

?>



<?php

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

   


    $query = "UPDATE user_form set name='$name', email='$email' where id='$id' ";

    $data = mysqli_query($conn, $query);


    if ($data) {
        echo "<script>alert('Record Updated')</script>";
        ?>
        <meta http-equiv="refresh" content="0;url=http://localhost/login/record.php">


        <?php
    } else {
        echo "Failed Update";
    }
};


?>