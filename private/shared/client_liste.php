<?php foreach($clients as $client): ?>
<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
    <div class="card <?php echo ($client->active == "1") ? 'active-client' : 'inactive-client'; ?>">
        <a class="img-card" href="<?php echo url_for('/staff/client/payments/index?id=' . h(u($client->id))); ?>">
            <img src="<?php echo url_for('images/' . $client->img); ?>" />
        </a>
        <div class="card-content">
            <h4 class="card-title">
                <a href="<?php echo url_for('/staff/client/payments/index?id=' . h(u($client->id))); ?>">
                    <?php echo strtoupper(h($client->nom) . ' ' . h($client->prenom)); ?>
                </a>
            </h4>
        </div>
    </div>
</div>
<?php endforeach; ?>