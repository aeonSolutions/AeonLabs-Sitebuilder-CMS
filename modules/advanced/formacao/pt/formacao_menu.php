<link rel="StyleSheet" href="<?=$staticvars['site_path'];?>/modules/formacao/system/dtree.css" type="text/css" />
<script type="text/javascript" src="<?=$staticvars['site_path'];?>/modules/formacao/system/dtree.js"></script>
<script type="text/javascript">
    <!--
    <?php
	$cats=$db->getquery("select cod_categoria, nome from formacao_categorias where active='s'");
    $j=1;
    if ($cats[0][0]<>''):
        echo "d = new dTree('d');";
        echo "d.add(0,-1,'Cursos');";
        for($i=0; $i<count($cats);$i++):
            echo "d.add($j,0,'".$cats[$i][1]."','".session($staticvars,'index.php?id='.return_id('formacao_main.php').'&cat='.$cats[$i][0])."');";
            $j++;
			$subcats=$db->getquery("select cod_categoria, nome from formacao_categorias where active='s' and cod_sub_cat='".$cats[$i][0]."'");			
            if ($subcats[0][0]<>''):
                for($k=0;$k<count($subcats);$k++):
                        echo "d.add($j+$k,$j-1,'".$subcats[$k][1]."','".session($staticvars,'index.php?id='.return_id('produtos_main.php').'&cat='.$subcats[$k][0])."','','');";
                endfor;
                $j=$j+count($subcats);
            endif;
        endfor;
    else:
        echo 'document.write("Não existem cursos!");';
    endif;
    ?>

    document.write(d);
    //-->
</script>
