<?php 
require_once('../../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/client/index.php'));
}
$id = $_GET['id'];
   
?>


<?php $page_title = 'Information du client'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
        <?php include(SHARED_PATH . '/card_info_client.php'); ?>
            <div class="col-md-8">
            <?= display_session_message() ?>
            <h1 class="table-title">Dernier paiement :</h1>
            <div class="text-right">
                <a class="ajouter" href="<?php echo url_for('/staff/client/payments/new.php?id='. h(u($id))); ?>">Ajouter paiement</a>
                </div>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">La date de Paiements</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <!-- show last_pay -->
                        <tr>
                            <td><?php echo h($client_card_info->last_pay); ?></td>   
                        </tr>
                        <!-- end show -->
                    </tbody>
                </table>
                <h1 class="table-title">La liste des paiements :</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">La date de Paiements</th>
                            <th scope="col">Le prix</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <!-- show all payment by this client -->
                        <?php foreach(Payment::find_by_id_client($id) as $payment): ?>
                        <tr>
                            <td><?php echo h($payment->date_Payment); ?></td>
                            <td><?php echo h($payment->prix); ?></td>
                            <td><a class="edit"
                                    href="<?php echo url_for('/staff/client/payments/edit.php?IdPayment='. h(u($payment->id)) .'&id='. h(u($id))); ?>"><i
                                        class="fa fa-pencil-square-o"></i></a>
                                <a class="delete"
                                    href="<?php echo url_for('/staff/client/payments/delete.php?IdPayment='. h(u($payment->id)) .'&id='. h(u($id))); ?>"><i
                                        class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <!-- end show -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>