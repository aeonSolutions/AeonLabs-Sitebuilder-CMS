<?php
// $auth_type:
// 		Administrators
//		Guests
//		Default
//		Authenticated Users
$auth_type='Administrators';
if (!include($staticvars['local_root'].'general/site_handler.php')):
	echo 'Error: Security Not Found';
	exit;
endif;
?>
<table border="0" cellspacing="0">
  <tr>
    <td colspan="4"><span class="header_text_1">Forma&ccedil;&atilde;o</span></td>
  </tr>
  <tr>
    <td><img src="<?=$staticvars['site_path'].'/modules/produtos/images/panel.jpg';?>" width="57" height="57" border="0" /></td>
    <td align="left" valign="top"><strong>Gestão</strong><br />
    <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=category_management.php');?>"> Categorias</a><br /></td>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><strong>Cursos</strong><br />
        <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=formacao_management.php');?>">Adicionar</a><br />
        <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=formacao_management.php&edit=edit');?>">Editar</a><br />
        <a class="body_text" href="<?=session($staticvars,'index.php?id='.$task.'&goto='.$cod_module.'&load=formacao_management.php&edit=publish');?>">Publicar</a><br />
    </td>
  </tr>
</table>

