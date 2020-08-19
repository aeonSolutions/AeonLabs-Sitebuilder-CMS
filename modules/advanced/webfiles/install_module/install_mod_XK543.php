<?php

// create direcories needed
if (!is_dir($staticvars['upload'].'/webfiles')):
	@mkdir($staticvars['upload'].'/webfiles/', 0755, true);
endif;
?>