<?php

$conn = mysqli_connect('localhost','root','','user_db');



if (isset($_POST['email'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $id = $_POST['id'];

   


    

    $data = mysqli_query($conn, "UPDATE user_form set name='$name', email='$email' where id='$id' ");

    if($data){
        echo 'data updated';
    }
}

?>