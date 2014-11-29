<?php
/*
File revision date: 21-jan-2009
*/
defined('ON_SiTe') or die('Direct Access to this location is not allowed.');
?>

  <H1>Paper Submission</H1>
  <p><br>
  </p>
    <p>Dear Author,<br />
    </span>The  (re)submission of your paper is no longer possible, as we have send all  papers to the publisher, due to the publisher deadlines. </span></p>
    <p>We are looking forward to see you in our <?=$event_type;?>!<br />
    </span>The organising committee of <?=$staticvars['name'];?></span></p>
    <p>  <br>
</p>
<div align="right">
    <form class="form" action="" method="post" enctype="multipart/form-data">
    <input type="submit" class="button" name="submit_paper" value="Submit a Paper" disabled="disabled" />
    </form>
  </div>
 