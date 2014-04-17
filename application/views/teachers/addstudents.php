<div class="row">
<div class="span12">
<?php

if ($message != '') {
	?><div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?=$message?>
	</div><?php
}

?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post" accept-charset="utf-8" class="form-horizontal">
<fieldset>
<div id="legend">
	<legend class="">New Student</legend>
</div> 
<div class="control-group">	
	<label class="control-label" for="first_name">First Name</label>
<div class="controls">
	<input type="text" name="first_name" value="<?=($existinginfo['first_name'])? $existinginfo['first_name'] : ''?>" id="first_name" />
</div>
</div>
<div class="control-group">	
	<label class="control-label" for="last_name">Last Name</label>
<div class="controls">
	<input type="text" name="last_name" value="<?=($existinginfo['last_name'])? $existinginfo['last_name'] : ''?>" id="last_name" />
</div>
</div>
<div class="control-group">	
	<label class="control-label" for="email">Email</label>
<div class="controls">
	<input type="text" name="email" value="<?=($existinginfo['email'])? $existinginfo['email'] : ''?>" id="email" />
</div>
</div>
<? if (!empty($existinginfo)) {?>
<input type="hidden" name="editid" value="<?=$existinginfo['id']?>" />
<? } else { ?>
<div class="control-group">	
	<label class="control-label" for="password">Password</label>
<div class="controls">
	<input type="text" name="password" value="" id="password" />
</div>
</div>
<div class="control-group">	
<div class="controls">
	<label class="checkbox">
	<input type="checkbox" name="is_teacher" value="" id="is_teacher"> This user is a Teacher
	</label>
</div>
</div>
<? } ?>
<div class="control-group">	
<div class="controls">
	<input type="submit" class="btn btn-warning" value="Submit">
</div>
</div>
</form>

</div>
</div>