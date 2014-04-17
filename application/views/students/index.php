<? /* students */ ?>

<div class="container">


<div class="row-fluid" id="me">
<div class="span12">

<h2>Student</h2>

<h5><i class="icon-user"></i> Edit Details</h5>
</div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" accept-charset="utf-8" class="form-inline">
<div class="span3">
  <input class="input-xlarge" type="text" name="first_name" value="<?=$userinfo['first_name']?>" id="first_name" />
</div>
<div class="span3">
  <input class="input-xlarge" type="text" name="last_name" value="<?=$userinfo['last_name']?>" id="last_name" />
</div>
<div class="span3">
  <input class="input-xlarge" type="text" name="email" value="<?=$userinfo['email']?>" id="email" />
</div>
<div class="span3">
  <input type="submit" class="btn btn-block" value="Continue &rarr;">
</div>
</form>

</div>
</div>

<div class="push"></div>

<div class="row-fluid" id="assignments">
<div class="span12">

<h2>Open Assignments</h2>

<table class="table table-hover">
	<tr>
		<th>Assignment Name</th>
		<th>Opens</th>
		<th>Closes</th>
		<th>Visiocab</th>
	</tr>
	<? 
	foreach($assignments as $thisassignment) {
		?>
<tr>
	<td><?=$thisassignment['name']?></td>
	<td><?=date('m-d-Y', strtotime($thisassignment['start_date']))?></td>
	<td><?=date('m-d-Y', strtotime($thisassignment['end_date']))?></td>
	<td><a href="/display/assignment/<?php echo $thisassignment['id']?>">Start Visiocab</a></td>
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

<h2>Grade Book</h2>

<table class="table table-hover">
	<tr>
		<th>Assignment Name</th>
		<th>Results</th>
		<th>Visiocab</th>
	</tr>
	<? 
	foreach($assignments as $thisassignment) {
		?>
<tr>
	<td><?=$thisassignment['name']?></td>
	<td><list results</td>
	<td><a href="/display/assignment/<?php echo $thisassignment['id']?>">Start Visiocab</a></td>
</tr>
		<?
	} 
	?>
</table>

</div>
</div>

<div id="push-bottom"></div>

</div><!--container-->