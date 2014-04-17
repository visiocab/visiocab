<!--

MERGED WITH MANAGE CLASSES 

-->

<div class="row-fluid">
<div class="span12">
<h2>Assignments</h2>
<p><a href="" class="btn btn-large btn-warning" type="button"><i class="icon-file icon-white"></i> Add Assignment</a></p>
</div>
</div>

<div class="row-fluid">
<div class="span12">
<table class="table table-hover">
	<tr>
		<th>Assignment</th>
		<th>Assign Students</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>

<?php
	foreach ($students as $thisstudent) {
		?>
<tr>
	<td><a href="">Assignment Name</a></td>
	<td><a href="" alt="assign students" title="assign to class"><i class="icon-folder-open"></i></a></td>
	<td><a href="" alt="edit assignment" title="edit student"><i class="icon-edit"></i></a></td>
	<td><a href="" alt="delete assignment" title="delete student"><i class="icon-trash"></i></a></td>
</tr>
		<?php
	}
?>
</table>
</div>
</div>

<div id="push-bottom"></div>

</div><!--container-->