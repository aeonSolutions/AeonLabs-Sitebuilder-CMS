<?php
// profile info
$pi=array();
$pi[0]='Welcome';
$pi[1]='Edit my profile';
$pi[2]='Logout';
$pi[]='';

// registo utilizador~
$nusr=array();
$nusr[0]='The security code you provided is invalid';
$nusr[1]='Passwords Mismatch';
$nusr[2]='There is already the username you have selected';
$nusr[3]='the email is already on our database';
$nusr[4]='The email is invalid';
$nusr[5]='The username you\'ve selected is invalid';
$nusr[6]='';

//login requiered
$lr=array();
$lr[0]='The page you are trying to view is olny available to registered users. ';
$lr[1]='Dear Guest user, the area you are trying to reach is only available to registered users. You are not currently Logged or your session has timed out for securty reasons.';
$lr[2]='Are you registered ??';
$lr[3]='Welcome !';
$lr[4]='Please enter your login credentials to access the reserved area...';
$lr[5]='Username:';
$lr[6]='Password:';
$lr[7]='Auto-Login';
$lr[8]='DO you forgot password?';
$lr[9]='Are you registered ?';
$lr[10]='Register right now!';
$lr[11]='Under a minute, register on this website. It\'s quite easy!';
$lr[12]='Register';
$lr[13]='login';

// new register
$nr=array();
$nr[0]='Creat an account';
$nr[1]='Create a new access account';
$nr[2]='Fields marked with ';
$nr[3]=' are mandatory';
$nr[4]='There was errors on your register form. Please check the fields marked in red.';
$nr[5]='You need to fill all mandatory fields.';
$nr[6]='Name:';
$nr[7]='Username:';
$nr[8]='E-mail:';
$nr[9]='Password:';
$nr[10]='Repeat password:';
$nr[11]='Security image';
$nr[12]='In order to avoid the abusive use of the register form, it is requiered to type bellow the security code show in the image. The code is case sensity.';
$nr[13]='Code shown by the security image';
$nr[14]='By clicking the button <strong>Register</strong> you declare that accept all';
$nr[15]='terms and conditions';
$nr[16]='Register';
$nr[17]=' of this website all well as all the terms presented in this register form';
$nr[18]='Your registration was completed successfully. An activation email was just sent to your email box. Open the email sent by us and click on the provided activation link. Thank you.';
$nr[19]='<strong>Take special note</strong><blockquote>In some free email services such as <strong>hotmail</strong> and <strong>gmail</strong> the activation email might be considered as <strong>SPAM</strong>.<br> If you are unable to see the activation email on the INBOX folder, please <strong>check your SPAM folder for the activation email</strong>.<br>If you\'ve done the step above and still haven\'t received for a couple of hours the activation email, send us and email. </blockquote>';
$nr[20]='Activation Email Sent';

// first login
$fl=array();
$fl[0]='Change Password';
$fl[1]='Welcome. This is your personal profile area. In order to continue please change your access password.';
$fl[2]='Current Password:';
$fl[3]='Password:';
$fl[4]='Repeat Password:';

//profile edit
$pe=array();
$pe[0]='The password was not changed!';
$pe[1]='Fields marked with ';
$pe[2]='are mandatory';
$pe[3]='Name:';
$pe[4]='E-mail:';
$pe[5]='Login credentials';
$pe[6]='Username:';
$pe[7]='Password:';
$pe[8]='Repeat Password: ';
$pe[9]='Leave empty if you do not wish to change the password';
$pe[10]='Random password';
$pe[11]='Save Profile';
$pe[12]='Account manager';
$pe[13]='Password change in the website ';
$pe[14]='Your password has been changed successfully.';
$pe[]='';

//profile info
$pi=array();
$pi[0]='Welcome';
$pi[1]='Edit Profile';
$pi[2]='Logout';

//sucess register
$sr=array();
$sr[0]='Your Registration was completed successfully. Please goto your email box in order to activate your account.<br />
<br />Keep in mind that in some email services, such as  <strong>hotmail</strong> or<strong> gmail</strong> the activation email might be considered as SPAM. <br />
In case you did not find the activation email, search under the SPAM folder. Thank You!';
// lost password
$lp=array();
$lp[0]='Retrieve lost password';
$lp[1]='Don\'t worry if you\'ve forgotten your login credentials. Type down in bellow email field, and we\'ll send you a new access password.';
$lp[2]='When you report your password lost, you will receive an e-mail containing your current username and a NEW password immediately. This protects you if someone is trying to get a secret password while controlling your e-mail account. Your old password will become obsolete immediately .';
$lp[3]='Follow these three steps to retrieve your username and password:';
$lp[4]='&nbsp;&nbsp;&nbsp;1- Type your e-mail address in the e-mail field<br>
						&nbsp;&nbsp;&nbsp;2- Press "Retrieve Password"<br>
						&nbsp;&nbsp;&nbsp;3- Check your e-mail to retrieve your username and password.';
$lp[5]='Retrieve password';
$lp[6]='Retrieval of user and password from the site:';
$lp[7]='The email you\'ve entered is not in our DB !';
$lp[8]='Invalid email entered!';
$lp[9]="<div align='left'>Email sent...</div><br>
		<div align='center' >Please check your email account por the new access password</div>";

// profile activate
$pa=array();
$pa[0]='Account activation';
$pa[1]='Your account is already activated! Login to access the reserved areas!';
$pa[2]='Your account was successfully activated. You can login to access the reserved areas.';
$pa[3]='There was a unknown error on activating your account. Please contact the webmaster.';

//lateral login
$ll=array();
$ll[0]='Click here to change your profile';
$ll[1]='click here to logout';
$ll[2]='My profile';
$ll[3]='Logout';
$ll[4]='Username';
$ll[5]='Password';
$ll[6]='Auto-Login';
$ll[7]='register';
$ll[8]='forgot password';
$ll[9]='Welcome, ';

//
$l=array();
$l[0]='You\'re already logged in!';
$l[1]='Welcome!';
$l[2]='This area is for registered users only ';
$l[3]='In order to access you need to enter your login credentials.';
$l[4]='Username';
$l[5]='Password';
$l[6]='Automatic login';
$l[7]='Forgot password!';
$l[8]='Can\'t remember your login credentials? Click';
$l[9]=' here';
$l[10]=' to retrieve.';

// login error messagens
$m=array();
$m[0]='';
$m[1]='Verify your email account to activate the acount.';
$m[2]='Your account was disabled by the system administrator. To know why, send an email to the <a href="mailto:'.$staticvars['smtp']['admin_mail'].'">webmaster</a>';
$m[3]='User not found or bad password!';

?>

