<?php include('FacultyServer.php') ?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Login Form
        </title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <script src="index.js"></script>
    </head>
    <body>


        <link rel="stylesheet" type="text/css" href="index.css">
        <div id="id01" class="modal">
          <form id="modal-content" class="modal-content"  method="POST" action="FacultyLogin.php">
              <?php include('errors.php'); ?>
           <div class="container">
               <img src="uceou_logo.jpg" alt style="width: 130px; margin:20px auto; margin-bottom: 15px; display: block;" >
              <h1 style="text-align: center" >Log in</h1>
               <hr>
               <p id="msg" ></p>
               <label id="rollno"><b>Login ID is you Faculty ID</b></label>
              <input type="text" class="box" name="RollNo" placeholder="Enter your Faculty ID" id="Rollno">
               <label for="psw"><b>Password</b></label>
                  <input type="password" class="box" name="Password" placeholder="Enter Password" id="psw1">
               <button type="submit" name="login_user">Log In</button>
              <p>Not Registered?   <a href="FacultySignup.php">    Sign Up</a></p>
              </div>
            </form>
        </div>
    </body>
</html>