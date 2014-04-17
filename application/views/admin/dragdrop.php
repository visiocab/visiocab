<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css" type="text/css" media="all" /> 
<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" /> 
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript"></script> 
<? /* <script src="/js/jquery.json-2.4.js" type="text/javascript"></script>  */ ?>
<script src="/js/json2.js" type="text/javascript"></script>

<div class="container">
<div id="visiocab-meta">
<div class="row">
<div class="col-md-4">
<div class="panel panel-default">
	<div class="panel-heading">
		<h1 class="panel-title">Visiocab Information</h1>
	</div>
	<div class="panel-body">
		<ul class="list-group">
		  <li class="list-group-item">
			<span class="badge">Visiocab</span>
			<?=$packageinfo['package_name']?>
		  </li>
		  <li class="list-group-item">
			<span class="badge">Media</span>
			<?=$tour['tname']?> / <?=$tour['sname']?>
		  </li>
		</ul>
	</div>
</div>
</div>
<div class="col-md-4">
<div class="panel panel-default">
	<div class="panel-heading">
		<h1 class="panel-title">Sharing Options</h1>
	</div>
	<div class="panel-body">
		<label for="link">Link it</label>
		<input type="text" id="link" class="form-control" value="http://<?=$_SERVER['HTTP_HOST']?>/display/<?=$package_id?>">
		<label for="input">Embed it</label>
		<textarea class="form-control">
<iframe src="http://<?=$_SERVER['HTTP_HOST']?>/display/<?=$package_id?>" style="border: 0px; width: 100%; height: 400px"></iframe>
		</textarea>
	</div>
</div>
</div>
<div class="col-md-4">
<div class="panel panel-default">
	<div class="panel-heading">
		<h1 class="panel-title">Tags</h1>
	</div>
	<div class="panel-body">
		<h5 class="available"><input type="checkbox" name="is_public" <?=($packageinfo['is_public'])?'checked="checked"' : ''?> id="is_public" />&nbsp;&nbsp;Make this Visiocab publicly available</h5>
	<div class="row">
	<div class="col-md-12 tagfield">
		<div class="input-group">
		  <span class="input-group-addon">New Tag:</span>
		  <input type="text" class="form-control" id="tagadd" placeholder="Name">
		  <span class="input-group-btn">
		  	<button type="button" class="btn btn-default" id="tagadder">Create</button>
		  </span>
		</div>
	</div>
	<div class="col-md-12">
	<ul id="taglist">
		<? foreach ($tags as $thist) { ?>
			<li class="label label-default" id="tag<?=$thist?>"><?=$thist?>&nbsp;<a href="#" class="deltag text-right" data-toggle="tooltip" data-placement="top" title="remove">&times;</a></li>
		<? } ?>
	</ul>
	</div>
	</div>
	</div>
</div>
</div>
</div><!--.row-->
</div><!--#visiocab-meta-->

<div class="row">
<div class="span12">
	<h3>Place Your Questions &nbsp;&nbsp;&nbsp; <a class="btn btn-default" name="qadder" onclick="window.location.href = '/admin/editquiz/<?=$quiz_id?>/<?=$package_id?>';" id="qadder" value="Edit Questions">Edit/Add Questions</a></h3>
</div>
</div> 

<div class="row">
<div class="span12">


<div id="morestuff" >
<div style="height: 210px; position: relative; overflow: auto; z-index:1000">
 	<div style="width: 30%; height: 210px;  float: left;">
	<?php
	$counter = 1;
	$limit = ceil(sizeof($quiz)/3);
	foreach($quiz as $q_id=>$question) {
#		print '<option value="'.$q_id.'">'.$question['qtext'].'</option>';
		?>
		<div class="btn question">
		<div class="opts" id="opt<?=$q_id?>" theqid="<?=$q_id?>" style="display: inline"> 

		<input type="hidden" name="abbrev<?=$q_id?>" id="abbrev<?=$q_id?>" value="<?=$question['questionabbrev']?>">
		 <span id="qtext<?=$q_id?>" class="label label-default">&#8689; <?=$question['questionabbrev']?></span>
		 <input type="hidden" name="hqtext<?=$q_id?>" id="hqtext<?=$q_id?>" value="<?=preg_replace('/"/','',$question['qtext'])?>" />
		</div>
		<input type="hidden" name="package_id" id="package_id" value="<?=$package_id?>" />
		<input type="hidden" name="quiz_id" id="quiz_id" value="<?=$quiz_id?>" />
		<input type="hidden" name="tour_id" id="tour_id" value="<?=$tour_id?>" />

		<input type="hidden" class="coordlist" name="coordx<?=$q_id?>" id="coordx<?=$q_id?>" value="" />
		<input type="hidden" class="coordlist" name="coordy<?=$q_id?>" id="coordy<?=$q_id?>" value="" />
		<input type="hidden" class="coordlist" name="pan<?=$q_id?>" id="pan<?=$q_id?>" value="" />
		<input type="hidden" class="coordlist" name="tilt<?=$q_id?>" id="tilt<?=$q_id?>" value="" />
		<input type="hidden" class="coordlist qord" theord="<?=$q_id?>" name="qorder<?=$q_id?>" id="qorder<?=$q_id?>" value="" />
		</div><br />
		<?php
		if ($counter%$limit == 0) {
			?>
</div>
<div style="width: 30%;  float: left">
			<?
		}
		$counter++;
	}
	?>
	</div>

