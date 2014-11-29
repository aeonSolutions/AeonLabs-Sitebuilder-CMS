<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/modules/congressos/system/dtree.css" type="text/css" />
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/modules/congressos/system/dtree.js"></script>
<script type="text/javascript">
	site_path='<?=$staticvars['site_path'];?>/';
    <!--
    <?php
	$cats=$db->getquery("select cod_categoria, nome from congressos_categorias where active='s' and cod_sub_cat='0'");
    $j=1;
    if ($cats[0][0]<>''):
		if (isset($_GET['lang'])):
			$lang=$_GET['lang']; 
			if ($lang<>'pt' and $lang<>'en'):
				$lang=$staticvars['language']['main'];
			endif;
		else:
			$lang=$staticvars['language']['main'];
		endif;

        echo "d = new dTree('d');";
        echo "d.add(0,-1,'congressos');";
        for($i=0; $i<count($cats);$i++):
			$display_name=$cats[$i][1];
			$id=return_id('congressos_list.php');
            echo "d.add($j,0,'".$display_name."','".session($staticvars,'index.php?id='.$id.'&cat='.$cats[$i][0])."');";
            $j++;
			$subcats=$db->getquery("select cod_categoria, nome from congressos_categorias where active='s' and cod_sub_cat='".$cats[$i][0]."'");			
            if ($subcats[0][0]<>''):
                for($k=0;$k<count($subcats);$k++):
                        echo "d.add($j+$k,$j-1,'".$subcats[$k][1]."','".session($staticvars,'index.php?id='.$id.'&cat='.$subcats[$k][0])."','','');";
                endfor;
                $j=$j+count($subcats);
            endif;
        endfor;
    else:
        echo 'document.write("Não existem congressos!");';
    endif;
    ?>

    document.write(d);
    //-->
</script>
<br />

