<html style="height:100%">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?
session_start();
if($_REQUEST['t']) {
	$tour = $_REQUEST['t'];
	$_SESSION['t'] = $_REQUEST['t'];
} elseif ($_SESSION['t']) {
		$tour = $_SESSION['t'];
} else {
	$tour = 'best-of';
}

error_log(print_r($_SESSION,true));

?>
<link rel="stylesheet" href="toursmain.css" type="text/css" media="screen" charset="utf-8" />
<?php

$scenenum = ($_REQUEST['s']) ? $_REQUEST['s'] : 1;



$dir = $_SERVER['DOCUMENT_ROOT']."/airstreams/tour/".$tour;
error_log('opening '.$_SERVER['DOCUMENT_ROOT']."/airstreams/tour/".$tour);
$scenes = array();
// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
			if ($file != '.' && $file != '..') {
#            	echo "<li>filename: $file : filetype: " . filetype($dir . $file) . "\n";
				if (preg_match("/^(\d+)(.*)$/",$file, $matches)) {
					// Scene's name
					$scenes[abs($matches[1])]['displayname'] = $matches[2];
					// Scene's name with scene number
					$scenes[abs($matches[1])]['fullname'] = $matches[0];
					// Check whether there's an audio for the scene	
					$scenes[abs($matches[1])]['audio'] = file_exists($dir."/".$matches[0]."/sound.mp3");
				}
				
			}
        }
        closedir($dh);
    }
}
ksort($scenes);
#print "<pre>";
#	print json_encode($scenes);
#print "</pre>";
?>
<? 
	if ($_REQUEST['list']) { 
		print "<div class=\"loc_list\">Select a scene: <ul class=\"chapterlist\">";
		foreach ($scenes as $k=>$v) {
			print "<li><a href=\"#\" onclick=\"parent.changelocation(".$k.")\">".$v['displayname']."</a></li>";
		}
		print "</ul></div>";
		exit;
	} 
?>

