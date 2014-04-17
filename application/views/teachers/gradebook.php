<div class="row-fluid">
<div class="span12">
<h2>Gradebook</h2>
	<div class="alert">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <strong>Gradebook is currently in development, check back soon.</strong>
	</div>
</div>
</div>



<!--
<?
if (sizeof($assignments) > 0) { 
	foreach ($assignments as $thisassignment) {
	?>
	<div class="row-fluid">
	<div class="span12">
	<h3><?=$thisassignment['assignmentname']?></h3>
	</div>
	</div>
	<div class="row-fluid">
	<div class="span12">
		<p>Due Date: <?=date('M d Y h:i a', strtotime($thisassignment['asenddate']))?>&nbsp;&nbsp;&nbsp;&nbsp;Class: <?=$thisassignment['classname']?></p>
	</div>
	</div>
	<div class="row-fluid">
	<div class="span12">
	<table class="table table-hover">
		<tr>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Assignment</th>
			<th>Date</th>
			<th>Score</th>
		</tr>
	<?php
		if (0) {
			?>
	<tr>
		<td><?=$thisstudent['last_name']?></td>
		<td><?=$thisstudent['first_name']?></td>
		<td><a href="mailto:<?=$thisstudent['email']?>"><?=$thisstudent['email']?></a></td>
		<td><a href="" alt="assign to class" title="assign to class"><i class="icon-folder-open"></i></a></td>
		<td><a href="" alt="assign to class" title="assign to class"><i class="icon-folder-open"></i></a></td>
	</tr>
			<?php
		} else {
			?>
			<tr>
				<td colspan="5">No Grades for this assignment yet. Check back later.</td>
			</tr>
			<?
		}
	?>

	</table>
	</div>
	</div>
	<?
	}
} else {
	?>
	<div class="row-fluid">
	<div class="span12">
	<p>You have no assignments.  <a href="/teacher/manageclasses">Create some</a>.
	</div>
	</div>
	<?
}
?>
-->

</div><!--container-->