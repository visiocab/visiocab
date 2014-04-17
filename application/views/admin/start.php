<!-- styles -->
<link href="../uploadifive/uploadifive.css" rel="stylesheet">
<!-- scripts -->
<script defer src="/js/idangerous.swiper.js"></script>
<script src="/uploadifive/jquery.uploadifive.js" type="text/javascript"></script>

<!-- admin/start -->
<style type="text/css" media="screen">
div.tourbox {
	text-align: center;
	margin-top: 17px;
	margin-bottom: 7px;
	margin-right: 1em;
	margin-left: 1em;
	background: #fff;
	position: relative;
	z-index: 2;
}
div.tourbox img {
	width: 95%;
	margin: 0;
	padding: 7px;
	-webkit-border-radius: 4px!important;
	-moz-border-radius: 4px!important;
	border-radius: 4px!important;
}
img.check {
	display: none;
	-webkit-filter: drop-shadow(12px 12px 25px rgba(0,0,0,0.5));
	filter: url(#drop-shadow);
	-ms-filter: "progid:DXImageTransform.Microsoft.Dropshadow(OffX=12, OffY=12, 
	Color='#444')";
	filter: "progid:DXImageTransform.Microsoft.Dropshadow(OffX=12, OffY=12, 
	Color='#444')";
}
.highlighted {
	border: 1px solid #fbeed5;
	background-color: #fcf8e3;
}
.highlighted img  {
	opacity: 0.47;
}
.highlighted img.check {
	display: block;
	position: absolute;
	z-index: 3;
	opacity: .99;
	height: 100%;
	width: auto;
	margin: 0 auto;
	left: 0;
	right: 0;
	bottom: 0;
}
.horizontal {
	width: 100%; 
	height: 220px!important; 
	padding-top: 2em; 
	background: transparent;
	-webkit-overflow-scrolling: touch;
}
h3 {
	margin-bottom: 33px;
}
</style>

<form method="post" id="bigform" enctype="multipart/form-data" action="/admin/setup">
<input type="hidden" name="whichtour" value="" id="whichtour" />
<input type="hidden" name="isothermedia" value="" id="isothermedia" />
<input type="hidden" name="user_id" value="<?=$userinfo['id']?>" id="user_id" />

<div id="buildsteps">
<div class="container">
<div class="row">
	<div class="col-md-6">
	    <h3><span class="label label-default">1</span> Title</h3>
	    <label for="packagename">Your Visiocab Title</label>
	    <input type="text" name="name" value="" class="form-control" id="packagename" placeholder="An incisive name for your creation">
	</div>
	<div class="col-md-6">
		<h3><span class="label label-default">2</span> Questions</h3>
		<label for="quiz">Question Set</label>
		<div class="row">
			<div class="col-md-6">
				<select name="quiz" id="quiz" class="form-control">
					<option value="">Create New Question Set</option>
					<?php
					foreach($quizzes as $qk=>$qv) {
						?><option value="<?=$qk?>">copy of "<?=$qv?>"</option><?php
					}
					?>
				</select>
			</div>
			<div class="col-md-6">
				<a href="/admin/import/" class="btn btn-default btn-block"><span class="glyphicon glyphicon-cloud-upload"></span> &nbsp; Import Question Set</a>
			</div>
		</div>
		<? if ($message['text'] != '') { ?>
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<i class="icon-circle-arrow-up"></i>&nbsp;<?=$message['text']?><?=$message['newid']?>
						</div>
						<script>$('#quiz').val(<?=abs($message['newid'])?>);</script>
				</div>
			</div>
		<?php } ?>

	</div>
</div>
</div>
</div>

</div>

<div class="swiper-container">
<div class="container">
<div class="row">
<div class="col-md-12">
	<h3><span class="label label-default">3</span> Select Media &nbsp;&nbsp; <small>Select media below, or click "Select Files" to upload your own image (File types: jpg or png. Size: max 25MB)</small></h3>
</div>
<div class="col-md-12">
	<input id="file_upload" name="file_upload" type="file" multiple="true">
		<!-- <h5 class="small">Select media below, or click "Select Files" to upload your own image (File types: jpg or png. Size: max 25MB)</h5> -->
	<div id="myfilequeue"></div>
</div>
</div>
</div>

<style>
#newmedia {
  visibility: visible;
}
</style>

<div class="swiper-wrapper">

<?php

foreach ($tours as $tourname=>$tourinfo) {
	?>
		<?php
		foreach ($tourinfo['scenes'] as $sceneid=>$sceneinfo) {
			?>
			<div class="swiper-slide">
			<div class="tourbox thumbnail" thetour="<?=$sceneid?>">
				<div style="margin: 0px auto">
				<h4><?=$sceneinfo['title']?></h4>
				<img src="/phpThumb/phpThumb.php?src=<?=$sceneinfo['image']?>&amp;h=186&amp;w=400&amp;zc=1&amp;far=1" />
				<img src="/img/check.png" class="check" />
				</div>
			</div>
			</div>
			<?php
		}
		?>
	<?php
}
?>

