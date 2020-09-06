<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($sport)) {
  redirect_to(url_for('/staff/salle/index.php'));
}
?>

<div class="form-group">
  <label>Choisir la Salle <span class="required_inp">*</span></label>
  <select class="form-control form-control-sm" name="sport[IdSalle]">
    <!-- show all sport and salle -->
    <?php foreach(Salle::find_all() as $salle): ?>
      <option value="<?php echo $salle->id; ?>"<?php if($sport->IdSalle == $salle->id) echo 'selected'; ?>><?php echo $salle->nom_Salle; ?></option>
    <?php endforeach; ?>
  </select>
</div>
<div class="form-group">
  <label>Nom du sport <span class="required_inp">*</span></label>
  <input type="text" name="sport[nom_Type]" value="<?php echo h($sport->nom_Type); ?>" class="form-control form-control-sm"
    placeholder="Tapez votre Nom du Sport">
</div>
<div class="form-group">
  <label>Prix <span class="required_inp">*</span></label>
  <input type="text" name="sport[prix]" value="<?php echo h($sport->prix); ?>" class="form-control form-control-sm"
    placeholder="Tapez le prix">
</div>