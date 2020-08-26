<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($admin)) {
  redirect_to(url_for('/staff/admin/index.php'));
}
?>

<dl>
  <dt>first_name</dt>
  <dd><input type="text" name="admin[first_name]" value="<?php echo $admin->first_name; ?>" /></dd>
</dl>

<dl>
  <dt>last_name</dt>
  <dd><input type="text" name="admin[last_name]" value="<?php echo $admin->last_name; ?>" /></dd>
</dl>

<dl>
  <dt>email</dt>
  <dd><input type="email" name="admin[email]" value="<?php echo $admin->email; ?>" /></dd>
</dl>

<dl>
  <dt>username</dt>
  <dd><input type="text" name="admin[username]" value="<?php echo $admin->username; ?>" /></dd>
</dl>

<dl>
  <dt>hashed_password</dt>
  <dd><input type="password" name="admin[hashed_password]" value="<?php echo $admin->hashed_password; ?>" /></dd>
</dl>

