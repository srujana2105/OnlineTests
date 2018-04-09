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
    $rollno = mysqli_real_escape_string($con, $_POST['RollNo']);
  $email = mysqli_real_escape_string($con, $_POST['EmailId']);
    $semester = mysqli_real_escape_string($con, $_POST['Semester']);
  $password_1 = mysqli_real_escape_string($con, $_POST['Password']);
  $password_2 = mysqli_real_escape_string($con, $_POST['psw-repeat']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($semester)) { array_push($errors, "semester should be selected"); }
  if (empty($rollno)) { array_push($errors, "Rollno. is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE RollNo='$rollno' LIMIT 1";
  $result = mysqli_query($con, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['RollNo'] === $rollno) {
      array_push($errors, "Rollno already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO registration VALUES('$username', '$rollno', '$email', '$semester', '$password')";
  	mysqli_query($con, $query);
  	$_SESSION['success'] = "You are now logged in";
      $_SESSION['username'] = $username;
      $_SESSION['rollno'] = $rollno;
  	header('location: main.php');
  }
}

    if(isset($_POST['login_user']))
    {
         $username = mysqli_real_escape_string($con,$_POST['RollNo']);
        $password = mysqli_real_escape_string($con,$_POST['Password']);
        
        if (empty($username)) { array_push($errors, "Rollno. is required"); }
          if (empty($password)) { array_push($errors, "Password is required"); }
        
        if(count($errors) == 0) {
            $password = md5($password);
        $sql = "SELECT * FROM registration WHERE RollNo='$username' AND Password='$password'";
        
        $result = mysqli_query($con, $sql);
        $user = mysqli_fetch_assoc($result);
        
        if (mysqli_num_rows($result) == 1) {  
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['username'] = $user['Name'];
            $_SESSION['rollno'] = $user['RollNo'];
            header("location: main.php");
        }else {
            array_push($errors, "LoginId/password combination incorrect"); 
        }
        }
    }

?>