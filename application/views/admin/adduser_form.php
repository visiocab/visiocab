<? if (!empty($user)) { ?>
	<pre>
		<? print_r($user); ?>
	</pre>
<? } ?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" accept-charset="utf-8">
	
	<label for="first_name">first_name</label><input type="text" name="first_name" value="" id="first_name" /><br />
	<label for="last_name">last_name</label><input type="text" name="last_name" value="" id="last_name" /><br />
	<label for="username">username</label><input type="text" name="username" value="" id="username" /><br />
	<label for="email">email</label><input type="text" name="email" value="" id="email" /><br />
	<label for="password">password</label><input type="text" name="password" value="" id="password" /><br />


	<p><input type="submit" value="Continue &rarr;"></p>
</form>
