<?php 
require_once('../../../private/initialize.php');
require_login();


if(is_post_request()){
    $args = $_POST['client'];
    $client = new Client($args);
    $clients = $client->filter();
}else{
    $client = new Client;
    $clients = $client::find_all(); 
}
 
?>

<?php $page_title = 'Client'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>
<!-- include search div -->
<?php include(SHARED_PATH . '/search.php'); ?>
<section class="wrapper-fostrap">
    <div class="container-fostrap">
        <div class="content">
            <div class="container">
            <div class="text-right">
                <p class="for-back"><a class="text-right" href="<?php echo url_for('staff/client/new.php');?>">Ajouter client</a></p>
            </div>
                <?= display_session_message() ?>
                <div class="row"> 
                    <!-- show all clients -->
                    <?php include(SHARED_PATH . '/client_liste.php'); ?>
                    <!-- and show -->
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>