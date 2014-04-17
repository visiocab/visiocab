<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Visiocab &#155; Interactive Learning Environments</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="An Interactive Learning Environment">
<meta name="author" content="http://vvicrew.com/">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
<![endif]-->

<!-- stylesheets -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/style.css" rel="stylesheet">

<!--load jquery for bootstrap and the build page-->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

</head>

<body class="loggedin">

<!-- nav -->
<div class="navbar-wrapper">
<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">
      	<img src="/img/logo-light.png" alt="Visiocab">
      </a>
    </div>
    <div class="navbar-collapse collapse">
  		<ul class="nav navbar-nav navbar-right">
        <li><a href="/admin" class="nav-btn"><span class="glyphicon glyphicon-th"></span> &nbsp; Dashboard</a></li>
        <li><a href="/support/" class="nav-btn" target="_blank"><span class="glyphicon glyphicon-question-sign"></span> &nbsp;  Support</a></li>      
        <li><a class="nav-btn" style="cursor:default">Logged in as <span class="user"><?php echo $userinfo['first_name'] ?></span></a></li>
        <li><a href="/auth/logout" id="logout" class="nav-btn" data-toggle="tooltip" data-placement="right" title="Logout" data-original-title="Logout"><span class="glyphicon glyphicon-off"></span></a></li>
 
        <li>&nbsp;</li>
  		</ul>
    </div>
  </div>
</nav>
</div>