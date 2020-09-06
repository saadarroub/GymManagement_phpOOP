<?php 
//TO DO : remove image from images when i delete
require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/client/index.php'));
}
$id = $_GET['id'];
$client = Client::find_by_id($id);
if($client == false){
    redirect_to(url_for('staff/client/index.php'));
}

if(is_post_request()){
    $result = $client->delete();
    $session->message($client->prenom . " supprimer avec succès.");
    redirect_to(url_for('/staff/client/index.php'));
}

?>


<?php $page_title = 'Supprimer Client'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <?php include(SHARED_PATH . '/card_info_client.php'); ?>
            <div class="col-md-8">
                <div class="text-right table-title">
                    <p class="for-back"><a class="text-right"
                        href="<?php echo url_for('/staff/client/payments/index.php?id='. h(u($id))); ?>">Information du client</a>
                        <i class="fa fa-angle-double-right"></i> Supprimer client</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Supprimer Client :</h3>
                        <div class="card-text">
                            <form action="<?php echo url_for('/staff/client/delete.php?id=' . h(u($id))) ; ?>"
                                method="post" runat="server" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nom du Client <span
                                            class="required_inp">*</span></label>
                                    <input disabled type="text" name="nom" value="<?= h($client->nom) ?>"
                                        class="form-control form-control-sm" placeholder="Tapez le Nom">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Prenom du client <span
                                            class="required_inp">*</span></label>
                                    <input disabled type="text" name="prenom" value="<?= h($client->prenom) ?>"
                                        class="form-control form-control-sm" placeholder="Tapez le Prenom">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tel <span class="required_inp">*</span></label>
                                    <input disabled type="text" name="Tel" value="<?= h($client->Tel) ?>"
                                        class="form-control form-control-sm" placeholder="Tapez Tel">
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