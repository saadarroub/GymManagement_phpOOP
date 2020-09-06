<?php
// prevents this code from being loaded directly in the browser
// or without first setting the necessary object
if(!isset($payments)) {
  redirect_to(url_for('/staff/salle/index.php'));
}
?>

<div class="form-group">
  <label>date de paiement <span class="required_inp">*</span></label>
  <input type="date" name="payments[date_Payment]" value="<?= h($payments->date_Payment); ?>"
    class="form-control form-control-sm" placeholder="Tapez la date">
</div>
<div class="form-group">
  <label>Prix <span class="required_inp">*</span></label>
  <input type="text" name="payments[prix]" value="<?= h($payments->prix); ?>" class="form-control form-control-sm"
    placeholder="Tapez le prix">
</div>