</div>
<div id="stuff" style="width: 1170px; position: relative;">
<!--	<div id="optone" style="position: absolute; left: 0; top: 0; border: 1px solid #ccc; width: 100px height: 40px;">one</div> -->

<!--	<div id="opttwo" style="position: absolute; left: 0; top: 50px; border: 1px solid #ccc; width: 100px height: 40px;">two</div> -->
	<div id="intobox" style="position: relative; top: 0; width: 1170px; height: <?=$imgh?>px; border: 1px solid black">
		<? 
			list($imgw, $imgh, $junk, $imgarg) = getimagesize($_SERVER['DOCUMENT_ROOT'].$tour['composite']); 
			if ($imgw > $imgh) {
				$image_limit = 'width="1170"';
			} else {
				$image_limit = 'height="686"';
			}
		?>
		<img src="/phpThumb/phpThumb.php?src=<?=$tour['composite']?>&amp;h=686&amp;w=1170" id="bigimage"  <?=$image_limit?> />
		<? /* <img src="/phpThumb/phpThumb.php?src=<?=$tour['composite']?>&amp;h=686&amp;w=1024" id="bigimage" <?=$imgarg?> /> */ ?>
		<div id="pointer" style="top: 0; left: 0; border: 1px solid #ccc; background: white; position: absolute; display: none; z-index: 100;">&lt; You are here</div>
	</div>

</div>
</div>

</div>
</div>

<div class="row">
<div class="col-md-12">
	<div class="spd">
		<div class="btn-group btn-group-lg btn-group-justified">
			<a type="button" name="checker" class="btn btn-warning" id="checker" value="Save Progress"><i class="icon-hdd icon-white"></i> Save Progress</a>
			<a type="button" class="btn btn-default" name="previewer" onclick="window.open('/display/preview/<?=$package_id?>');" id="previewer" value="Preview"><i class="icon-eye-open"></i> Preview</a>
			<a type="button" class="btn btn-default" name="deleter" id="deleter" value="Delete"><i class="icon-trash"></i> Delete</a>
		</div>
	</div>
</div>
</div>

</div><!--container-->


<script type="text/javascript" charset="utf-8">
	$( init );
	var counter = 1;
	var ppos = $('#stuff').position();
	var pcpos = $('#intobox').position();
	var leftoffset = parseInt(ppos.left + pcpos.left);
	var topoffset = parseInt(ppos.top + pcpos.top);
