<?php

session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
include "connection.php";

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($con, $_POST['Name']);
    $fid = mysqli_real_escape_string($con, $_POST['FID']);
  $email = mysqli_real_escape_string($con, $_POST['EmailId']);
  $password_1 = mysqli_real_escape_string($con, $_POST['Password']);
  $password_2 = mysqli_real_escape_string($con, $_POST['psw-repeat']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($fid)) { array_push($errors, "Faculty ID is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }
//array_push($errors,$username.$fid.$email.$password);
  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM faculty WHERE FID='$fid' LIMIT 1";
  $result = mysqli_query($con, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['FID'] === $fid) {
      array_push($errors, "Faculty ID already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO faculty VALUES('$username', '$fid', '$email', '$password')";
  	mysqli_query($con, $query);
  	$_SESSION['success'] = "You are now logged in";
      $_SESSION['username'] = $username;
      $_SESSION['fid'] = $fid;
      echo $username.$fid.$email.$password;
  	header('location: Faculty.php');
  }
}

    if(isset($_POST['login_user']))
    {
         $username = mysqli_real_escape_string($con,$_POST['RollNo']);
        $password = mysqli_real_escape_string($con,$_POST['Password']);
        
        if (empty($username)) { array_push($errors, "Faculty ID is required"); }
          if (empty($password)) { array_push($errors, "Password is required"); }
        
        if(count($errors) == 0) {
            $password = md5($password);
        $sql = "SELECT * FROM faculty WHERE FID='$username' AND Password='$password'";
        
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_assoc($result);
        
        if (mysqli_num_rows($result) == 1) {  
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['username'] = $user['Name'];
            $_SESSION['fid'] = $user['FID'];
            header("location: Faculty.php");
        }else {
            array_push($errors, "LoginId/password combination incorrect"); 
        }
        }
    }

?>