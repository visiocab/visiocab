<div class="container">

<div class="row">
<div class="col-md-12">
	<h2 class="qs">Your Question Sets</h2>
</div>
</div>

<div class="row">
<div class="col-md-12">
	<div class="btn-group btn-default btn-group-justified">
		<a href="/admin/import" class="btn btn-lg btn-default" type="button"><i class="icon-circle-arrow-up"></i> Import Question Set</a>
		<a href="#" class="addnew btn btn-lg btn-default" id="newset" type="button"><i class="icon-plus"></i> Create New Question Set</a>
	</div>
</div>
</div>

<div class="row">
	<div class="col-md-12">
	<?
		if ($message != '') {
			?><div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<i class="icon-circle-arrow-up"></i>&nbsp;<?=$message?>
			</div><?php
		}
	?>
	</div>
</div>

<div id="adddiv" class="panel" style="display:none">

<div class="row">
	<div class="col-md-11">
	</div>
	<div class="col-md-1">
		<div id="closeaddiv" style="width: 100%; text-align: right; font-size: 18px; cursor: pointer">&#10005;</div>
	</div>
</div>
<div class="row">
<div class="col-md-1">
Name
</div>
<div class="col-md-3">
<input type="text" name="quizbankname" id="quizbankname" placeholder="Name" value="" />
<input type="hidden" name="quiz_id" id="quiz_id" value="" />
</div>
</div>

<div class="row">
<div class="col-md-12 text-center">
<input type="submit" id="addbutton" class="btn btn-warning" value="Submit" />
</div>
</div>

<div id="messaging" style="display: none">
<div class="row">
<div class="col-md-12" style="border: 1px solid #faa">
	<p id="messagingitem"></p>
</div>
</div>
</div>

</div><!--#addiv-->


<div class="row">
<div class="col-md-12">
<table id="quizbanktable" class="table table-hover">
	<thead>
	<tr>
		<th>Name</th>
		<th>Sample Question</th>
		<th>Edit</th>
	</tr>
	</thead>
	<tbody>

<?php
	if (sizeof($quizbanks) > 0) {
		foreach ($quizbanks as $thisquizbank) {
			?>
	<tr id="quizbank<?=$thisquizbank['quiz_id']?>">
		<td class="namecell"><?=$thisquizbank['name']?></td>
		<td><?=$thisquizbank['qtext']?></td>
		<td><a href="/admin/editquiz/<?=$thisquizbank['quiz_id']?>" class="btn btn-sm btn-default" alt="edit class" title="Edit">Edit</a></td>
<? /*		<td><a href="#" class="delete" alt="delete class" title="delete class"><i class="icon-trash"></i></a></td> */ ?>
	</tr>
			<?php
		}
	} else {
		?><tr><td colspan="6" style="align:center">No Quizbanks yet. You should create one</td></tr><?
	}
?>
	</tbody>
</table>
</div>
</div>

</div><!--container-->

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		
		$('a.addnew').click(function() {
			if (newval = prompt("Create a new question set called", '')) {
				jQuery.ajax({
				    type: 'POST',
				    url: '/api/quizdata/addqset',
				    async: false,
				    data: {
						newname: newval
				    },
					success: function(data, response, xhr){
						if (data['success']) {
							$('#quizbanktable tbody').append('<tr id="quizbank'+data['success']+'"><td class="namecell">'+newval+'</td>//<td></td><td><a href="/admin/editquiz/'+data['success']+'" alt="edit class" title="edit class"><i class="icon-edit"></i>//</a></td><td><a href="#" class="delete" alt="delete class" title="delete class"><i class="icon-trash"><///i></a></td></tr>');
							document.location.href = '/admin/editquiz/'+data['success'];
						}
					}
				});

			}
			return false;
		});

		$('#adder').click(function() {
			clearform();
			$('#adddiv').toggle('slow');
			return false;
		});
		
		$('#assigner').click(function() {
			clearassignment();
			$('#addassignmentdiv').toggle('slow');
			populate();
			return false;
		});
		
		$('#closeaddassignmentdiv').click(function() {
			clearassignment();
			$('#addassignmentdiv').toggle('slow');
			return false;
		});

		$('#closeaddiv').click(function() {
			clearform();
			$('#adddiv').toggle('slow');
			return false;
		});
		
		$(document).on('click', 'a.delete', function(x) {
			if (confirm('Are you sure you want to delete this Quizbank? Cannot be undone.')) {
				var deleterow = $(this).parents('tr').attr('id').replace(/quizbank/,'');
				$.ajax({
					type: "DELETE", 
					url: "/ajax/Quizbank/"+deleterow,
					async: false,
					context: document.body,
					success: function(ed) {
						$('#quizbank'+deleterow).hide('slow').remove();
					},
					error: function(ed) {

					}
				});
			} 
			return false;
		});

		$(document).on('click', 'a.openedit', function(x) {
			var editrow = $(this).parents('tr');
			var editid = editrow.attr('id').replace(/quizbank/,'');
			$('#quiz_id').val(editid);
			$('#quizbankname').val($(editrow).children('td.namecell').html());
			$('#adddiv').toggle('slow');
			return false;
		});
		
		$('#addbutton').click(function() {
			
			$.ajax({
				type: "POST", 
				url: "/ajax/Quizbank",
				async: false,
				data: {
					quiz_id: $('#quiz_id').val(),
					name: $('#quizbankname').val(),
					user_id: <?=$userinfo['id']?>
					},
				context: document.body,
				success: function(ed){
					$('#quizbank'+$('#quiz_id').val()).children('td.namecell').html($('#quizbankname').val());
					$('#adddiv').toggle('fast');
					return false;
				}, 
				error: function(ed) {
					$('#messagingitem').html('There was an error, but we still love you.');
					$('#messaging').show('slow');
					return false;
				}
			});
			return false;
		});
		
	});
	
	function clearform() {
		$('#classname').val('');
		$('#startdate').val('');
		$('#enddate').val('');
		$('#class_id').val('');
	}
	function clearassignment() {
		$('#classname').val('');
		$('#startdate').val('');
		$('#enddate').val('');
		$('#class_id').val('');
	}

	function populate() {
		$.ajax({
			type: "GET", 
			url: "/ajax/Classes/<?=$userinfo['id']?>",
			context: document.body,
			async: false,
			success: function(ed){
				$('#asgmtclass option').remove();
				$('#asgmtclass').append('<option value="">Please Select</option>');
				$(ed['payload']).each(function(x) {
					$('#asgmtclass').append('<option value="'+this['id']+'">'+this['name']+'</option>');
				});
			}, 
			error: function(ed) {
			}
		});

		$.ajax({
			type: "GET", 
			url: "/ajax/Visiocabs/<?=$userinfo['id']?>",
			context: document.body,
			async: false,
			success: function(ed){
				$('#package option').remove();
				$('#package').append('<option value="">Please Select</option>');
				$(ed['payload']).each(function(x) {
					$('#package').append('<option value="'+this['id']+'">'+this['name']+'</option>');
				});
			}, 
			error: function(ed) {
			}
		});
		
	}
	
</script>