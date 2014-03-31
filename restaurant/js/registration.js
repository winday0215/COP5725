function formValidatio()
{
var uid = document.registration.user_id;
var passid = document.registration.password;
var cpassid = document.registration.cpassword;
var uname = document.registration.fullname;
var uadd = document.registration.address;
var ustate = document.registration.state;
var uzip = document.registration.pincode;
var uphn = document.registration.phonenumber;
var uemail = document.registration.email_address;
var umsex = document.registration.gender;
var ufsex = document.registration.gender;
if(userid_validation(uid,5,12))
{
if(passid_validation(passid,7,12))
{
if(passid_cvalidation(cpassid,passid))
{
if(allLetter(uname))
{
if(alphanumeric(uadd))
{ 
if(countryselect(ustate))
{
if(allnumeric(uzip))
{
if(ValidateEmail(uemail))
{
if(validsex(umsex,ufsex))
{
if(validphn(uphn))
{
 return true;
}
} 
}
}
} 
}
}
}
}
}
 return false;

} 



function userid_validation(uid,mx,my)
{
var uid_len = uid.value.length;
if (uid_len == 0 || uid_len >= my || uid_len < mx)
{
alert("User Id should not be empty / length be between "+mx+" to "+my);
document.registration.user_id.focus();
return false;
}
return true;
}

function passid_validation(passid,mx,my)
{
var passid_len = passid.value.length;
if (passid_len == 0 ||passid_len >= my || passid_len < mx)
{
alert("Password should not be empty / length be between "+mx+" to "+my);
document.registration.password.focus();
return false;
}
return true;
}

function passid_cvalidation(cpassid,passid)
{
var p_len = passid.value.length;
var cp_len = cpassid.value.length;
if(p_len!=cp_len)
{
	alert("Passwords do not match");
	document.registration.cpassword.focus();
	return false;
}
var i=0;
while(i<p_len)
{
	if(passid[i]!=cpassid[i])
	{
		alert("Passwords do not match");
		document.registration.cpassword.focus();
		return false;
	}i++;
}
return true;
}

function allLetter(uname)
{ 
var letters = /^[A-Za-z]+$+ /;
if(uname.value.match(letters))
{
return true;
}
else
{
alert('Name must have alphabet characters only');
document.registration.fullname.focus();
return false;
}


}
function alphanumeric(uadd)
{ 
var letters = /^[0-9a-zA-Z]+$+ /;
if(uadd.value.match(letters))
{
return true;
}
else
{
alert('User address must have alphanumeric characters only');
document.registration.address.focus();
return false;
}
}


function countryselect(ustate)
{
var letters = /^[A-Za-z]+$+ /;
if(uname.value.match(letters))
{
return true;
}
else
{
alert('State must have alphabet characters only');
document.registration.state.focus();
return false;
}
}


function allnumeric(uzip)
{ 
var numbers = /^[0-9]+$/;
if(uzip.value.match(numbers))
{
return true;
}
else
{
alert('Pincode must have numeric characters only');
document.registration.pincode.focus();
return false;
}
}

function validphn(uphn)
{ 
var numbers = /^[0-9]+$/;
if(uphn.value.match(numbers))
{
return true;
}
else
{
alert('Contact Number must have numeric characters only');
document.registration.phonenumber.focus();
return false;
}

}
function ValidateEmail(uemail)
{
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(uemail.value.match(mailformat))
{
return true;
}
else
{
alert("You have entered an invalid email address!");
document.registration.email_id.focus();
return false;
}
}


 function validsex(umsex,ufsex)
{
x=0;

if(umsex.checked) 
{
x++;
} if(ufsex.checked)
{
x++; 
}
if(x==0)
{
alert('Select Male/Female');
document.registration.gender.focus();
return false;
}
else
{
alert('Form Succesfully Submitted');
window.location.reload()
return true;
}
}