//	var leftoffset = 0;
//	var topoffset = 0;
	var standardopts = {
			'containment' : '#intobox',
			'cursor' : 'move', 
			scroll: false,
			helper: myHelper,
			stop : handleDragStop,
			disabled : false
		};
	var droppedopts = {
			'containment' : '#intobox',
			'cursor' : 'move', 
			scroll: false,
			helper: myHelper,
			stop : handleDroppedStop,
			disabled : false
		};
	
	$(document).ready(function() {
		

		$('#is_public').click(function() {
			$.ajax({
			    type: 'PUT',
			    url: '/ajax/visiocab/<?=$package_id?>/'+$('#is_public').is(':checked'),
			    async: false,
				success: function(data, response, xhr){
					if (response == 200) {
						alert('public setting stored');
					}
				}
			});
			
		});

		
		$(document).on('click', 'a.deltag', function() {
			var tagblock = $(this).parents('li');
			var tagtoadd = tagblock.attr('id').replace(/tag/,'');
			$.ajax({
				type: "POST",
				url: "/ajax/TagDel/"+tagtoadd,
				data: { 
					package_id : '<?=$package_id?>'
				},
				success: function(msg) {
					tagblock.remove();
				}
			});
			return false;
		});

		$('#tagadder').click(function() {
			var tagtoadd = $('#tagadd').val();
			if ($('#tag'+tagtoadd).length > 0) {
				alert('tag already added');
				return false;
			}
			
			$.ajax({
				type: "POST",
				url: "/ajax/Tag/"+tagtoadd,
				data: { 
					package_id : '<?=$package_id?>'
				},
				success: function(msg) {
					$('#taglist').append('<li class="tag" id="tag'+tagtoadd+'">'+tagtoadd+'&nbsp;<a href="#" class="deltag">x</a></li>');
					$('#tagadd').val('');
				}
			});
			return false;
		});

		
		
		// loading already selected hotspots
		<?php foreach ($package as $k => $v) {
			$k2 = $v['question_id'];?>
			var $newdiv<?=$k2?> = creatediv(<?=$k2?>, true);
			$newdiv<?=$k2?>.children('div.hider').children('span.qdisplay').html($('#qtext'+<?=$k2?>).html());
			$newdiv<?=$k2?>.children('h4.step').html('<?=$v['questionabbrev']?> <span class="glyphicon glyphicon-edit"></span>');

			$('#intobox').append($newdiv<?=$k2?>);
			$('#pan<?=$v['question_id']?>').val('<?=$v['pan']?>');
			$('#tilt<?=$v['question_id']?>').val('<?=$v['tilt']?>');
			$('#coordx<?=$v['question_id']?>').val('<?=$v['coordx']?>');
			$('#coordy<?=$v['question_id']?>').val('<?=$v['coordy']?>');
			$('#qorder<?=$v['question_id']?>').val(counter);
			$newdiv<?=$k2?>.css('top',<?=$v['coordy']?>).css('left',<?=$v['coordx']?>);
			$( ".dopts" ).draggable(droppedopts);
			$( "#opt<?=$v['question_id']?>" ).parent().addClass('used');
			counter++;

		<? } ?>
		
		counter = getNextNumber();
		
		$(document).on('click','div.droppedlink', function() {
		});
		
		$(document).on('click', 'a.closer', function(x) {
			if (confirm('are you sure you want to delete this?')) {
				var thedqid = $(this).attr('thedqid');
				$('#opt'+thedqid).parent().removeClass('used');
				$('#qorder'+thedqid).val('');
				$(this).parent().remove();
				$( "#opt"+thedqid ).draggable(standardopts);
				counter = getNextNumber();
				return false;
			} else {
				return false;
			}
		});

		$(document).on('click', 'a.closerx', function(x) {
			if (confirm('are you sure you want to remove this item?')) {
				var thedqid = $('#idtosave').val();
				$('#opt'+thedqid).parent().removeClass('used');
				$('#qorder'+thedqid).val('');
				//console.log($('.droppedlink[theqid="'+thedqid+'"]').html());
				$('.droppedlink[theqid="'+thedqid+'"]').remove();
				$( "#opt"+thedqid ).draggable(standardopts);
				counter = getNextNumber();
				$('#myModal').modal('hide');
				return false;
			} else {
				return false;
			}
		});
		
		$('#checker').click(function() {
			saveProgress();
		});
		
		$('#deleter').click(function() {
			if (confirm('are you sure you want to delete the Visiocab?')) {
				$.ajax({
					type: "DELETE",
					url: "/ajax/visiocab/<?=$package_id?>",
					success: function(ed,response,xhr){
						if (xhr.status == '204') {
							alert('delete successful');
							window.location = '/teacher';
						}
						return false;
					}
				});
			} else {
				return false;
			}
		});
		$('#modalsaver').click(function() {
			$('#aftertext'+$('#idtosave').val()).val($('#aftertextstart').val());
			$('#myModal').modal('hide');
		});
		$(document).on('click', 'h4.step', function(x) {
			$('opts,dopts').css('zIndex','100');
//			console.log($(this).next('div.hider').html());
			var tomove = $(this).next('div.hider');
			var mynum = $(this).parents('div.droppedlink').attr('theqid');
			$('#idtosave').val(mynum);
			$('#aftertextstart').val($('#aftertext'+mynum).val());
			$('#questiontextmodal').html($('#hqtext'+mynum).val());
			$('#myModal').modal('show');
			
		});

		$('input.newstep').on('change', function() {
			var newval = $(this).val();
			if ($('input.qord[value="'+newval+'"]').length) {
				alert('taken, so '+parseInt(newval)+' becomes '+(parseInt(newval)+1)+' and so on');
				// foreach h4
				$('input.qord').each(function(e) {
					if ($(this).val() > 0 && $(this).val() >= newval) {
						var oldnum = parseInt($(this).val());
						$(this).val(oldnum+1);
						$('div#object'+oldnum+' h4.step').html('Step '+(oldnum+1));
						$('div#object'+oldnum+' input.newstep').val((oldnum+1));
					} //else if ($(this).val() > 0 && $(this).val() >= newval) {
				});
				// if this h4 is less than newval leave it alone
				// if it's equal or greater than, add one to it
				// change this one to newval
			} else {
				alert('available, so we just insert '+newval);
			}
			// make this the new step number for this element
			// everything >= this number gets increased by 1
		});


	});
	
	function init() {
		
	  $('.opts').draggable(standardopts);
	  $('.droppedlink').draggable(standardopts);
	}
	
	function myHelper( event ) {
	  return '<div id="draggableHelper" style="z-index:3000">&#8689; Drop</div>';
	}
	
	function dropper(x,y) {
//		console.log(x+' x '+y);
	}
	
	function handleDragStop( event, ui ) {
		$('#intobox').height($('#bigimage').height());
		var movedobj = $('#'+$(this).attr('id'));
		$(this).parent().addClass('used');
		var theqid = $(this).attr('theqid');
		var theabbrev = $('#abbrev'+theqid).val();
		//console.log($('#abbrev'+theqid));
		var xval = parseInt( ui.offset.left );
		var yval = parseInt( ui.offset.top );

		var xthing = $(movedobj).position();
		var xthingoffset = parseInt(ppos.left);
		
		
		var img_height = $('#bigimage').height();
		var img_width = $('#bigimage').width();
		var panvalue = parseInt(180 - (360*((xval-leftoffset) / img_width)));

		<? if ($packageinfo['is_other'] || $packageinfo['flat_media'] == 0) {
			# for flat media, to better reflect the right y axis
			?>
			var tiltvalue = parseInt(90-(180*((yval-topoffset) / img_height)));
			<?
		} else {
			# for flat media panos, which can't go all the way up or down
			?>
			var tiltvalue = parseInt(32.5-(65*((yval-topoffset) / img_height)));
			<? 
		} ?>
		
		
		$('#coordx'+theqid).val((xval-leftoffset));
		$('#coordy'+theqid).val((yval-topoffset));
		$('#pan'+theqid).val(panvalue);
		$('#tilt'+theqid).val(tiltvalue);
		$('#qorder'+theqid).val(counter);
		var $newdiv1 = creatediv(theqid); 
		//console.log('x = '+(xval-leftoffset));
		//console.log('y = '+yval+' - '+topoffset+' = '+(yval-topoffset));



		$('#intobox').append($newdiv1);
		$newdiv1.css('top',(yval-topoffset)).css('left',xval-leftoffset);
		$newdiv1.children('div.hider').children('span.qdisplay').html($('#qtext'+theqid).html());
		$newdiv1.children('h4.step').html(theabbrev+'<span class="glyphicon glyphicon-edit"></span>');
		$( "#opt"+theqid ).draggable({ disabled: true });
		$('#object'+counter+' div.opts').draggable(droppedopts);
		counter = getNextNumber();
	}

	function handleDroppedStop( event, ui ) {
		$('#intobox').height($('#bigimage').height());
		var movedobj = $('#'+$(this).parent().attr('id'));
		var theqid = $(movedobj).attr('theqid');

		var xval = parseInt( ui.offset.left );
		var yval = parseInt( ui.offset.top );
		var img_height = $('#bigimage').height();
		var img_width = $('#bigimage').width();
		var panvalue = parseInt(180 - (360*((xval-leftoffset) / img_width)));


		<? if ($packageinfo['is_other'] || $packageinfo['flat_media'] == 0) {
			# for flat media, to better reflect the right y axis
			?>
			var tiltvalue = parseInt(90-(180*((yval-topoffset) / img_height)));
			<?
		} else {
			# for flat media panos, which can't go all the way up or down
			?>
			var tiltvalue = parseInt(32.5-(65*((yval-topoffset) / img_height)));
			<? 
		} ?>
		
		
		$('#coordx'+theqid).val((xval-leftoffset));
		$('#coordy'+theqid).val((yval-topoffset));
		$('#pan'+theqid).val(panvalue);
		$('#tilt'+theqid).val(tiltvalue);
		
		$(movedobj).css('top',(yval-topoffset)).css('left',xval-leftoffset);
		
		return;

		$(this).parent().addClass('used');
		var theqid = $(this).attr('theqid');
		var xval = parseInt( ui.offset.left );
		var yval = parseInt( ui.offset.top );
		var img_height = $('#bigimage').height();
		var img_width = $('#bigimage').width();
		var panvalue = parseInt(180 - (360*((xval-leftoffset) / img_width)));
		var tiltvalue = parseInt(90-(180*((yval-topoffset) / img_height)));
		
		$('#coordx'+theqid).val((xval-leftoffset));
		$('#coordy'+theqid).val((yval-topoffset));
		$('#pan'+theqid).val(panvalue);
		$('#tilt'+theqid).val(tiltvalue);
		$('#qorder'+theqid).val(counter);
		var $newdiv1 = creatediv(theqid);

		$('#intobox').append($newdiv1);
		$newdiv1.css('top',(yval-topoffset)).css('left',xval-leftoffset);
		$( "#opt"+theqid ).draggable({ disabled: true });
		counter = getNextNumber();
	}

	
	function saveProgress() {
		var sendval = [];
//		sendval['id'] = 243;
//		sendval['qs'] = [];
		var panvals = [];
		var tiltvals = [];
		var coordxvals = [];
		var coordyvals = [];
		var aftervals = [];
		var totalvals = [];
		$('.qord').each(function(i) {
			if ($(this).val()*1) {
				var thisone = $(this).attr('theord');
				//totalvals[i] = '"'+thisone+'": {"pan":"'+$("#pan"+thisone).val()+'", "tilt":"'+$("#tilt"+thisone).val()+'", "x":"'+$("#coordx"+thisone).val()+'", "y":"'+$("#coordy"+thisone).val()+'", "aftertext":"'+$('#aftertext'+thisone).val()+'" }';


				var jsonObj = { 
					id: thisone, 
					pan: $("#pan"+thisone).val(), 
					tilt: $("#tilt"+thisone).val(), 
					x: $("#coordx"+thisone).val(), 
					y: $("#coordy"+thisone).val(), 
					aftertext: $('#aftertext'+thisone).val()
				}; //declare object

				var tmpjunk = JSON.stringify(jsonObj);
				totalvals[i] = tmpjunk;
				sendval[$(this).val()] = thisone;
				panvals[thisone] = $("#pan"+thisone).val();
				tiltvals[thisone] = $("#tilt"+thisone).val();
				coordxvals[thisone] = $("#coordx"+thisone).val();
				coordyvals[thisone] = $("#coordy"+thisone).val();
				aftervals[thisone] = $('#aftertext'+thisone).val();
			}
		});
		//totalvals += ' }';
		var myJsonString = JSON.stringify(totalvals);
		//var myJsonString = $.toJSON( totalvals );
		$.ajax({
			type: "POST",
			url: "/ajax/saveProgress",
			data: { 
				package_id : $('#package_id').val(),
				theinfo: myJsonString,
			},
			success: function(msg) {
				alert('Progress saved.');
			}
		});

	}

