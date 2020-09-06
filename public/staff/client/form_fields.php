<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($client)) {
  redirect_to(url_for('/staff/salle/index.php'));
}
?>

<div class="form-group">
  <label for="exampleInputEmail1">Nom du Client <span class="required_inp">*</span></label>
  <input type="text" name="client[nom]" value="<?= h($client->nom) ?>" class="form-control form-control-sm"
    placeholder="Tapez le Nom">
</div>
<div class="form-group">
  <label for="exampleInputEmail1">Prenom du client <span class="required_inp">*</span></label>
  <input type="text" name="client[prenom]" value="<?= h($client->prenom) ?>" class="form-control form-control-sm"
    placeholder="Tapez le Prenom">
</div>
<div class="form-group">
  <label for="exampleInputEmail1">Tel <span class="required_inp">*</span></label>
  <input type="text" name="client[Tel]" value="<?= h($client->Tel) ?>" class="form-control form-control-sm"
    placeholder="Tapez Tel">
</div>
<div class="form-group">
  <label for="exampleInputEmail1">choisir une image</label>
  <input type='file' name='img' id="img_inp" />
</div>
<div class="form-group">
  <img id="img_preview" src="#" />
</div>
<div class="form-group">
  <label>Choisir la Salle <span class="required_inp">*</span></label>
  <select class="form-control form-control-sm" name="client[IdType]">
    <!-- show all salle sport -->
    <?php foreach(Sport::find_all() as $sport): ?>
    <?php $salle = Salle::find_by_id($sport->IdSalle); ?>
    <option value="<?php echo $sport->id; ?>" <?php if($sport->id == $client->IdType) echo 'selected'; ?>>
      <?php echo $salle->nom_Salle . " " . $sport->nom_Type; ?></option>
    <?php endforeach; ?>
  </select>
</div>