<?php
foreach ($othermedia as $sceneid=>$sceneinfo) {
	?>
	<div class="swiper-slide">
	<div class="tourbox thumbnail othermedia" thetour="<?=$sceneid?>">
		<div style="margin: 0px auto">
		<h4><?=$sceneinfo['title']?></h4>
		<img src="/phpThumb/phpThumb.php?src=<?=$sceneinfo['image']?>&amp;h=186&amp;w=400&amp;zc=1&amp;far=1" />
		<img src="/img/check.png" class="check" />
		</div>
	</div>
	</div>
	<?php
}
?>

</div>

<div class="pagination"></div>

</div><!--swiper-container-->

<div class="container">

<br /><br />

<div class="row">
<div class="col-md-12 text-center">
<input type="submit" name="selector" id="selector" class="btn btn-lg btn-warning" value="Start Building" />
</div>
</div>

</form>

<script>
var mySwiper
$(function(){
  mySwiper = $('.swiper-container').swiper({
    mode:'horizontal',
    pagination: '.pagination',
    paginationClickable: true,
    paginationAsRange: false,
    slidesPerView: 2,
    centeredSlides: true,
    visibilityFullFit: true,
    calculateHeight: true,
    preventLinks: false,
    keyboardControl: true
  });
});
</script>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$(document).on('click', '.tourbox', function(event) {
			var thetour = $(this).attr('thetour');
			$('#whichtour').val(thetour);
			if ($(this).hasClass('othermedia')) {
				$("#isothermedia").val('1');
			} else {
				$("#isothermedia").val('');
			}
//			console.log($('#whichtour').val());
			$('.tourbox').removeClass('highlighted');
			$(this).addClass('highlighted');
//			can't make this work because you need to click to scroll, triggering that
//			$('#selector').focus();
		});
		
//		$('#selector').click(function() {
//			$('#bigform').attr('action', '/admin/dragdrop/'+$('#quiz').val()).submit();
//			window.location.href = '/admin/dragdrop/'+$('#quiz').val()+'/'+$('#whichtour').val();
//			return false;
//		});

	});
	
</script>

<script type="text/javascript">
<?php $timestamp = time();?>
$(function() {
  $('#file_upload').uploadifive({
    'formData'     : {
      'timestamp' : '<?php echo $timestamp;?>',
      'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
      'user_id'   : $('#user_id').val()
    },
    'uploadScript' : '/uploadifive/uploadifive.php',
    'queueID' : 'myfilequeue',
    'queueSizeLimit' : 1,
	'onAddQueueItem' : function(file) {
//		console.log($('#packagename').val());
		this.data('uploadifive').settings.formData = { 
				'packagename' : $('#packagename').val(),
		        'timestamp' : '<?php echo $timestamp;?>',
		        'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
      			'user_id'   : $('#user_id').val()
		 };
	},
    'onUploadComplete' : function(file, data) {
    	var thename = file.name;
    	newdata = $.parseJSON(file.filedata);
    	if (newdata.realname != '') thename = newdata.realname;
//            $('#file_upload').after('<input type="hidden" class="filenamer" name="filename[]" value="' + thename + '" />');
//            alert('The file ' + file.name + ' uploaded successfully.');
		if (thename != '' && newdata.newid != '') {
    		var myslide = '<div class="tourbox thumbnail othermedia" thetour="'+newdata.newid+'"> <div style="margin: 0px auto"> <h4>'+newdata.newname+'</h4> <img src="/phpThumb/phpThumb.php?src=/othermedia/'+thename+'&amp;h=186&amp;w=400&amp;zc=1&amp;far=1"> <img src="/img/check.png" class="check"> </div> </div>';

    		mySwiper.prependSlide(myslide, 'swiper-slide swiper-slide-visible lasty');
    		

    		setTimeout(function () {
    			mySwiper.reInit();
			}, 500);

    		mySwiper.swipeTo(0);
    		$('div.lasty div.tourbox').trigger('click');

		}






      },
     'onCancel' : function() {
     	$('#file_upload').val('');
     	$('#fakefiler').val('');
        $('input.filenamer[value="'+file.name+'"]').remove();
      }
  });
});

$(document).ready(function() {
	$('#whatever').click(function() {
		var myslide = '<div class="tourbox thumbnail othermedia" thetour="16"> <div style="margin: 0px auto"> <h4>atest</h4> <img src="/phpThumb/phpThumb.php?src=/othermedia/pope-francis-0a53.jpg&amp;h=186&amp;w=400&amp;zc=1&amp;far=1"> <img src="/img/check.png" class="check"> </div> </div>';

		mySwiper.prependSlide(myslide, 'swiper-slide swiper-slide-visible lasty');
		

		setTimeout(function () {
			mySwiper.reInit();
		}, 500);

		mySwiper.swipeTo(0);
		$('div.lasty div.tourbox').trigger('click');
		return false;
	});
});

</script>


</div>
</div>

</div><!--container-->

