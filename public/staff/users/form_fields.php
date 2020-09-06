<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($user)) {
  redirect_to(url_for('/staff/users/index.php'));
}
?>

<div class="form-group">
    <label>Nom <span class="required_inp">*</span></label>
    <input type="text" name="user[Nom]" value="<?php echo $user->Nom; ?>" class="form-control form-control-sm"
        placeholder="Tapez votre Nom">
</div>
<div class="form-group">
    <label>Prenom <span class="required_inp">*</span></label>
    <input type="text" name="user[Prenom]" value="<?php echo $user->Prenom; ?>"
        class="form-control form-control-sm" placeholder="Tapez votre Prenom">
</div>
<div class="form-group">
    <label>Nom de Utilisateur <span class="required_inp">*</span></label>
    <input type="text" name="user[UserName]" value="<?php echo $user->UserName; ?>"
        class="form-control form-control-sm" placeholder="Tapez votre Nom de Utilisateur">
</div>
<div class="form-group">
    <label>Password <span class="required_inp">*</span></label>
    <input type="password" name="user[password]" class="form-control" value="<?php echo $user->password; ?>" id="exampleInputPassword1" placeholder="Password">
</div>
<div class="form-group">
    <label>Confirm Password <span class="required_inp">*</span></label>
    <input type="password" name="user[confirm_password]" class="form-control" value="<?php echo $user->confirm_password; ?>" id="exampleInputPassword1"
        placeholder="Confirm Password">
</div>