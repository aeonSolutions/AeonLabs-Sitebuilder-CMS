<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/congressos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/congressos/language/'.$lang.'.php');
endif;
if(is_file($staticvars['local_root'].'modules/congressos/system/titles.php')):
	include($staticvars['local_root'].'modules/congressos/system/titles.php');
else:
	echo 'You need to build titles file first!';
	exit;
endif;
if(isset($_SESSION['congress'])):
	echo '<font color="red">'.$_SESSION['congress'].'</font>';
endif;
if(isset($_POST['affiliation'])):
	$affiliation=$_POST['affiliation'];
	$address1=$_POST['address1'];
	$address2=$_POST['address2'];
	$city=$_POST['city'];
	$postal=$_POST['postal'];
	$phone=$_POST['phone'];
	$fax=$_POST['fax'];
	$country=$_POST['country'];
	$title=$_POST['title'];
else:
	$affiliation='';
	$address1='';
	$address2='';
	$city='';
	$postal='';
	$phone='';
	$fax='';
	$country='';
	$title='';
endif;
include($staticvars['local_root'].'modules/congressos/system/countries.php');
?>
  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="default">
      <tr valign="center">
        <td width="197" align="right"><b>
<div id="u_atitle"><?=$nuf[9];?></div></b></td>
        <td width="300">
        <select class="text" name="title" id="topic" tabindex="0">
            <?php
            for ($k=0 ; $k<count($titles); $k++):
                ?>
                <option <?php if($title==$titles[$k]){ echo 'selected="selected"'; };?> value="<?=$titles[$k];?>"><?=$titles[$k];?></option>
                <?php
            endfor; ?>
      </select>    
    </td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
<div id="u_name"></div>
        </b></td>
        <td>&nbsp;</td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
        <div id="u_affiliation"><font size="1" color="#FF0000">&#8226; </font>
        <? if (isset($_SESSION['affiliation'])):
                ?>
              <font size="1" color="#FF0000"><?=$nuf[1];?></font>
              <?
            else:
                ?>
              <font class="body_text"><?=$nuf[1];?></font>
              <?
            endif; ?></div></b></td>
        <td><input name="affiliation" class="text" type="text" id="affiliation" tabindex="6" size="50" maxlength="200"  value="<?=$affiliation;?>"/></td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
<div id="u_address1"><font size="1" color="#FF0000">&#8226; </font>
              <? if (isset($_SESSION['address1'])):
                ?>
              <font size="1" color="#FF0000"><?=$nuf[2];?></font>
              <?
            else:
                ?>
              <font class="body_text"><?=$nuf[2];?></font>
              <?
            endif; ?>
			</div></b></td>
        <td><input  maxlength="200" size="35" class="text" name="address1" tabindex="7"  value="<?=$address1;?>"/></td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
<div id="u_address2"><?=$nuf[3];?></div></b></td>
        <td><input class="text" maxlength="200" size="35" name="address2" tabindex="8"  value="<?=$address2;?>"/></td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
<div id="u_city"><font size="1" color="#FF0000">&#8226; </font>
			<? if (isset($_SESSION['city'])):
                ?>
              <font size="1" color="#FF0000"><?=$nuf[4];?></font>
              <?
            else:
                ?>
              <font class="body_text"><?=$nuf[4];?></font>
              <?
            endif; ?></div></b></td>
        <td><input class="text"  maxlength="90" size="35" name="city" tabindex="9"  value="<?=$city;?>"/></td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
<div id="u_postal"><font size="1" color="#FF0000">&#8226; </font>
              <? if (isset($_SESSION['postal'])):
                ?>
              <font size="1" color="#FF0000"><?=$nuf[5];?></font>
              <?
            else:
                ?>
              <font class="body_text"><?=$nuf[5];?></font>
              <?
            endif; ?></div></b></td>
        <td><input class="text"   maxlength="10" size="8" name="postal" tabindex="10"  value="<?=$postal;?>"/></td>
      </tr>
      <tr valign="center">
        <td align="right"><b>
<div id="u_country"><font size="1" color="#FF0000">&#8226; </font>
              <? if (isset($_SESSION['country'])):
                ?>
              <font size="1" color="#FF0000"><?=$nuf[6];?></font>
              <?
            else:
                ?>
              <font class="body_text"><?=$nuf[6];?></font>
              <?
            endif; ?></div></b></td>
        <td>
        <select class="text"   style="WIDTH: 227px" tabindex="11" name="country">
            <option value="">Select</option>
            <?php
            for($i=0;$i<count($countries);$i++):
                $sel= ($country==$countries[$i]) ? 'selected="selected"' : '';
                echo '<option '.$sel.' value="'.$countries[$i].'">'.$countries[$i].'</option>';
            endfor;
            ?>
		</select>
	</td>
      </tr>
    <tr valign="center">
      <td align="right"><b>
<div id="u_phone"><?=$nuf[7];?></div></b></td>
      <td><input class="text"  name="phone" id="phone" size="20" maxlength="20" tabindex="12"  value="<?=$phone;?>"/></td>
    </tr>
    <tr valign="center">
      <td align="right"><b>
<div id="u_fax"><?=$nuf[8];?></div></b></td>
      <td><input class="text" maxlength="20" size="20" name="fax" tabindex="13"  value="<?=$fax;?>"/></td>
    </tr>
  </table>
 

