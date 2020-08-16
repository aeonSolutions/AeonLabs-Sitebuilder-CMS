<!doctype html>
<html>
<head>
    <meta name="description" content="<?=$globvars['meta']['description']; ?>">
    <meta name="keywords" content="<?=$globvars['meta']['keywords']; ?>">
    <meta name="author" content="<?=$globvars['meta']['author']; ?>">
    <meta name="robots" content="<?=$globvars['meta']['robots']; ?>">


	<link rel="stylesheet" href="<?=$globvars['site_path'];?>/core/layout/mdsbe/style.css" type="text/css" />
	<title>WS-WaDE</title>
</head>

<body>
	<div id="content">
		<div id="header">
	  <div id="logo">
				<h1><a href="#"><span class="title">WS-WaDE </span></a></h1>
			  <p>WebServer WebApp Development Environment</p>
		  </div>
		</div>		
		<div id="tabs">
			<ul>
            <?php
			if (isset($menu)):
				for($i=0;$i<count($menu['link']);$i++):
					$step= isset($step) ? $step : 0;
					if ($i==$step):
						echo '<li><a href="'.$menu['link'][$i].'" class="current" >'.$menu['text'][$i].'</a></li>';
					else:
						echo '<li><a href="'.$menu['link'][$i].'" >'.$menu['text'][$i].'</a></li>';
					endif;
				endfor;
			else:
			?>
			<div style="height:32px"></div>
            <?php			
			endif;
			?>	
		  	</ul>
			<div id="search"><div style="color:#003333">NFO: <?=$globvars['info'];?></div></div>            
		</div>
        <div style="height:30px"></div>
		<div class="gboxtop"></div>
		<div class="gbox">
        	<div id="ssid_timeout">
			<p><?=$globvars['warnings'];?></p>
           </div>
	  </div>
		<div class="left">
        	<div class="boxtop"></div>
            <div class="box">
			<?php
			if ($globvars['error']['flag']):
				include($globvars['local_root'].'core/layout/error/error.php');
			elseif ($globvars['error']['critical']):
				include($globvars['local_root'].'core/elayout/error/critical.php');
			elseif($worktype==true):
				if(isset($_GET['log'])):
					 include($globvars['local_root'].$globvars['module']['location']);
				else:
					include($globvars['local_root'].'core/layout/'.$globvars['layout']['worktype']);
				endif;		
			else: // included log viewer!
				 include($globvars['local_root'].$globvars['module']['location']);
			endif;
			?>
            </div>
        </div>
		<div class="footer">
        	<div align="right">
            	<?php
				if(is_file($globvars['local_root'].'tmp/error_log.log') or is_file($globvars['local_root'].'tmp/error_log_man.php')):
					echo 'CODE ERRORS found! <a style="text-decoration: underline" href="'.$_SERVER['REQUEST_URI'].'&log=view">CHECK IT OUT HERE</a>';
				elseif($globvars['debugger'] or $_SESSION['debugger']==true):
					echo '<font style="text-decoration: underline">Error Log Clean!</font> Is Currently <font color="#FF0000">DISABLED</font>. To enable click [<a href="'.$_SERVER['REQUEST_URI'].'&bug=free">HERE</a>]';
				else:
					echo '<font style="text-decoration: underline">CODE LOGGING is currently DISABLED!</font>. To enable click [<a href="'.$_SERVER['REQUEST_URI'].'&bug=free">HERE</a>]';
				endif;
				?>
            </div>
			<p>&copy; Copyright <?=date('Y',time()); ?></p>
	  </div>
	</div>
</body>
</html>