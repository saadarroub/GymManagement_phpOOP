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

//get client
//get last_pay for this client
$client = Client::find_by_id($id);
$get_last_pay = $client->last_pay;

if(is_post_request()){
    $args = $_POST['payments'];
    $payments->merge_attributes($args);
    $result = $payments->save(); 
    if($result === true){
        //change last_pay after updating (set new date; if this date > last_pay)
        if($payments->date_Payment > $get_last_pay){
            $payments->update_last_pay();
        }
        $session->message("payment modifier avec succès.");
        redirect_to(url_for('/staff/client/payments/index.php?id=' . h(u($id))));
      }else{
        //errors
      }   
   
}  else{
    //show form
}
    
    
?>


<?php $page_title = 'Modifier paiement'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
        <?php include(SHARED_PATH . '/card_info_client.php'); ?>
            <div class="col-md-8">
            <div class="text-right table-title">
                     <p class="for-back"><a class="text-right" href="<?php echo url_for('/staff/client/payments/index.php?id='. h(u($id))); ?>">Information du client</a> <i class="fa fa-angle-double-right"></i> Modifier paiement</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Modifier paiement :</h3>
                        <div class="card-text">
                            <?= display_session_message() ?>
                            <?= display_errors($payments->errors); ?>
                            <form
                                action="<?php echo url_for('/staff/client/payments/edit.php?IdPayment='. h(u($IdPayment)) .'&id='. h(u($id))); ?>""
                                method="post">
                                <?php include('form_fields.php'); ?>
                                <button type="submit" class="btn btn-success btn-block">Modifier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>