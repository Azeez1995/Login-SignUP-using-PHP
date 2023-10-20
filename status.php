<?php

@include 'config.php';

$id=$_GET['id'];
$status=$_GET['status'];

$query="UPDATE user_form set status=$status where id=$id";

mysqli_query($conn, $query);

header('location:record.php');


?>