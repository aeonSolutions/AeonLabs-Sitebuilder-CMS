<?php
if($globvars['warnings']=='Unk Error Found! Check log file if enabled (loaded GB)'):
	$globvars['warnings']='';
endif;
?>
<!doctype html>
<html>
<head>
	<title>WS-WaDE</title>
</head>
<style type="text/css">
<!--
body {
	background-color: #124499;
}

h1{
font-family:Arial, Helvetica, sans-serif;
font-weight:bold;
font-size: 2.0em;
color:#E86C22;
}
h2{
font-family: Arial, Helvetica, sans-serif;
font-size: 1.0em;
color:#FFFFFF;
}
p{
font-family: Arial, Helvetica, sans-serif;
font-size: 0.8em;
color:#FFFFFF;
}

.input{
height:25px;
border-color:#000000;
border-bottom-style:double;
font-size:1.2em;
}
</style></head>

<body>
<table width="100%" border="0" cellpadding="30">
  <tr>
    <td><h1 style="color:#CCCCCC"><a href="http://www.aeonlabs.solutions">AeonLabs</a></h1></td>
    <td width="20" rowspan="2"><img src="<?=$globvars['site_path']?>/core/layout/login/vert_bar.png" width="20" height="500" /></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="49%" align="right"><p><font style="color:#82B3F6; font-family:Geneva, Arial, Helvetica, sans-serif; font-weight:bold; font-size:2em;">WS-WaDE v
      <?=$globvars['version'];?>
      </font><br />
      <font style="color:#82B3F6; font-family:Geneva, Arial, Helvetica, sans-serif; font-size:0.8em;">WebServer WebApp Development Environment</font>
    </p>
      <h1>Login</h1>
      <p align="right">To access SiteBuilder Environment<br />
      please enter your ID and password</p>
    <p>&nbsp;</p></td>
    <td width="49%"><form id="form1" name="form1" method="post" action="<?=$_SERVER['REQUEST_URI'];?>">
      <h2>ID<br />
        <label>
          <input name="username" type="text" id="username" class="input" size="25" maxlength="25" /> 
          </label>
      </h2>
      <h2>Password<br />
          <input name="password" type="password" id="password" class="input" size="25" maxlength="25" /> 
          <input type="image" src="<?=$globvars['site_path']?>/core/layout/login/button.png" width="23" height="23" />          <br />
      </h2>
    </form>
      <p style="color:#FF0000"><?=$globvars['warnings'];?></p>
      <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
