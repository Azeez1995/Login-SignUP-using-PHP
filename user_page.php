<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

$userName = $_SESSION['user_name'];
$select = "SELECT image FROM user_form WHERE name = '$userName'";

// Execute the query and fetch the result
$result = mysqli_query($conn, $select);
if ($result && mysqli_num_rows($result) > 0) {
   $row = mysqli_fetch_assoc($result);
   $userImage = $row['image'];
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>user page</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="./style.css">

</head>
<body>
    
<div class="container">

   <div class="content">
      <h3>Hi, <span>user</span></h3>
      <span><img src="<?php echo $userImage; ?>" style="height:100px; width:100px;"></span>
      <h1>welcome <span><?php echo $_SESSION['user_name'] ?></span></h1>
      <p>This Is An User Page</p>
      <a href="login_form.php" class="btn">login</a>
      <a href="record.php" class="btn">Update</a>
      <a href="logout.php" class="btn">logout</a>
   </div>

</div>

</body>
</html>