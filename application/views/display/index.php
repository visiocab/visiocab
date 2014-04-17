<!DOCTYPE html>
<!-- this is display/index -->
<html>
<head>

<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Visiocab</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">
	var JQ = $.noConflict();
</script>

<!-- bootstrap -->
<link href="http://lms.vvidev.com/css/bootstrap-flat.min.css" rel="stylesheet">
<link href="http://lms.vvidev.com/css/bootstrap-2.3.2.css" rel="stylesheet">
<link href="http://lms.vvidev.com/css/bootstrap-responsive-2.3.2.css" rel="stylesheet">
		
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		
<!--		<script type="text/javascript" src="<?=$package['fullpath']?>swfobject.js"> -->
		</script>
		<script type="text/javascript">
			// hide URL field on the iPhone/iPod touch
			function hideUrlBar() {
				if (((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)))) {
					container = document.getElementById("container");
					if (container) {
						var cheight;
					  	switch(window.innerHeight) {
							case 208:cheight=268; break; // landscape
						 	case 260:cheight=320; break; // landscape, fullscreen
						 	case 336:cheight=396; break; // portrait, in call status bar
							case 356:cheight=416; break; // portrait 
							case 424:cheight=484; break; // portrait iPhone5, in call status bar
							case 444:cheight=504; break; // portrait iPhone5 
						 	default:
								cheight=window.innerHeight;
						}
						if ((cheight) && ((container.offsetHeight!=cheight) || (window.innerHeight!=cheight))) {
							container.style.height=cheight + "px";
							setTimeout(function() { hideUrlBar(); }, 1000);
						}
					}
				}
				
				document.getElementsByTagName("body")[0].style.marginTop="1px";
				window.scrollTo(0, 1);
			}
			window.addEventListener("load", hideUrlBar);
			window.addEventListener("resize", hideUrlBar);
			window.addEventListener("orientationchange", hideUrlBar);
		</script>
		
<style type="text/css" title="Default">
/* fullscreen */
html {
height:100%;
}
body {
height:100%;
margin: 0px;
overflow:hidden; /* disable scrollbars */
padding-top: 0px;
}
ul {
list-style: none;
}
.warning { 
font-weight: bold;
} 
/* fix for scroll bars on webkit & Mac OS X Lion */ 
::-webkit-scrollbar {
background-color: rgba(0,0,0,0.5);
width: 0.75em;
}
::-webkit-scrollbar-thumb {
background-color:  rgba(255,255,255,0.5);
}
#qdiv {
background: #fff url(/img/visiocab-bkg.png) bottom right no-repeat;
padding: 20px;
line-height: 20px;
border: 1px solid #ddd;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);
-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);
box-shadow: 0 1px 3px rgba(0, 0, 0, 0.055);
}
#questiontext {
	font-size: 1.5em;
	line-height: 1.4em;
}
#questiontext .alert {
	font-size: 1em!important;
}
p.result {
	font-size: 11pt;
}
</style>	

</head>
	
<body>

		<script type="text/javascript" src="<?=$package['fullpath']?>pano2vr_player.js">
		
		</script>
		<script type="text/javascript" src="/js/allskin.js">
		</script>
<? /*		<script type="text/javascript" src="<?=$package['fullpath']?>pano2vrgyro.js">
		</script> */ ?>
		<div id="container" style="width:100%;height:100%;">
		This content requires HTML5/CSS3, WebGL, or Adobe Flash Player Version 9 or higher.
		</div>
		<script type="text/javascript">
	
