<?php
/*
File revision date: 30-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if($_SESSION['goback']==false):
	// add to DB
	$name=mysql_escape_string($_POST['name']);
	$affiliation=mysql_escape_string($_POST['affiliation']);
	$address1=mysql_escape_string($_POST['address1']);
	$address2=mysql_escape_string($_POST['address2']);
	$postal=mysql_escape_string($_POST['postal']);
	$country=mysql_escape_string($_POST['country']);
	$title=mysql_escape_string($_POST['title']);
	$phone=mysql_escape_string($_POST['phone']);
	$fax=mysql_escape_string($_POST['fax']);
	$city=mysql_escape_string($_POST['city']);
	$id=return_id('authoring/profile_edit.php');
	$get_id=$_GET['id'];
	if($id==$get_id):
		$verf=$db->getquery("select affiliation from congress_users where cod_user='".$staticvars['users']['code']."'");
		if($verf[0][0]<>''):
			$db->setquery("update congress_users set affiliation='".$affiliation."', address1='".$address1."', address2='".$address2."',
						  city='".$city."', postal='".$postal."', country='".$country."', title='".$title."', phone='".$phone."', fax='".$fax."' where cod_user='".$staticvars['users']['code']."'");
		else:
			$det=$db->getquery("select nome from users where cod_user='".$staticvars['users']['code']."'");
			$db->setquery("insert into congress_users set nome='".$det[0][0]."', affiliation='".$affiliation."', address1='".$address1."', address2='".$address2."',
						  city='".$city."', postal='".$postal."', country='".$country."', title='".$title."', phone='".$phone."', fax='".$fax."', cod_user='".$staticvars['users']['code']."'");
		endif;
	else:
		$user=$db->getquery("select cod_user from users where email='".mysql_escape_string($_POST['email'])."'");
		$db->setquery("insert into congress_users set nome='".$name."', affiliation='".$affiliation."', address1='".$address1."', address2='".$address2."',
					  city='".$city."', postal='".$postal."', country='".$country."', title='".$title."', phone='".$phone."', fax='".$fax."', cod_user='".$user[0][0]."'");
	endif;
	$_SESSION['status']=$regu[6];
endif;

?>