<script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> 
<script type="text/javascript" src="/airstreams/themes/aasf/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script src="/airstreams/themes/aasf/js/nicescroll/jquery.nicescroll.js"></script>
<script src="/airstreams/themes/aasf/js/jplayer/jquery.jplayer.min.js"></script>
<script src="/airstreams/themes/aasf/js/jplayer/jquery.jplayer.inspector.js"></script>
<link href="/airstreams/themes/aasf/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" media="screen" type="text/css" />
<script type="text/javascript" charset="utf-8">
	var audio;
	var prevscene = '';
	var nextscene = '';
	var curscene = <?=$scenenum?>;
	var scenelist = <?=json_encode($scenes)?>;
	$(document).ready(function() {
		var containerHeight = $('body').height();
		var newHeight = containerHeight - 40;
		
		$("#tourframe").css('height', newHeight);
		$("#tourframe").css('min-height', newHeight);
		
		$('#prevbutton').click(function() {
			if (prevscene) {
				loadScene(prevscene, scenelist);
			}
		});

		$('#nextbutton').click(function() {
			if (nextscene) {
				loadScene(nextscene, scenelist);
			}
		});
		
		// var divAudio = $('#yourdiv').find('audio')[0];
		
		$('#stopper').click(function() {
			stopfile(divAudio);
		});
		$('#player').click(function() {
			playfile(divAudio);
		});
		$('a.popup').click(function() {
			//$('#tourframe').attr('src','');
		});

		// Nice scroll
		$('div.loc_list').niceScroll({cursorcolor:"#00F"});

		// Fancybox
		// Disable fancybox scrolling, since it doesn't supported by iOS
		// Scrolling support provided by NiceScroll
		$("a.popup").fancybox({
					'width'				: 400,
					'height'			: 200,
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'scrolling'			: 'no',
					'type'				: 'iframe'
		});

		resetNextPrev();
		sortoutbuttons();
		loadScene(curscene, scenelist);
		
	});
	
	function loadScene(scenenumber, allscenes) {
		curscene = scenenumber;
		path = '../tour/<?=$tour?>/'+allscenes[scenenumber]['fullname'];
		$('iframe#tourframe').attr('src', path + "/index.html");
//		console.log($('iframe#tourframe').attr('src'));
		//$('div#tour_container').load(path + "/index.html");
		$('#current').html('').html(allscenes[scenenumber]['displayname']);
		
		resetNextPrev();
		
		// Play or start a new audio only when available
		if(allscenes[scenenumber]['audio']){
			if(this.jp != undefined){
				// Stop any current audio
				this.jp.jPlayer("destroy");
			}
			
			jp = $("#jplayer").jPlayer({
						solution: 'html, flash',
						wmode: "window",
						ready: function(){
							$(this).jPlayer("setMedia", {
								mp3: path + "/sound.mp3",
								oga: path + "/sound.ogg"});
							$(this).jPlayer("play");
						},
						supplied: "mp3, oga",
						swfPath: "../themes/aasf/js/jplayer/"
					});
					
			// Uncomment this only when troubleshooting jPlayer
			//$("#jplayer_inspector").jPlayerInspector({jPlayer:$("#jplayer")});
		}

		//$('#tourframe').attr('src', $('tourframe').attr('src'));
	}

	function resetNextPrev() {
		prevscene = '';
		nextscene = '';
		for (var i = 1; i <= <?=sizeof($scenes)?>; i++) {
			if (i == (curscene - 1)) {
				prevscene = i;
				$('#prevscene').css('display','block');
			} else if (i == (curscene + 1)) {
				nextscene = i;
			}
		}
		sortoutbuttons();
	}
	function sortoutbuttons() {
		if (!nextscene) {
//			$('#nextbutton').css('display','none');
			$('#nextbutton').removeClass('nextbutton').addClass('nextbuttonoff');
		} else {
//			$('#nextbutton').css('display','inline');
			$('#nextbutton').removeClass('nextbuttonoff').addClass('nextbutton');
		}
		if (!prevscene) {
//			$('#prevbutton').css('display','none');
			$('#prevbutton').removeClass('prevbutton').addClass('prevbuttonoff');
		} else {
//			$('#prevbutton').css('display','inline');
			$('#prevbutton').removeClass('prevbuttonoff').addClass('prevbutton');
		}
	}
	function playfile(divAudio) {
		divAudio.play();
	}
	function stopfile(divAudio) {
		divAudio.pause();
	}
	function changelocation(specificscene) {
		$.fancybox.close();
		loadScene(specificscene, scenelist);
	}

	function closeFancybox(){
	    $.fancybox.close();
		location.reload();
	}

	// Full screen HTML5 API
	var pfx = ["webkit", "moz", "ms", "o", ""];  
	function RunPrefixMethod(obj, method) {  
	    var p = 0, m, t;  
	    while (p < pfx.length && !obj[m]) {  
	        m = method;  
	        if (pfx[p] == "") {  
	            m = m.substr(0,1).toLowerCase() + m.substr(1);  
	        }  
	        m = pfx[p] + m;  
	        t = typeof obj[m];  
	        if (t != "undefined") {  
	            pfx = [pfx[p]];  
	            return (t == "function" ? obj[m]() : obj[m]);  
	        }  
	        p++;  
	    }  
	}

	var e = document.getElementById("fullscreen");
	var scr = document.getElementById("tourframe");  
	/*
	e.onclick = function() {  
	    if (RunPrefixMethod(scr, "FullScreen") || RunPrefixMethod(scr, "IsFullScreen")) {  
	        RunPrefixMethod(scr, "CancelFullScreen");  
	    }  
	    else {  
	        RunPrefixMethod(scr, "RequestFullScreen");  
	    }  
	}
	*/
	function goFullScreen(){
		var btnVal = $("#btnFullScreen").prop("value");
		if(btnVal == "Full")
			$("#btnFullScreen").prop('value', 'Back');
		else
			$("#btnFullScreen").prop('value', 'Full');
		
		var scr = document.getElementById("tourframe");
		var res = scr.requestFullScreen();
		
		/*
		var res = RunPrefixMethod(scr, "RequestFullScreen");
		alert(res);
		*/
	}  

</script>
<?
$iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
?>
<body style="height:100%; overflow-y: hidden;">
<iframe id="tourframe" width="100%" style="display:block;border:none;" src=""></iframe>
<div id="tour_container" style="width:100%;display:block;border:none;"></div>
<div id="navbar">
	<div id="tournav">
		<div id="navguts">
			<input type="button" value="" id="prevbutton" class="prevbutton" title="" alt="" />
			<span id="current">cur</span>
			<input type="button" value="" id="nextbutton" class="nextbuttonoff" title="" alt="" />
		</div>
	</div>
	<!--
	<div id="fscreen">
		<input type="button" value="Full" id="btnFullScreen" onclick=goFullScreen()>
	</div>
	-->
	<div id="navlist">
		<p class="listlink"><a href="<?=$_SERVER['PHP_SELF']?>?t=<?=$tour?>&list=1" class="popup" title="" alt="">Scenes</a></p>
	</div>
	<div class="clear" />
</div>
<? /* <div id="jplayer" class="jplayer"></div>
<div id="jplayer_inspector"></div> */ ?>
</body>

</html>
