<? /* teachers */ ?>
<style>
h2 {
	margin: 1em 0;
}
.button {
	margin: 1em 0;
}
</style>

<div id="visiocab-header">
<div class="container">
<div class="row">
	<div class="col-md-12">
		<div class="title">
			<h1>
				Your Visiocabs
				<div class="buildit">
					<a href="/admin/start" class="btn btn-lg btn-warning" type="button">Build a Visiocab</a>
				</div>
			</h1>
		</div>
	</div>
</div>
</div>
</div>

<div class="container">
<div class="row">
<div class="col-md-12">

<div class="row">
	<? if (sizeof($current_packages) > 0) {
	foreach($current_packages as $thispackage) { ?>
<div class="col-md-4" id="package<?=$thispackage['xpackageid']?>">
<div class="panel panel-default">
	<?
	if (is_file($_SERVER['DOCUMENT_ROOT'].$thispackage['thumbnail'])) {
		$timage = "/phpThumb/phpThumb.php?src=".$thispackage['thumbnail']."&h=70&w=280&zc=1";
	} elseif (is_file($_SERVER['DOCUMENT_ROOT'].$thispackage['media'])) {
		$timage = "/phpThumb/phpThumb.php?src=".$thispackage['media']."&h=70&w=280&zc=1";
	} else {
		$timage = "/img/icon.png";
	}
	?>
	<div class="panel-body" id="visiocab">
		<div class="vicon" >
			<img src="<?=$timage?>" class="img-thumbnail" />
		</div>
		<ul class="list-group">
		  <li class="list-group-item">
			<span class="badge">Visiocab</span>
			<?=$thispackage['xpackagename']?>
		  </li>
		  <li class="list-group-item">
			<span class="badge">Media</span>
			<?=$thispackage['xscenename']?>
		  </li>
		</ul>
	</div>
	<div class="panel-footer">
		<div class="btn-group btn-group-justified">
		  <a href="#" class="sharer btn btn-inverse" data-toggle="modal" data-target="#sharethis" selectedpkgid="<?=$thispackage['xpackageid']?>" alt="export question set" title="Share Visiocab" type="button"><span class="glyphicon glyphicon-share"></span> Share</a>
		  <a href="/admin/dragdrop/<?=$thispackage['xpackageid']?>" class="btn btn-inverse" alt="edit visiocab" title="Edit Visiocab" type="button"><span class="glyphicon glyphicon-edit"></span> Edit</a>
		  <a href="#" class="deleter btn btn-inverse" alt="delete" title="Delete Visiocab" type="button"><span class="glyphicon glyphicon-trash"></span> Delete</a>
		</div>
	</div>
</div>
</div>
	<? } } else { ?>
		<div class="col-md-6 offset-3"><div class="alert alert-warning">No Visiocabs yet. You should create one</div></div>
	<? } ?>
</div>

</div><!--.row-->




</div>
</div>
</div>

<!--sharing modal-->
<div class="modal fade" id="sharethis">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Share This Visiocab</h4>
      </div>
      <div class="modal-body">
        <h4>Link it</h4>
		<p><input id="linker" type="text" style="width: 80%" value="http://<?=$_SERVER['HTTP_HOST']?>/display/<?=$package_id?>"></p>         
		<h4>Embed it</h4>
		<textarea id="embedder" style="width: 80%">
		<iframe src="http://<?=$_SERVER['HTTP_HOST']?>/display/" style="border: 0px; width: 100%; height: 400px"></iframe>
		</textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript" charset="utf-8">
	var theurl = '<?=$_SERVER['HTTP_HOST']?>';
	$(document).ready(function() {
		$('a.deleter').click(function() {
			if (confirm('Are you sure you want to delete this Visiocab? Cannot be undone.')) {
				var deleterow = $(this).closest('div.col-md-4').attr('id').replace(/package/,'');
				$.ajax({
					type: "DELETE", 
					url: "/ajax/visiocab/"+deleterow,
					async: false,
					context: document.body,
					success: function(ed,response,xhr){
						if (xhr.status == '204') {
							$('#package'+deleterow).hide('slow').remove();
						}
						return false;
					},
					error: function(ed) {

					}
				});
			} 
			return false;
		});

	$('a.sharer').click(function() {
		//var d = $(this).parents('div.panel-body').attr('id').replace(/package/,'');
		var d = $(this).attr('selectedpkgid');
		$('#embedder').text('<iframe src="http://'+theurl+'/display/'+d+'" style="border: 0px; width: 100%; height: 400px"></iframe>');
		$('#linker').val('http://'+theurl+'/display/'+d);
		$('#sharethis').modal();
		return false;
	});
	});
	
</script>