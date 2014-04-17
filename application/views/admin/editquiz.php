<!-- <div class="container">
	<div class="row">
		<div class="col-md-12">
			<? if ($backtopackage) { ?>
			<p class="saveback"><a href="/admin/dragdrop/<?=$backtopackage?>" class="btn btn-default">&#171; Save &amp; Return</a></p>
			<? } else { ?>
			<p class="saveback"><a href="/teacher/managequizbanks" class="btn btn-default">&#171; Back to Question Sets</a></p>
			<? } ?> 
		</div>
	</div>
</div> -->

<div class="container">
<div class="row">
	<div class="col-md-12">
		<h2 class="qs">Question Set</h2>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<p><a href="" class="btn btn-lg btn-warning btn-block" id="adder" type="button"><i class="icon-plus icon-white"></i> Add Question</a></p>
	</div>
	<div class="col-md-3">
		<? if ($backtopackage) { ?>
		<p class="saveback"><a href="/admin/dragdrop/<?=$backtopackage?>" class="btn btn-lg btn-default btn-block">&#171; Save &amp; Return</a></p>
		<? } else { ?>
		<p class="saveback"><a href="/teacher/managequizbanks" class="btn btn-default btn-block">&#171; Back to Question Sets</a></p>
		<? } ?>
	</div>
</div>

<div id="adddiv" class="newassign well" style="display: none">

	<div class="row">
		<div id="closeaddiv" style="display:block;float:right;margin-right:12px;font-size:2em;cursor:pointer;">&times;</div>
	</div>

<div class="row">
	<div class="col-md-6">
		<h3>Question</h3>
	</div>
	<div class="col-md-6">
		<h3>Question Type</h3>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="input-group">
		  <input type="text" name="questiont" id="questiont" placeholder="...?" style="width: 500px" class="form-control" value="" />
		  <input type="hidden" name="quizq_id" id="quizq_id" value="" />
		</div>
	</div>
	<div class="col-md-6">
		<select id="questiontype" class="form-control">
			<option value="">&raquo; Select</option>
			<option value="truefalse">True / False</option>
			<option value="multichoice">Multipile Choice</option>
			<option value="infobox">Infobox</option>
		</select>
	</div>
</div>

<br />
<div class="row">
	<div class="col-md-12">
	<h3>Answers &nbsp;&nbsp; <small>Be sure to select the correct answer for Multiple Choice and True/False questions</small></h3>
	</div>
	<div class="col-md-12">
		<table id="answertable">
		</table>
	</div>
</div>
<br />
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
<table id="quiztable" class="table table-bordered">
	<thead>
	<tr>
		<th style="width:70%">Question</th>
		<th class="center">Type</th>
		<th class="center">Edit</th>
		<th class="center">Delete</th>
	</tr>
	</thead>
	<tbody>
<?php
	if (sizeof($quiz) > 0) {
		foreach ($quiz as $k => $thisquiz) {
			?>
	<tr id="quizq<?=$k?>">
		<td class="namecell"><?=$thisquiz['qtext']?></td>
		<td class="qtypecell center"><?=$thisquiz['qtype']?></td>
		<td class="center"><a href="#" class="openedit" alt="edit class" title="edit class"><span class="glyphicon glyphicon-edit"></span></a></td>
		<td class="center"><a href="#" class="delete" alt="delete class" title="delete class"><span class="glyphicon glyphicon-trash"></span></a></td>
	</tr>
			<?php
		}
	} else {
		?>
		<div class="span5 text-center">
		<div class="alert">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  No questions yet. You should create one!
		</div>
		</div>
		<?
	}
?>
	</tbody>
</table>
</div>
</div>

</div><!--container-->

