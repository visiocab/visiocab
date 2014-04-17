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

	<div class="login-box">
		<?php #echo form_open($this->uri->uri_string()); ?>

 <form action="/index.php/auth/forgot_password" enctype="multipart/form-data" id="loginform" method="post"> 
    <label for="login">Email</label>
    <?php echo form_input($login); ?>
<p style="color: red"><?php echo form_error($login['name']); ?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?></p>
<p stlye="clear: both">&nbsp;</p>
<? /*	<button id="closebtn" onclick="parent.closebox(); return false;" class="btn" data-dismiss="modal" aria-hidden="true">Close</button> */ ?>
<button class="btn btn-mobile pull-right" id="creator"><i class="icon icon-white icon-bullhorn"></i> Send</button>
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
