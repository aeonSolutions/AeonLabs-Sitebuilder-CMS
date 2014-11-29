<?php
/*
File revision date: 14-abr-2008
*/
// User Management System

//compatibility - in the future is not necessary
$staticvars['users']['user_type']['admin']=-1;// admin group code
$staticvars['users']['user_type']['guest']=-1;//guest group code
$staticvars['users']['user_type']['default']=-1;//default group code
$staticvars['users']['user_type']['auth']=-1;// authenticated group code
$staticvars['users']['user_type']['cm']=-1;// content management group code
$staticvars['users']['is_auth']=false;// flag true when user auth occurs
$staticvars['users']['name']=0;// username
$staticvars['users']['code']=0;// db user code
$staticvars['users']['group']=-1;// guest code
$staticvars['users']['email']='';// user email

?>