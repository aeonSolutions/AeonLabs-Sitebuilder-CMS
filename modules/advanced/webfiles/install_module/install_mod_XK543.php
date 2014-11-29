<?php

// create direcories needed
if (!is_dir($staticvars['upload'].'/webfiles')):
	@mkdir($staticvars['upload'].'/webfiles/');
endif;
?>