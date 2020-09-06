<?php 
//get client infos and this sport - salle
$client_card_info = Client::find_by_id($id);
$sport_card_info = Sport::find_by_id($client_card_info->IdType);
$salle_card_info = Salle::find_by_id($sport_card_info->IdSalle);
?>
<div class="col-md-4">
    <div class="wrapper-fostrap">
        <div class="card card_client_info <?php echo ($client_card_info->active == "1") ? 'active-client' : 'inactive-client'; ?>">
            <div class="img-card">
                <img src="<?php echo url_for('images/' . $client_card_info->img); ?>" />
            </div>
            <div class="card-content">
                <h4 class="card-title">
                    <?php echo strtoupper(h($client_card_info->nom) . ' ' . h($client_card_info->prenom)) .
                     ' (' .h($salle_card_info->nom_Salle) . ' - ' . h($sport_card_info->nom_Type) . ')' ; ?>
                </h4>
            </div>
            <div class="card-read-more">
                <a 
                    href="<?php echo url_for('/staff/client/payments/index?id=' . h(u($client_card_info->id))); ?>"><i class="fa fa-home"></i></a>
                <a
                    href="<?php echo url_for('/staff/client/edit?id=' . h(u($client_card_info->id))); ?>"><i class="fa fa-pencil-square-o"></i></a>
                <a
                    href="<?php echo url_for('/staff/client/delete?id=' . h(u($client_card_info->id))); ?>"><i class="fa fa-trash-o"></i></a>
            </div>
        </div>
    </div>
</div>