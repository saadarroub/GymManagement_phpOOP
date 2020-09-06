<?php 
require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/users/index.php'));
}
$id = $_GET['id'];
$user = User::find_by_id($id);
if($user == false){
    redirect_to(url_for('staff/users/index.php'));
}

if(is_post_request()){
    $args = $_POST['user'];
    $user->merge_attributes($args);
    $result = $user->save();
    if($result === true){
        $session->messageTow("utilisateur modifier avec succès.");
        redirect_to(url_for('/staff/users/index.php'));
      }else{
        //show errors
      }

}else{
    //show form
}

?>


<?php $page_title = 'Modifier utilisateur'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="text-right table-title">
                     <p class="for-back"><a class="text-right" href="<?php echo url_for('staff/users/index.php'); ?>">Utilisateur</a> <i class="fa fa-angle-double-right"></i> modifier</p>
                </div>
            <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Modifier Utilisateur :</h3>
                        <div class="card-text">
                            <?= display_errors($user->errors); ?>
                            <form action="<?php echo url_for('/staff/users/edit.php?id=' . h(u($id))); ?>" method="post">
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