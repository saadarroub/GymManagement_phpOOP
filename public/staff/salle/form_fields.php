<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($salle)) {
  redirect_to(url_for('/staff/salle/index.php'));
}
?>

<div class="form-group">
    <label for="exampleInputEmail1">Nom de la Salle <span class="required_inp">*</span></label>
    <input type="text" name="salle[nom_Salle]" value="<?php echo $salle->nom_Salle; ?>" class="form-control form-control-sm"
        placeholder="Tapez votre Nom la Salle">
</div>