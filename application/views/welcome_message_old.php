<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">

	Visiocab
	
	<p>A Visiocab marries text questions with visual representations to make a better learning experience for students.</p>
	
	<p><b>Teacher accounts</b> can create Visiocabs from images, virtual tours, or videos, and either import questions from an existing LMS or create a new question set. Once the students have completed their visiocabs, the teacher can see how they performed.</p>
	
	<p><b>Students</b> can log in to see what new visiocabs are available.  Visiocabs can be completed on a tablet or computer browser</p>

<br /><hr /><br />
<form action="/index.php/auth/login" enctype="multipart/form-data" id="loginform" method="post" class="validate">
	<input type="text" name="login" value="" id="login" class="input-block-level" placeholder="username" data-validation-engine="validate[required]" maxlength="80" size="30"  />
	<input type="password" name="password" value="" id="password" placeholder="password" class="input-block-level" data-validation-engine="validate[required]" size="30"  />
	<div class="clearfix">
		<a href="/auth/forgot_password/1" class="m2modal" title="Forget Password?" id="forget">Forget your password?</a>
		<input type="submit" id="login" class="btn btn-mobile" value="Login" style="float:right;" />
	</div>
</form>


<!-- 	<h1>Packaging a Quiz and Tour Together</h1>

	<div id="body">
		<p>The link below will send you straight to an already prepared tour builder</p>
		<code><a href="/admin/dragdrop/1/11">/admin/dragdrop/1/11</a></code>

	</div>
-->
</div>

</body>
</html>
