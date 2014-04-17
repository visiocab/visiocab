<div class="container">
<div class="row">
	<div class="col-md-12">
		<h2 class="yg">Your Groups</h2>
	</div>
</div>

<div class="row">
<div class="col-md-12">
	<a href="" class="btn btn-lg btn-default" id="adder" type="button"><i class="icon-plus"></i> Add Group</a>
</div>
</div>

<div id="adddiv" class="well newassign" style="display:none">
<div class="row">
	<div class="col-md-12">
		<div id="closeaddiv" style="display:block;float:right;margin-right:12px;font-size:2em;cursor:pointer;">&times;</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="input-group" id="cn">
		  <span class="input-group-addon">Group&nbsp;Name</span>
		  <input type="text" class="form-control" name="classname" id="classname" placeholder="Group" value="" />
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-center">
		<input type="submit" id="addbutton" class="btn btn-warning" value="Submit" />
	</div>
</div>
<div id="messaging" style="display: none">
<div class="row">
	<div class="col-md-12">
		<p id="messagingitem"></p>
	</div>
</div>
</div>

</div><!--#addiv-->


<div class="row">
<div class="col-md-12">
<table id="classtable" class="table table-hover">
	<tr>
		<th>Group</th>
		<th>Visiocabs</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>

<?php
	if (sizeof($classes) > 0) {
		foreach ($classes as $thisclass) {
			?>
	<tr id="class<?=$thisclass['id']?>">
		<td class="namecell"><?=$thisclass['name']?></td>
		<td class=""></td>
		<td><a href="#" class="openedit btn btn-sm btn-default" alt="edit class" title="edit class">Edit</a></td>
		<td><a href="#" class="delete btn btn-sm btn-default" alt="delete class" title="delete class">Delete</a></td>
	</tr>
			<?php
		}
	} else {
		?>
		<div class="span5 text-center">
		<div class="alert">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  No classes yet. You should create one!
		</div>
		</div>
		<?
	}
?>
</table>
</div>
</div>

<div id="push-bottom"></div>

