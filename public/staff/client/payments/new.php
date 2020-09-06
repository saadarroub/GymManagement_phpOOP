<?php 
require_once('../../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/client/index.php'));
}
$id = $_GET['id'];

//get client -> salle -> sport for this client (for inserting payment)
$client = Client::find_by_id($id);
$sport = Sport::find_by_id($client->IdType);
$salle = Salle::find_by_id($sport->IdSalle);

//get last_pay for this client
$get_last_pay = $client->last_pay;

if(is_post_request()){
    $args = $_POST['payments'];
    $args['IdType'] = $sport->id;
    $args['IdSalle'] = $salle->id;
    $args['IdClient'] = $id;
    $payments = new Payment($args);
    $result = $payments->save();
    if($result === true){
        //change last_pay after adding (set other date; if this date > last_pay or new date if last_pay = null)
        if($payments->date_Payment > $get_last_pay){
            $payments->update_last_pay();
        }
        $_SESSION['message'] = "payment créé avec succès.";
        redirect_to(url_for('/staff/client/payments/index.php?id=' . $client->id));
      }else{
        //show errors
      }   
   
}  else{
    //show form 
    $payments = new Payment;
}
    
    
?>


<?php $page_title = 'Ajouter paiement'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
        <?php include(SHARED_PATH . '/card_info_client.php'); ?>
            <div class="col-md-8">
            <div class="text-right table-title">
                     <p class="for-back"><a class="text-right" href="<?php echo url_for('/staff/client/payments/index.php?id='. h(u($id))); ?>">Information du client</a> <i class="fa fa-angle-double-right"></i> Ajouter paiement</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Ajouter paiement :</h3>
                        <div class="card-text">
                            <?= display_session_message() ?>
                            <?= display_errors($payments->errors); ?>
                            <form
                                action="<?php echo url_for('/staff/client/payments/new.php?id='. h(u($id))); ?>"
                                method="post">
                                <?php include('form_fields.php'); ?>
                                <button type="submit" class="btn btn-success btn-block">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>