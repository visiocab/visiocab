<!-- admin/import -->
<div class="container">
<div class="row">
<div class="span12">

	<h2 class="iqs">Import Question Set</h2>

	<?php
	if ($message != '') {
		?><div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?=$message?>
		</div><?php
	}
	?>

	<div class="well">
		<h4>File should be an xml export from your learning management system</h4>
		<?= $errors ?> <br />
		<?= form_open_multipart('/admin/import') ?>
		<div class="input-group">
		  <span class="input-group-addon">Name</span>
		  <input type="text" name="quizname" class="form-control" value="" id="quizname" />
		</div>
		<br>
		<div class="form-group">
			<label for="exampleInputFile">Select File</label>
			<input type="file" name="xml_upload" id="xml_upload" />
			<p class="help-block">.xml files only.</p>
		</div>
		<br><br>
		<input type="submit" class="btn btn-warning" />
		</form>
	</div>

</div>
</div>

</div><!--container-->