</div><!--container-->

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#adder').click(function() {
			clearform();
			$('#adddiv').toggle('swing');
			return false;
		});
		
		$('#assigner').click(function() {
			clearassignment();
			$('#addassignmentdiv').toggle('swing');
			populate();
			return false;
		});
		
		$('#closeaddassignmentdiv').click(function() {
			clearassignment();
			$('#addassignmentdiv').toggle('swing');
			return false;
		});

		$('#closeaddiv').click(function() {
			clearform();
			$('#adddiv').toggle('swing');
			return false;
		});
		
		$(document).on('click', 'a.delete', function(x) {
			if (confirm('Are you sure you want to delete this class? Cannot be undone.')) {
				var deleterow = $(this).parents('tr').attr('id').replace(/class/,'');
				$.ajax({
					type: "DELETE", 
					url: "/ajax/Class/"+deleterow,
					async: false,
					context: document.body,
					success: function(ed) {
						$('#class'+deleterow).hide('slow').remove();
					},
					error: function(ed) {

					}
				});
			} 
		});

		$(document).on('click', 'a.openedit', function(x) {
			var editrow = $(this).parents('tr');
			var editid = editrow.attr('id').replace(/class/,'');
			$('#class_id').val(editid);
			$('#classname').val($(editrow).children('td.namecell').html());
			$('#adddiv').toggle('slow');
			return false;
		});
		
		$(document).on('click', 'a.asgndel', function(x) {
			if (confirm('Are you sure you want to delete this assignment? Cannot be undone.')) {
				var deleterow = $(this).parents('tr').attr('id').replace(/assignment/,'');
				$.ajax({
					type: "DELETE", 
					url: "/ajax/Assignment/"+deleterow,
					async: false,
					context: document.body,
					success: function(ed) {
						$('#assignment'+deleterow).hide('slow').remove();
					},
					error: function(ed) {

					}
				});
			} 
			return false;
		});
		
		$(document).on('click', 'a.asgnedit', function(x) {
			populate();
			var editrow = $(this).parents('tr');
			var editid = editrow.attr('id').replace(/assignment/,'');
			$('#assignment_id').val(editid);
			$('#assignmentname').val($(editrow).children('td.namecell').html());
			$('#asstartdate').val($(editrow).children('td.startdatecell').html());
			$('#asenddate').val($(editrow).children('td.enddatecell').html());
//			$("#package option").filter(function() {
//			    return $(this).text() == $(editrow).children('td.pkgcell').html(); 
//			}).prop('selected', true);
			$('#package').val($(editrow).children('td.pkgcell').attr('packageid'));
			$('#asgmtclass').val($(editrow).children('td.clscell').attr('classid'));
			$('#addassignmentdiv').toggle('slow');
			return false;
		});
		
		$('#asaddbutton').click(function() {
			
			$.ajax({
				type: "POST", 
				url: "/ajax/Assignment",
				async: false,
				data: {
					assignment_id: $('#assignment_id').val(),
					assignmentname: $('#assignmentname').val(),
					startdate: $('#asstartdate').val(),
					enddate: $('#asenddate').val(),
					package_id: $('#package').val(),
					class_id: $('#asgmtclass').val(),
					user_id: <?=$userinfo['id']?>
					},
				context: document.body,
				success: function(ed){
					if ($('#assignment'+ed['success']).length) {
						$('#assignment'+ed['success']).children('td.namecell').html($('#assignmentname').val());
						$('#assignment'+ed['success']).children('td.startdatecell').html($('#asstartdate').val());
						$('#assignment'+ed['success']).children('td.enddatecell').html($('#asenddate').val());
						$('#assignment'+ed['success']).children('td.pkgcell').html($('#package option:selected').text());
						$('#assignment'+ed['success']).children('td.clscell').html($('#asgmtclass option:selected').text());
						$('#assignment'+ed['success']).children('td.pkgcell').attr('packageid', $('#package option:selected').val());
						$('#assignment'+ed['success']).children('td.clscell').attr('classid',$('#asgmtclass option:selected').val());
					} else {
						$('#assignmenttable').append('<tr id="assignment'+ed['success']+'"><td class="namecell">'+$('#assignmentname').val()+'</td><td class="pkgcell" packageid="'+$('#package option:selected').val()+'">'+$('#package option:selected').text()+'</td><td class="clscell" classid="'+$('#asgmtclass option:selected').val()+'">'+$('#asgmtclass option:selected').text()+'</td><td class="startdatecell">'+$('#asstartdate').val()+'</td><td class="enddatecell">'+$('#asenddate').val()+'</td><td><a href="#" class="asgnedit" alt="edit assignment" title="edit student"><i class="icon-edit"></i></a></td><td><a href="#" class="asgndel" alt="delete assignment" title="delete student"><i class="icon-trash"></i></a></td></tr>');
					}
					$('#addassignmentdiv').toggle('fast');
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
		
		$('#addbutton').click(function() {
			
			$.ajax({
				type: "POST", 
				url: "/ajax/Class",
				async: false,
				data: {
					class_id: $('#class_id').val(),
					classname: $('#classname').val(),
					user_id: <?=$userinfo['id']?>
					},
				context: document.body,
				success: function(ed){
					if ($('#class'+ed['success']).length) {
						$('#class'+ed['success']).children('td.namecell').html($('#classname').val());
					} else {
						$('#classtable').append('<tr id="class'+ed['success']+'"><td class="namecell">'+$('#classname').val()+'</td><td>add</td><td><a href="#" class="openedit" alt="edit class" title="edit class"><i class="icon-edit"></i></a></td><td><a href="#" class="delete" alt="delete class" title="delete class"><i class="icon-trash"></i></a></td></tr>');
					}
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
		$('#class_id').val('');
	}
	function clearassignment() {
		$('#classname').val('');
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