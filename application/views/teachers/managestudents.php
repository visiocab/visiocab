<div class="row-fluid">
<div class="span12">
<h2>Students</h2>
<p><a href="/teacher/addstudents" class="btn btn-large btn-warning" type="button"><i class="icon-user icon-white"></i> Add Student</a></p>
</div>
</div>

<div class="row-fluid">
<div class="span12">
<table class="table table-hover">
	<tr>
		<th>Last Name</th>
		<th>First Name</th>
		<th>Email</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>

<?php
	foreach ($students as $thisstudent) {
		?>
<tr id="student<?=$thisstudent['id']?>">
	<td><?=$thisstudent['last_name']?></td>
	<td><?=$thisstudent['first_name']?></td>
	<td><a href="mailto:<?=$thisstudent['email']?>"><?=$thisstudent['email']?></a></td>
	<td><a href="/teacher/editstudent/<?=$thisstudent['id']?>" alt="edit student" title="edit student"><i class="icon-edit"></i></a></td>
	<td><a href="#" class="deleter" alt="delete student" title="delete student"><i class="icon-trash"></i></a></td>
</tr>
		<?php
	}
?>
</table>
</div>
</div>

<div id="push-bottom"></div>

</div><!--container-->

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('.deleter').click(function() {
			if (confirm('Are you sure you want to delete this class? Cannot be undone.')) {
				var deleterow = $(this).parents('tr').attr('id').replace(/student/,'');
				$.ajax({
					type: "DELETE", 
					url: "/ajax/Student/"+deleterow,
					async: false,
					context: document.body,
					success: function(ed) {
						$('#student'+deleterow).hide('slow').remove();
					},
					error: function(ed) {

					}
				});
			} 
			return false;
		});
	});
	
</script>