<script type="text/javascript" charset="utf-8">

	jsonanswers = [];
	<? foreach ($quiz as $k=>$v) { ?>
		jsonanswers[<?=$k?>] = <?=json_encode($v['answers']);?>;
	<? } ?>


	$(document).ready(function() {
		
		$('#closeaddiv').click(function() {
			$('#adddiv').hide('swing');
			return false;
		});

		$('#adder').click(function() {
			$('#questiont').val('');
			$('#questiontype').val('');
			$('#quizq_id').val('');
			$('tr[id^="tmpq"]').remove();
			$('#adddiv').show('swing');
			return false;
		});

		$('#addbutton').click(function() {
			var answers = [];
			var responses = [];
			var i = 0;
			var j = 0;
			$('td.answercell').each(function(e) {
				answers[i] = $(this).html();
				i++;
			});
			if ($('td.responsecell').length > 0) {
				$('td.responsecell').each(function(e) {
					responses[j] = $(this).html();
					j++;
				});
			} else {
				$('.newestqresp').each(function(e) {
					responses[j] = $(this).val();
					j++;
				});
			}
			if($('#questiontype').val() != 'infobox' && !$('input[name="correctans"]:checked').length) {
				alert('please select a correct answer');
				return false;
			}
			$.ajax({
				type: "POST", 
				url: "/ajax/Question/"+$('#quizq_id').val(),
				async: false,
				data: {
					qtext: $('#questiont').val(),
					qtype: $('#questiontype').val(),
					answeroptions: answers,
					responseoptions: responses,
					correctanswer: $('input[name="correctans"]:checked').val(),
					quiz_id: '<?=intval($quiz_id)?>'
					},
				context: document.body,
				success: function(ed,response){
					if (ed['success'] != '') {
						window.location.href = window.location.href;
					}
					if ($('#quizq'+ed['success']).length) {
						$('#quizq'+ed['success']).children('td.namecell').html($('#questiont').val());
						$('#quizq'+ed['success']).children('td.qtypecell').html($('#questiontype').val());
					} else {
						$('#quiztable tbody').append('<tr id="quizq'+ed['success']+'"><td class="namecell">'+$('#questiont').val()+'</td><td class="qtypecell">'+$('#questiontype').val()+'</td><td><a href="#" class="openedit" alt="edit class" title="edit class"><i class="icon-edit"></i></a></td><td><a href="#" class="delete" alt="delete class" title="delete class"><i class="icon-trash"></i></a></td></tr>');
					}
			
					$('#quizq_id').val('');
					$('#adddiv').toggle('fast');
					return false;
				}, 
				error: function(ed) {
					$('#messagingitem').html('There was an error, but we still love you.');
					$('#messaging').show('slow');
					return false;
				}
			});
			
			
		});

		$(document).on('click', 'a.openedit', function(x) {
			var editrow = $(this).parents('tr');
			var editid = editrow.attr('id').replace(/quizq/,'');
			$('#quizq_id').val(editid);
			$('#questiont').val($(editrow).children('td.namecell').html());
			$('#questiontype').val($(editrow).children('td.qtypecell').html());

			$('#answertable tbody tr').remove();
			if ($(editrow).children('td.qtypecell').html() == 'truefalse') {
				$('#answertable').append('<tr id="theaddrow"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>');
			} else if ($(editrow).children('td.qtypecell').html() == 'infobox') {
				$('#answertable').append('<tr><td><input type="hidden" name="correctans" value="true"></td><td class="answercell">This question type does not need an answer</td><td>&nbsp;</td></tr>');
			} else {
				$('#answertable').append('<tr id="theaddrow"><td>&nbsp;</td><td>&nbsp;</td><td><input type="text" class="form-control" name="newestq" id="newestq"></td><td style="font-weight: bold">&nbsp;&nbsp;response:</td><td class="responsecell"><input type="text" class="form-control newestqresp" name="newestqresp" value="" id="newestqresp"></td><td><a href="#" class="btn btn-sm btn-default" id="thisadder">Add</a></td></tr>');
			}
			var j = 0;
			$(jsonanswers[editid]).each(function(e) {
				if ($(editrow).children('td.qtypecell').html() == 'truefalse') {
					$('#theaddrow').before('<tr id="tmpq'+j+'"><td><input type="radio" name="correctans" value="'+this.atext+'"></td><td style="font-weight: bold">answer:</td><td class="answercell">'+this.atext+'</td><td style="font-weight: bold">&nbsp;&nbsp;response:</td><td class="responsecell"><input type="text" class="form-control newestqresp" name="newestqresp" value="'+this.aresp+'" id=""></td></tr>');

				} else {
					$('#theaddrow').before('<tr id="tmpq'+j+'"><td><input type="radio" name="correctans" value="'+this.atext+'"></td><td style="font-weight: bold">answer:&nbsp;</td><td class="answercell">'+this.atext+'</td><td style="font-weight: bold">response:&nbsp;</td><td class="responsecell">'+this.aresp+'</td><td><a href="#" theansid="'+this.aid+'" class="delanswer btn btn-sm btn-default">Delete</a></td></tr>');


				}
				if (parseInt(this.correct) > 0) {
					$('tr#tmpq'+j+' input:radio').attr('checked','checked');
				}
				j++;
			});


			$('#adddiv').show('slow');
			//$.scrollTop(0);
			return false;
		});
		
		$('#answeradder').click(function() {
			alert($('input[name=correctans]:checked').val());
			
		});
		
		$(document).on('click', '#thisadder', function() {
			$('#theaddrow').before('<tr><td><input type="radio" name="correctans" value="'+$('#newestq').val()+'"></td><td style="font-weight: bold">answer:</td><td class="answercell">'+$('#newestq').val()+'</td><td style="font-weight: bold">Feedback:</td><td class="responsecell">'+$('#newestqresp').val()+'</td><td><a href="#" class="delanswer btn btn-sm btn-default">Delete</a></td></tr>');
			$('#newestq').val('');
			$('#newestqresp').val('');
			return false;
		});
		
		$(document).on('click', 'a.delete', function() {
			var editrow = $(this).parents('tr');
			var editid = editrow.attr('id').replace(/quizq/,'');
			if (confirm("Are you sure you want to delete the question?  This action cannot be undone.")) {
				//ajax call
				$.ajax({
					type: "DELETE", 
					url: "/ajax/Question/"+editid,
					async: false,
					context: document.body,
					success: function(ed,response,xhr){
						if (xhr.status == '204') {
							$(editrow).remove();
						}
						return false;
					}, 
					error: function(ed) {
						return false;
					}
				});

				
			} else {
				return false;
			}
			return false;
		});
		

		$(document).on('click', 'a.delanswer', function() {
			var editrow = $(this).parents('tr');
			var editid = $(this).attr('theansid');
			if (confirm("Are you sure you want to delete the question?  This action cannot be undone.")) {
				//ajax call
				$.ajax({
					type: "DELETE", 
					url: "/ajax/Answer/"+editid,
					async: false,
					context: document.body,
					success: function(ed,response,xhr){
						if (xhr.status == '204') {
							$(editrow).remove();
						}
						return false;
					}, 
					error: function(ed) {
						return false;
					}
				});

				
			} else {
				return false;
			}
			return false;
		});


		$('#questiontype').change(function() {
			$('#answertable tr').remove();
			if ($('#questiontype').val() == 'truefalse') {
				$('#answertable').append('<tr><td><input type="radio" name="correctans" value="true"></td><td class="answercell">true</td><td>&nbsp;</td><td>&nbsp;Feedback:</td><td><input type="text" class="form-control newestqresp" name="newestqresp" id=""></td></tr>');
				$('#answertable').append('<tr><td><input type="radio" name="correctans" value="false"></td><td class="answercell">false</td><td>&nbsp;</td><td>&nbsp;Feedback:</td><td><input type="text" class="form-control newestqresp" name="newestqresp" id=""></td></tr>');
			} else if($('#questiontype').val() == 'infobox') {
				$('#answertable').append('<tr><td><input type="hidden" name="correctans" value="true"></td><td class="answercell">This question type does not need an answer</td><td>&nbsp;</td></tr>');
			} else if($('#questiontype').val() == 'multichoice') {
				$('#answertable').append('<tr id="theaddrow"><td>&nbsp;</td><td>Answer:</td><td><input type="text" class="form-control" name="newestq" id="newestq"></td><td>&nbsp;Feedback:</td><td><input type="text" class="form-control" name="newestqresp" id="newestqresp"></td><td><a href="#" class="btn btn-sm btn-default" id="thisadder">Add</a></td></tr>');
			}
		})
	});

	
</script>