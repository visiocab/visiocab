<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($this->config->item('use_username', 'tank_auth')) {
	$login_label = 'Email or login';
} else {
	$login_label = 'Email';
}
?>
	<section class="login">
<a id="logo" href="" target="_self" title="Mobile Drive"><h1>Mobile Drive</h1></a>

	<div class="login-box">
		<?php #echo form_open($this->uri->uri_string()); ?>

 <form action="/index.php/auth/forgot_password" enctype="multipart/form-data" id="loginform" method="post"> 
    <label for="login">Email</label>
    <?php echo form_input($login); ?>
    
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
</div>

    <div id="login-links" class="clearfix">         
      <a href="#" target="_self" title="Login" id="login" onclick="document.getElementById('loginform').submit();" class="btn btn-warning"><span>Send <img src="<?=$this->config->item('static_url') ?>/img/login_btn.png" /></span></a>
      <a href="/auth/login" target="_self" title="Back to Login" class="btn" id="forget">Back to Login</a>
    </div>
  </form>
</div>

</section>




<? /*



<?php echo form_open($this->uri->uri_string()); ?>
<table>
	<tr>
		<td><?php echo form_label($login_label, $login['id']); ?></td>
		<td><?php echo form_input($login); ?></td>
		<td style="color: red;"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></td>
	</tr>
</table>
<?php echo form_submit('reset', 'Get a new password'); ?>
<?php echo form_close(); ?>

*/ ?>
