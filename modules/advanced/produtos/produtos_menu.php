<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/modules/produtos/system/dtree.css" type="text/css" />
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/modules/produtos/system/dtree.js"></script>
<script type="text/javascript">
    <!--
    <?php
	$cats=$db->getquery("select cod_categoria, nome,descricao from produtos_categorias where active='s'");
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
        echo "d.add(0,-1,'PRODUTOS');";
        for($i=0; $i<count($cats);$i++):
			if($cats[$i][2]<>'' and $cats[$i][2]<>'N/A'):
				$pipes=explode("||",$cats[$i][2]);
				$display_name='';
				for($l11=0; $l11<count($pipes);$l11++):
					$names=explode("=",$pipes[$l11]);
					if ($lang==$names[0]):
						$display_name=$names[1];
					endif;
				endfor;
				if ($display_name==''):
					$display_name=" - - ";
				endif;
			else:
				$display_name=$query[$i][1];
			endif;
            echo "d.add($j,0,'".$display_name."','".session($staticvars,'index.php?id='.return_id('produtos_main.php').'&cat='.$cats[$i][0])."');";
            $j++;
			$subcats=$db->getquery("select cod_categoria, nome from produtos_categorias where active='s' and cod_sub_cat='".$cats[$i][0]."'");			
            if ($subcats[0][0]<>''):
                for($k=0;$k<count($subcats);$k++):
                        echo "d.add($j+$k,$j-1,'".$subcats[$k][1]."','".session($staticvars,'index.php?id='.return_id('produtos_main.php').'&cat='.$subcats[$k][0])."','','');";
                endfor;
                $j=$j+count($subcats);
            endif;
        endfor;
    else:
        echo 'document.write("Não existem Produtos!");';
    endif;
    ?>

    document.write(d);
    //-->
</script>
<br />

