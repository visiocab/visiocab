<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Visiocab - Interactive Learning Environment</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Visiocab marries text questions with visual representations to make a better learning experience for students.">
<meta name="author" content="Vision Video Interactive">

<!-- bootstrap + custom style sheet (using sass/style.scss to generate css/style.css) -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<!-- Pace Loader -->
<script data-pace-options='{ "elements": {selectors: ['#iframe']} }' src="js/loader/pace.min.js"></script>
<link href="css/pace/pace-theme-center-circle.css" rel="stylesheet">
<!-- ShareThis -->
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "b5342687-8123-478d-882b-884ac99cee9d", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

</head>

<body cz-shortcut-listen="true">

<?php
if ($message = $this->session->flashdata('message')) {
  print "<div id=\"registered\"><div class=\"alert\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>".$message."</div></div>";
} ?>

<!-- header desktop -->
<header id="login">
<nav id="<? if (empty($userinfo)) { ?>loginnav<? } ?>" class="visible-md visible-lg" role="navigation">
  <div class="container">
    <div class="col-sm-2">
      <ul class="nav secondarynav">
        <li><a href="#" title="#" class="aboutLink btn btn-default">About</a></li>
      </ul>
    </div>
    <div class="col-sm-7">
      <div class="logo">
        <a href="/"><img src="/img/visiocab.png" title="Visiocab" alt="Visiocab" /></a>
      </div>
    </div>
    <? if (!empty($userinfo)) { ?>
    <div class="col-sm-3">
      <ul class="nav navbar-nav navbar-right secondarynav">
        <li>&nbsp;<a href="/admin" class="btn btn-warning navbar-btn">Dashboard</a></li>
        <li>&nbsp;<a href="/auth/logout" class="btn btn-dark">Logout</a></li>
      </ul>
    </div>
    <? } else { ?>
    <div class="col-sm-3">
      <ul class="nav navbar-nav navbar-right secondarynav">
        <li><a href="#" title="#" class="registerLink btn btn-warning navbar-btn">Register</a>&nbsp;</li>
        <li>&nbsp;<a href="#" title="#" class="loginLink btn btn-dark">Login</a></li>
      </ul>
    </div>
    <? } ?>
  </div>
</nav>
<!-- mobile menu -->
<nav id="loginnav" class="visible-xs visible-sm" role="navigation">
  <div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="logo">
        <a href="/"><img src="/img/visiocab.png" title="Visiocab" alt="Visiocab" /></a>
        <br><br>
      </div>
    </div>
  </div>
  <div class="row">
      <div class="col-xs-4">
        <a href="#" title="#" class="aboutLink btn btn-block btn-default">About</a>
      </div>
    <? if (!empty($userinfo)) { ?>
      <div class="col-xs-4">
        <a href="/admin" class="btn btn-block btn-warning">Dashboard</a>
      </div>
      <div class="col-xs-4">
        <a href="/auth/logout" class="btn btn-block btn-dark">Logout</a>
      </div>
    <? } else { ?>
      <div class="col-xs-4">
        <a href="#" title="#" class="registerLink btn btn-block btn-warning">Register</a>
      </div>
      <div class="col-xs-4">
        <a href="#" title="#" class="loginLink btn btn-block btn-dark">Login</a>
      </div>
    <? } ?>
  </div>
  </div>
</nav>
</header>

<!-- Dropdown Content -->
<div class="dropdowns">
<!-- Info -->
<article class="about_page">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3>What is Visiocab?</h3>
        <p>Ever heard of <a href="http://www.knewton.com/flipped-classroom/" title="About Flipping the Classroom" target="_blank">Flipping the Classroom</a> or an <a href="http://en.wikipedia.org/wiki/Immersion_(virtual_reality)#Immersive_digital_environments" title="About Immersive Digital Environments" target="_blank">Immersive Digital Environment</a>? We fit somewhere in between! Visiocab (visual vocabulary) is a concept that makes the class field trip something instructors and students can experience from anywhere. Provide the hands on enrichment your students want in the classroom.</p>
      </div>
    </div>
  </div>
</article>
<!-- Login -->
<article class="login_page">
<div class="container">
<form id="login-form" action="/index.php/auth/login" method="POST">
  <div class="row">
    <div class="col-md-5">
      <label for="username">Email</label>
      <input type="email" id="username" name="login" placeholder="Email Address" class="form-control">
    </div>
    <div class="col-md-5">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="Password" class="form-control">
    </div>
    <div class="col-md-2">
      <button id="login" class="btn btn-default btn-block">Login</button>
    </div>
  </div>
</form>
</div>
</article>
<!-- Register -->
<article class="register_page">
<div class="container">
<form role="form" id="register-form" action='/index.php/auth/register' method="POST">
<div class="row">
  <div class="col-lg-6">
    <h3>What's Included?</h3>
    <p>Your Visiocab account is free for life.</p>
    <p>Create unlimited Visiocabs to share with students and colleagues.</p>
    <p>Students can use Visiocab for learning exercises and assignments.</p>
    <p>Upload your own media to create learning exercises, and quizzes.</p>
    <h4>More questions? Let us know <a href="#" data-toggle="modal" data-target="#support" target="_self">here</a>.</h4>
  </div>
  <div class="col-lg-6">
    <div class="row">
      <div class="col-sm-6">
        <label for="first_name">Your First Name</label>
        <input type="text" id="first_name" name="first_name" placeholder="First" class="form-control">
      </div>
      <div class="col-sm-6">
        <label for="last_name">Your Last Name</label>
        <input type="text" id="last_name" name="last_name" placeholder="Last" class="form-control">
      </div>
      <div class="col-sm-12">
        <label for="email">Your Email Address</label>
        <input type="text" id="email" name="email" placeholder="Email" class="form-control">
      </div>
      <div class="col-sm-6">
        <label for="password2">Your Password</label>
        <input type="password" id="password2" name="password" placeholder="Password" class="form-control">
      </div>
      <div class="col-sm-6">
      <label for="password2">Confirm</label>
        <input type="password" id="password2" name="confirm_password" placeholder="Confirm Password" class="form-control">
      </div>
      <div class="col-sm-12">
        <div id="ca">
          <button class="btn btn-lg btn-warning btn-block">Create Account</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
</div>
</article>
</div><!-- .dropdowns -->
