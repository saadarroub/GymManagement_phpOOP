<?php 
require_once('../../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/client/index.php'));
}
$id = $_GET['id'];
if(!isset($_GET['IdPayment'])){
    redirect_to(url_for('/staff/client/payments/index.php?id=' . h(u($id))));
}
$IdPayment = $_GET['IdPayment'];
$payments = Payment::find_by_id($IdPayment);
if($payments == false){
    redirect_to(url_for('/staff/client/payments/index.php?id=' . h(u($id))));
}


if(is_post_request()){
    $result = $payments->delete();
    if($result === true){
    //get max date payment for this client
    $max_date_payment = Payment::find_max_date_payment_by_id($id)->date_Payment;
    $payments->update_last_pay_after_delete($max_date_payment); 
    $session->message("payment supprimer avec succès.");
    redirect_to(url_for('/staff/client/payments/index.php?id=' . h(u($id))));
    }
} 
    
?>


<?php $page_title = 'Supprimer paiement'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
        <?php include(SHARED_PATH . '/card_info_client.php'); ?>
            <div class="col-md-8">
            <div class="text-right table-title">
                     <p class="for-back"><a class="text-right" href="<?php echo url_for('/staff/client/payments/index.php?id='. h(u($id))); ?>">Information du client</a> <i class="fa fa-angle-double-right"></i> Supprimer paiement</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Supprimer paiement :</h3>
                        <div class="card-text">
                            <form action="<?php echo url_for('/staff/client/payments/delete.php?IdPayment='. h(u($IdPayment)) .'&id='. h(u($id))); ?>" method="post">
                                <div class="form-group">
                                    <label>date de paiement</label>
                                    <input disabled type="date" name="date_Payment" value="<?= h($payments->date_Payment); ?>"
                                        class="form-control form-control-sm" placeholder="Tapez la date">
                                </div>
                                <div class="form-group">
                                    <label>Prix</label>
                                    <input disabled type="text" name="prix" value="<?= h($payments->prix); ?>"
                                        class="form-control form-control-sm" placeholder="Tapez le prix">
                                </div>
                                <button type="submit" class="btn btn-danger btn-block">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>