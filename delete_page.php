<?php
  @include 'config.php';

  $id = $_GET['id'];

  $query = "DELETE FROM user_form WHERE id = '$id'";
  $data = mysqli_query($conn ,$query);

  if($data)
  {
    echo "<script>alert('Record Deleted')</script>";
    ?>
        <meta http-equiv="refresh" content="0;url=http://localhost/login/record.php">


        <?php
  }
  else{
    echo " Delete Failed";
  }
?>