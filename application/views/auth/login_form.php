<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'class' => 'input-block-level',
	'placeholder' => 'username',
	'data-validation-engine' => 'validate[required]',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
	);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'placeholder' => 'password',
	'class' => 'input-block-level',
	'data-validation-engine' => 'validate[required]',
	'size'	=> 30,
	);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
	);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
	);
	?>

<div id="wrap">
<div class="container">

<h1 class="logo"><a href="">Visocab - Visual Vocabulary</a></h1>
<h4 class="subhead">An interactive quiz builder.</h4>

<div class="login-register">
<div class="hero-unit">

      <form class="form-horizontal" id="login-form" action="/index.php/auth/login" method="POST">
        <fieldset>
          <div id="legend">
            <legend class="">Login</legend>
          </div>
          <div class="control-group">
            <!-- Username -->
            <label class="control-label"  for="login">Username</label>
            <div class="controls">
              <input type="text" id="username" name="login" placeholder="email" class="input-xlarge">
            </div>
          </div>

          <div class="control-group">
            <!-- Password-->
            <label class="control-label" for="password">Password</label>
            <div class="controls">
              <input type="password" id="password" name="password" placeholder="password" class="input-xlarge">
            </div>
          </div>

          <div class="control-group">
            <!-- Button -->
            <div class="controls">
              <button class="btn btn-warning">Login</button>
            </div>
          </div>
        </fieldset>
      </form>

</div><!--hero-unit-->
</div><!--login-register-->

</div>
</div>


<div id="push"></div>