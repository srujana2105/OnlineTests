<?php include('FacultyServer.php') ?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            Registration Form
        </title>
        <link rel="stylesheet" type="text/css" href="RegistrationForm.css">
        <script src="FacultySignup.js"></script>
    </head>
    <body>
        <div id="id01" class="modal">
          <form id="modal-content" class="modal-content" onsubmit="return validateform()" method="POST" action="FacultySignup.php">
              <?php include('errors.php'); ?>
            <div class="container">
              <h1>Sign Up</h1>
              <p>Please fill in this form to register.</p>
              <hr>
                <label name="Name" id="name"><b>Name</b></label>
              <input name="Name" style="width: 95%" type="text" placeholder="Enter your full name" id="name"  required>
                <label id="rollno" name="RollNo"><b>Faculty Id</b></label>
              <input type="text" class="box" name="FID" placeholder="Enter your Faculty ID" id="Rollno" onkeyup="validID()" required><p style="float:right; width: 45%; color:red;" id="Rmsg" class="msg"></p>
                <label name="EmailId" id="EmailId"><b>Email ID</b></label>
              <input type="text" style="width: 45%" placeholder="Enter your Email ID" id="Email" name="EmailId" onchange="emailvalid()" required>
                <p style="width:48%;float: right; margin:0 ; color: red; " class="msg" id="emsg"></p>

                <label for="psw"><b>Password</b></label>
                  <input type="password" class="box" name="Password" placeholder="Enter Password" id="psw1" onkeyup="pass1()">
                  <p style="width:48%;float: right; margin:0 ; color: red; " class="msg" id="passmsg"></p>

              <label for="psw-repeat"><b>Repeat Password</b></label>
              <input type="password" class="box" placeholder="Repeat Password" id="psw2" name="psw-repeat" onkeyup="pass2()" required><p class="msg" id="Rpassmsg" style="width: 48%; float: right;margin:0 ; color: red;" ></p>
              <div class="clearfix">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" id="cancelbtn">Cancel</button>
                <button type="submit" id="signupbtn" name="reg_user">Sign Up</button>
              </div>
                <p>Already registered?   <a href="FacultyLogin.php">  Log In</a></p>
            </div>
          </form>
        </div>
    </body>
</html>