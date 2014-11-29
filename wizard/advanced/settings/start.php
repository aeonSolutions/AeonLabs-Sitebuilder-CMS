<form class="form" action="<?=strip_address("set",$_SERVER['REQUEST_URI']).'&set=1';?>" method="post" enctype="multipart/form-data">
<blockquote>
  <h3><img src="<?=$globvars['site_path'];?>/images/check_mark.gif" alt="check_mark" width="13" height="11">&nbsp;General Settings<br>
      <img src="<?=$globvars['site_path'];?>/images/check_mark.gif" alt="check_mark" width="13" height="11">&nbsp;Paths<br>
    <img src="<?=$globvars['site_path'];?>/images/check_mark.gif" alt="check_mark" width="13" height="11">&nbsp;Meta Tags<br>
    <img src="<?=$globvars['site_path'];?>/images/check_mark.gif" alt="check_mark" width="13" height="11">&nbsp;Database<br>
    <img src="<?=$globvars['site_path'];?>/images/check_mark.gif" alt="check_mark" width="13" height="11">&nbsp;Language<br>
    <input type="checkbox" name="smtp" id="smtp" tabindex="1">Email<br>
    <input type="checkbox" name="cookie" id="cookie" tabindex="2">Cookies</h3>
  <blockquote>
    <blockquote>
      <blockquote>
        <blockquote>
            <input class="button" type="submit" name="start" id="start" value="Start" tabindex="3">
        </blockquote>
      </blockquote>
    </blockquote>
  </blockquote>
</blockquote>
</form>
<?php
?>
