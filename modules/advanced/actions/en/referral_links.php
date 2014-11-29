<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Default';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
if (isset($_GET['lang'])):
	$lang=$_GET['lang']; 
else:
	$lang="pt";
endif;
if (isset($_SESSION['user'])):
	$user=$db->getquery("select cod_user, cod_user_type from users where nick='".$_SESSION['user']."'");
	if ($user[0][0]<>''):
		$user=$user[0][0];
	else:
		$user='';
	endif;		
else:
	$user='';
endif;

?>
<style>
	div.bxthdr    {
		font : 11px Verdana,Arial,Helvetica,sans-serif;
		color : #ffffff;
		background-color : #6A94CC;
		border-bottom: 0px solid #10438F;
		padding: 3px 3px 3px 5px;
		height: 20px;
		}
	H3 {
		font : bold 17px Verdana, Arial, Helvetica, sans-serif;
		margin : 0px 0px 0px 0px;
		color: #222222;
	}
</style>


<h3>Create referral link:  </h3>
<br>
<table border="0" cellpadding="3" width="100%">
	  <tbody><tr>
		<td valign="top"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/hyperlink.gif" border="0"></td>
		<td valign="top"><p>
		If you would like to refer to us, just copy the following HTML code to your website to create an according link.
		<?php
		if (isset($_SESSION['user'])):
		echo '<br>And don\'t forget to activate the referral link option on your profile settings for unlimited downloads!';
		endif;
		?>
		Thank You!
		</p></td>
	</tr>
	</tbody></table>
<p>
</p><div class="bxthdr">Direct Link  (Text)</div>
<p><b>Link preview:</b><br><br>
<a href="<?=$staticvars['site_path'];?>/index.php" target="_blank"><?=$site_name." - ".$page_title;?></a><br><br>
HTML - code:<br><textarea rows="4" style="width: 440px;" cols="44" class="text" id="textarea1" name="textarea1">&lt;a
href="<?=$staticvars['site_path'].'/index.php?referral='.$user;?>" target="_blank"&gt;<?=$site_name." - ".$page_title;?>&lt;/a&gt;</textarea></p><br>

<div class="bxthdr">Direct Link  (Image: 130 x 80)</div>
<p><b>Link preview:</b><br><br>
<a href="" target="_blank"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/130x80.gif" alt="<?=$site_name." - ".$page_title;?>" border="0"></a><br><br>
HTML - code:<br><textarea rows="4" style="width: 440px;" cols="44" class="text" id="textarea1" name="textarea1">&lt;a
href="<?=$staticvars['site_path'].'/index.php?referral='.$user;?>" target="_blank"&gt;&lt;img
border="0" src="<?=$staticvars['site_path'];?>/modules/actions/images/130x80.gif"
alt="<?=$site_name." - ".$page_title;?>"&gt;&lt;/a&gt;</textarea></p><br>

<div class="bxthdr">Direct Link  (Image: 130 x 44)</div>
<p><b>Link preview:</b><br><br>
<a href="" target="_blank"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/130x44.gif" alt="<?=$site_name." - ".$page_title;?>" border="0"></a><br><br>
HTML - code:<br><textarea rows="4" style="width: 440px;" cols="44" class="text" id="textarea1" name="textarea1">&lt;a
href="<?=$staticvars['site_path'].'/index.php?referral='.$user;?>" target="_blank"&gt;&lt;img
border="0" src="<?=$staticvars['site_path'];?>/modules/actions/images/130x44.gif"
alt="<?=$site_name." - ".$page_title;?>"&gt;&lt;/a&gt;</textarea></p><br>

<div class="bxthdr">Direct Link  (Image: 88 x 31)</div>
<p><b>Link preview:</b><br><br>
<a href="" target="_blank"><img src="<?=$staticvars['site_path'];?>/modules/actions/images/88x31.gif" alt="<?=$site_name." - ".$page_title;?>" border="0"></a><br><br>
HTML - code:<br><textarea rows="4" style="width: 440px;" cols="44" class="text" id="textarea1" name="textarea1">&lt;a
href="<?=$staticvars['site_path'].'/index.php?referral='.$user;?>" target="_blank"&gt;&lt;img
border="0" src="<?=$staticvars['site_path'];?>/modules/actions/images/88x31.gif"
alt="<?=$site_name." - ".$page_title;?>"&gt;&lt;/a&gt;</textarea></p><br>
<p></p>