/*
formerly sending ridiculous giant arrays in the ajax call
				values : sendval,
				tiltvals : tiltvals,
				panvals : panvals,
				coordxvals : coordxvals,
				coordyvals : coordyvals,
				aftervals : aftervals
*/
	
	function getCount() {
//		console.log();
	}
	
	function getNextNumber(setit) {
		for (i = 1; i <= 100; i++) {
			if ($('#object'+i).length == 0) {
				counter = i;
				return i;
			}
		}
	}
	
	function creatediv(theqid, alreadydropped) {
		if (alreadydropped) {
			theclass = 'dopts';
		} else {
			theclass = 'opts';
		}
		return $('<div class="droppedlink" id="object'+counter+'" theqid="'+theqid+'" style="width:185px;padding:4px;"><div class="'+theclass+'"  style="width: auto; display: inline; cursor: move"><i class="dropperbox"></i></div> <h4 class="step"></h4></div>');
		// was <a class="closer" thedqid="'+theqid+'" style="position: absolute; top: 0; right: 0" href="#"><i class="icon-remove"></i></a>
	}
</script>


  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Edit item</h4>
        </div>
        <div class="modal-body">
        	<h5>Question text</h5>
        	<p id="questiontextmodal"></p>
        	
            <a href="/admin/editquiz/<?=$quiz_id?>/<?=$package_id?>">Edit Question Set</a>
          <input type="hidden" id="idtosave" name="idtosave" value="" />
        </div>
        <div class="modal-footer">
          <a href="#" class="closerx btn btn-danger" style="float:left">Delete</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

