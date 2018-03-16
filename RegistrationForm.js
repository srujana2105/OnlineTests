function pass1() {
    var password1 = document.getElementById("psw1").value;
    msg = "";
    if (!(/[a-z]/).test(password1))
    {msg += "enter a-z<br>";}
    if(!(/[A-Z]/).test(password1))
    {msg += "enter A-Z<br>";}
    if(!(/[0-9]/).test(password1))
     {  msg += "enter atleast one number<br>";}
    if(password1.length<8)
    {msg += "password length should be minimum 8 characters";}
    document.getElementById("passmsg").innerHTML=msg;
    if(msg=="")
        {
            return true;
        }
    else 
        {
            return false;
        }
}
function pass2() {
    password2=document.getElementById("psw2").value;
    password1 = document.getElementById("psw1").value;
    msg="";
    if(password1)
        {
            if(password1.localeCompare(password2))
            {msg += "Re-enter correct password";}
        }
    else
        {
            msg += "Please fill Password first";
            return false;
        }
    document.getElementById("Rpassmsg").innerHTML=msg;
    if(msg=="")
        {
            return true;
        }
    else 
        {
            return false;
        }
}

function emailvalid() {
    mailid = document.getElementById("Email").value;
    msg="";
    var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(!re.test(mailid))
        {
            msg+="enter valid email Id";
            
        }
    document.getElementById("emsg").innerHTML=msg;
    if(msg=="")
        {
            return true;
        }
    else 
        {
            return false;
        }
    
}

function semvalid() {
    i = document.getElementById("sem").value;
    msg="";
    if( i == 0 )
        {
            msg+="please select semester";
        }
    if(msg=="")
        {
            return true;
        }
    else 
        {
            return false;
        }
}

function validrollno() {
    i = document.getElementById("Rollno").value;
    var msg = "";
    if(((/[^0-9^a-z^A-Z]/).test(i)))
        {
            msg+="please enter valid ID";
        }
    document.getElementById("Rmsg").innerHTML=msg;
    if(msg=="")
        {
            return true;
        }
    else 
        {
            return false;
        }
}

function validateform() {
    if(validrollno()&&semvalid()&&emailvalid()&&pass1()&&pass2())
    {    return true;}
    else
        {
            alert("fill the form properly");
            return false;
        }
}
