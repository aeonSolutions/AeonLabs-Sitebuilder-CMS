<?php
if(isset($_GET['lang'])):
	$lang=$_GET['lang'];
else:
	$lang=$staticvars['language']['main'];
endif;
if(!is_file($staticvars['local_root'].'modules/produtos/language/'.$lang.'.php')):
	include($staticvars['local_root'].'modules/produtos/language/pt.php');
else:
	include($staticvars['local_root'].'modules/produtos/language/'.$lang.'.php');
endif;
$address=return_id('produtos_main.php');
$query=$db->getquery("select cod_categoria, nome,cod_sub_cat from produtos_categorias where active='s' order by nome");
$k=0;
for($i=0;$i<count($query);$i++):
	if($query[$i][2]==0):
		$cat_option[$k][0]=$query[$i][0];
		$cat_option[$k][1]=$query[$i][1];
		$cat_option[$k][2]='optgroup';
		$k++;
	else:
		for($j=0;$i<count($query);$j++):
			if($query[$j][2]==$query[$i][0]):
				$cat_option[$k][0]=$query[$j][0];
				$cat_option[$k][1]=$query[$j][1];
				$cat_option[$k][2]='';
				$k++;
			endif;
		endfor;
	endif;	
endfor;

?>
<h3><?=$pas[1];?></h3>
<form action="<?=session($staticvars,'index.php?id='.$address);?>" enctype="multipart/form-data" method="post">
  <table width="300" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><strong><?=$pas[0];?></strong>
          <table cellspacing="0" cellpadding="0" width="100%" border="0">
            <tbody>
              <tr>
                <td><table cellspacing="0" cellpadding="3" width="100%" border="0">
                    <tbody>
                      <tr>
                        <td></td>
                      </tr>
                      <tr>
                        <td align="center"><input class="body_text" name="adv_search" id="adv_search" size="60" maxlength="255" /></td>
                      </tr>
                      <tr></tr>
                    </tbody>
                </table></td>
              </tr>
            </tbody>
          </table></td>
    </tr>
    <tr>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td><table cellspacing="1" cellpadding="2" width="100%" border="0">
          <tbody>
            <tr>
              <td><table cellspacing="0" cellpadding="2" width="100%" border="0">
                  <tbody>
                    <tr>
                      <td><?=$pas[2];?>:</td>
                      <td><select name="categories" class="form_input">
                        <option value="TODAS" selected="selected"><?=$pas[3];?></option>
						<?php
                        for ($i=0 ; $i<count($cat_option); $i++):
                             if ($cat_option[$i][2]=='optgroup'):
                             ?>
                                <optgroup label="<?=$cat_option[$i][1];?>"></optgroup>
                                <option <? if ($cat_option[$i][0]==$cat){ echo 'selected="selected"';}?> value="<?=$cat_option[$i][0];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$cat_option[$i][1]; ?></option>
                             <?php
                             else:
                                ?>
                                <option <? if ($cat_option[$i][0]==$cat){ echo 'selected="selected"';}?> value="<?=$cat_option[$i][0];?>" >&nbsp;&nbsp;&nbsp;&nbsp;<?=$cat_option[$i][1]; ?></option>
                            <?php
                            endif;
                        endfor; ?>
                      </select></td>
                    </tr>
                    <tr>
                      <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td><?=$pas[4];?>:</td>
                      <td><input name="pfrom" class="body_text" /></td>
                    </tr>
                    <tr>
                      <td><?=$pas[5];?>:</td>
                      <td><input name="pto" class="body_text" /></td>
                    </tr>
                  </tbody>
              </table></td>
            </tr>
          </tbody>
      </table></td>
    </tr>
    <tr><td align="right"><input type="submit" value="<?=$pas[6];?>" class="form_submit" /></td>
    </tr>
  </table>
</form>
