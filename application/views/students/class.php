<? /* students */ ?>

<div class="container">

<div class="row-fluid" id="assignments">
<div class="span12">
<h2>Enrolled Classes</h2>
<table class="table table-hover">
	<tr>
		<th>Class Name</th>
		<th>Starts</th>
		<th>Ends</th>
		<th>&nbsp;</th>
	</tr>
	<? 
	foreach($enrolled as $thisenrolled) {
		?>
<tr>
	<td><?=$thisenrolled['name']?></td>
	<td><?=date('m-d-Y', strtotime($thisenrolled['start_date']))?></td>
	<td><?=date('m-d-Y', strtotime($thisenrolled['end_date']))?></td>
	<td><a href="/student/removeclass/<?php echo $thisenrolled['class_id']?>">Remove class</a></td>
</tr>
		<?
	} 
	?>
</table>

</div>
</div>

<div class="push"></div>

<div class="row-fluid" id="grade-book">
<div class="span12">

<h2>Available Classes</h2>

<table class="table table-hover">
	<tr>
		<th>Class Name</th>
		<th>Starts</th>
		<th>Ends</th>
		<th>&nbsp;</th>
	</tr>
	<? 
	foreach($available as $thisavailable) {
		?>
<tr>
	<td><?=$thisavailable['name']?></td>
	<td><?=date('m-d-Y', strtotime($thisavailable['start_date']))?></td>
	<td><?=date('m-d-Y', strtotime($thisavailable['end_date']))?></td>
	<td><a href="/student/addclass/<?php echo $thisavailable['id']?>">Add class</a></td>
</tr>
		<?
	} 
	?>
</table>

</div>
</div>

<div id="push-bottom"></div>

</div><!--container-->