<?php 
require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/sport/index.php'));
}
$id = $_GET['id'];
$sport = Sport::find_by_id($id);
if($sport == false){
    redirect_to(url_for('/staff/sport/index.php'));
}


if(is_post_request()){
    $result = $sport->delete();
    $session->messageTow($sport->nom_Type . " supprimer avec succès.");
    redirect_to(url_for('/staff/sport/index.php'));
}
?>


<?php $page_title = 'Supprimer sport'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-right table-title">
                    <p class="for-back"><a class="text-right"
                            href="<?php echo url_for('staff/sport/index.php'); ?>">Sport</a> <i
                            class="fa fa-angle-double-right"></i> supprimer</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Supprimer Sport :</h3>
                        <div class="card-text">
                            <form action="<?php echo url_for('/staff/sport/delete.php?id=' . h(u($id))); ?>"
                                method="post">
                                <div class="form-group">
                                    <label>Nom du sport <span class="required_inp">*</span></label>
                                    <input disabled type="text" name="sport[nom_Type]" value="<?php echo h($sport->nom_Type); ?>"
                                        class="form-control form-control-sm" placeholder="Tapez votre Nom du Sport">
                                </div>
                                <div class="form-group">
                                    <label>Prix <span class="required_inp">*</span></label>
                                    <input disabled type="text" name="sport[prix]" value="<?php echo h($sport->prix); ?>"
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