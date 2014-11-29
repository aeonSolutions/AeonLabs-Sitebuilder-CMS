<?php
?>
<style>
.equal {
    display:table;
	margin:10px auto;
	border-spacing:10px;
	width:100%;
}
.row {
    display:table-row;
}
.row a{
	text-decoration:none
}

.row div {
    display:table-cell;
}



.row div.c1{
	width:20%;
	border: 1px solid #009900;
	background:#CCFF99;
	padding:5px;
	text-align:center;
}
.row div.c2{
	width:20%;
	border: 1px solid #009900;
	background:#CCFF99;
	padding:5px;
	text-align:center;
}
.row div.c3{
	width:20%;
	border: 1px solid #009900;
	background:#CCFF99;
	padding:5px;
	text-align:center;
}


</style>
<div class="equal">
    <div class="row">
        <div class="c1">
        <h3><img src="<?=$globvars['site_path'];?>/images/db.gif" align="absmiddle" alt="Config" /><a href="<?=session_setup($globvars,'index.php?id=13');?>">Database Optimization</a></h3>
      </div>
        <div class="c2">
        <h3><img src="<?=$globvars['site_path'];?>/images/db.gif" alt="Config" align="absmiddle" /><a href="<?=session_setup($globvars,'index.php?id=14');?>">Database Backup</a></h3>
      </div>
        <div class="c3">
        <h3><img src="<?=$globvars['site_path'];?>/images/null_idx.gif" alt="Config" align="absmiddle" /><a href="<?=session_setup($globvars,'index.php?id=17');?>">Add Null Index</a></h3>
      </div>
    </div>
</div>