//		if (swfobject.hasFlashPlayerVersion("9.0.0")) {
//			var flashvars = {};
//			var params = {};
//			params.quality = "high";
//			params.bgcolor = "#ffffff";
//			params.allowscriptaccess = "sameDomain";
//			params.allowfullscreen = "true";
//			var attributes = {};
//			attributes.id = "pano";
//			attributes.name = "pano";
//			attributes.align = "middle";
//			swfobject.embedSWF(
//				"pano_out.swf", "container", 
//				"100%", "100%",
//				"9.0.0", "", 
//				flashvars, params, attributes);
//			
//		} else 
		// check for CSS3 3D transformations and WebGL
		if (ggHasHtml5Css3D() || ggHasWebGL()) {
	
			// create the panorama player with the container
			pano=new pano2vrPlayer("container");
			// add the skin object
			skin=new pano2vrSkin(pano,'<?=$package['fullpath']?>');
			// load the configuration
			pano.readConfigUrl("/xml/<?=$package_id?>");
//			pano.readConfigUrl("/img/test.xml");
			// hide the URL bar on the iPhone
			hideUrlBar();
			// add gyroscope controller
//			gyro=new pano2vrGyro(pano,"container");
		}
		</script>
		<noscript>
			<p><b>Please enable Javascript!</b></p>
		</noscript>

		
		<script type="text/javascript" charset="utf-8">
			
			var questions = [];
			var currentquestion = 1;
			var currentquestiontext = '';
			
			JQ(document).ready(function() {
				//JQ('#iq1 img').attr('src', '/img/number1.png');
				//JQ('div[id^="iq"]').each(function(thing) {
				//	console.log(JQ(this).children('img').attr('src'));
				//});

				var j = 1;
				while (JQ('#iq'+j).length)
				   {
				   		JQ('#iq'+j+' img').attr('src', '/img/other.png'); 
				   		j++;
				   }

				
				JQ.ajax({
					type: "GET",
					url: "/ajax/allQuestions/<?=$package_id?>",
					success: function(msg) {
						if (msg['questions']) {
							questions = msg;
						} else {
							alert('Questions failed to load. Try refreshing the page');
						}
//						console.log(questions);
					}
				});
				
				
				JQ('#closer').click(function() {
					JQ('#qdiv').hide('slow');
					JQ('#questiontext').html('');
					return false;
				});

			});

			
			function handleClick(thediv) {
				var theid = JQ(thediv).attr('id');

//				if (JQ(thediv).hasClass('answered') || theid != 'iq'+currentquestion) {
//					if (currentquestiontext != '') {
//						alert(currentquestiontext);
//					} else {
//						alert('Please go to question '+currentquestion);
//					}
//					return false;
//				}
				var myquestion = questions['questions'][theid];
				var myanswers = questions['answers'][theid];
				
				JQ('#qdiv').show('slow');
				if (myquestion['qtype'] == 'infobox') {
					var payload = '<input type="hidden" id="currentquestion" name="currentquestion" value="'+theid+'" />'+myquestion['qtext']+'<br /><br /><p id="answer"><a href="javascript:JQ(\'#closer\').trigger(\'click\')" class="btn"><i class="icon-remove"></i> Done</a></p>';
						currentquestion++;
						JQ('div#'+theid+' img').attr('src', '/img/correct.png');
						JQ('#questiontext').html('').html(payload);
						evalQuestion();
				} else {
					var payload = '<input type="hidden" id="currentquestion" name="currentquestion" value="'+theid+'" />Q: '+myquestion['qtext']+'<br /><br /><ul>';
					jQuery.each(myanswers, function(i, val) {
						payload += '<li><label class="radio"><input type="radio" name="theanswer" value="'+i+'" />'+val['atext']+'</label></li>';
					})
					payload += '</ul><br /><input type="button" class="btn" id="answer" value="Answer" onclick="evalQuestion();" />';
				}
				JQ('#questiontext').html('').html(payload);
			}
			
			function evalQuestion() {
//				alert(JQ('#currentquestion').val()+' - '+JQ('input[name="theanswer"]:checked').val());
				var asked = JQ('#currentquestion').val();
				var returnmessage = '';
				
				JQ.ajax({
					type: "POST",
					url: "/ajax/checkQuestionPreview/",
					data : {
						'packageid' : <?=$package_id?>,
						'question' : JQ('#currentquestion').val(),
						'key'  :  '<?=sha1($user_key_seed)?>', 
						'answer' : JQ('input[name="theanswer"]:checked').val(),
						'testid' : 1
					},
					success: function(msg) {
						if (msg['correct']) {
							currentquestion++;
							if (!parseInt(msg['isinfo'])) {
								returnmessage = '<div class="result alert alert-success"><p><b>Correct!</b> ';
								if (msg['nexttext'] != '') {
									returnmessage += msg['nexttext']+' ';
									currentquestiontext = msg['nexttext'];
								} else {
									returnmessage += '';
									currentquestiontext = '';
								}
								returnmessage += '</p></div><p><a href="javascript:JQ(\'#closer\').trigger(\'click\')" class="btn"><i class="icon-remove"></i> Done</a></p></p>';
							} else {
								returnmessage = '<p><a href="javascript:JQ(\'#closer\').trigger(\'click\')" class="btn"><i class="icon-remove"></i> Done</a></p>';
							}
							JQ('#answer').before(returnmessage);
							JQ('div#'+asked+' img').attr('src', '/img/correct.png');
							//console.log(returnmessage);
							JQ('#answer').hide();
							JQ('div#'+asked).addClass('answered');
						} else if (msg['alreadyanswered']) {
							currentquestion++;
							returnmessage = '<p>You have already answered this question. <a href="javascript:JQ(\'#closer\').trigger(\'click\')"><i class="icon-remove"></i> Done</a>.</p>';
							if (msg['wasitcorrect'] == 'correct') {
								JQ('div#'+asked+' img').attr('src', '/img/correct.png');
							} else {
								JQ('div#'+asked+' img').attr('src', '/img/incorrect.png');
							}
							JQ('#answer').after(returnmessage);
							JQ('div#'+asked).addClass('answered');
						} else if (msg['incorrect']) {
							currentquestion++;
							returnmessage = '<div class="result alert alert-block alert-error"><p><b>Incorrect.</b> ';
							if (msg['nexttext'] != '') {
								returnmessage += msg['nexttext']+' ';
								currentquestiontext = msg['nexttext'];
							} else {
								returnmessage += 'Go to question '+currentquestion+'. ';
								currentquestiontext = '';
							}
							returnmessage += '</p></div><p><a href="javascript:JQ(\'#closer\').trigger(\'click\')" class="btn"><i class="icon-remove"></i> Done</a></p>';
							//if (msg['is_finished'] != '') {
							//	returnmessage += 'Your Visiocab is completed.';
							//}
							JQ('div#'+asked+' img').attr('src', '/img/incorrect.png');
							JQ('#answer').before(returnmessage);
							JQ('#answer').hide();
							JQ('div#'+asked).addClass('answered');
						} else {
							currentquestion++;
							returnmessage = '<p>There was an error.</p>';
							JQ('div#'+asked+' img').attr('src', '/img/other.png');
							JQ('#answer').after(returnmessage);
							JQ('div#'+asked).addClass('answered');
						}
					}
				});
				return true;
			}
		</script>

		<div id="qdiv" style="position: absolute; top: 5%; left: 10%; width: 80%; height: 80%; z-index: 5000; display: none;">
			<div style="position: relative; width: 100%; height: 100%">
				<div style="position: absolute; z-index: 5001; cursor: pointer; top: 0; right: 0"><a href="#" id="closer"><i class="icon-remove"></i></a></div>
				<div style="position: absolute; padding: 3em" id="questiontext">
					This is the question text.
				</div>
			</div>
		</div>
		
		<?/*<script src="/js/bootstrap.min.js"></script>
		<script src="/js/jquery.validate.min.js"></script>
		<script src="/js/scripts.js"></script>*/?>

		
</body>
</html>