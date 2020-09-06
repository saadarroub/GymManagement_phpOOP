<?php 
require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/salle/index.php'));
}
$id = $_GET['id'];
$salle = Salle::find_by_id($id);
if($salle == false){
    redirect_to(url_for('staff/salle/index.php'));
}

if(is_post_request()){
    $result = $salle->delete();
    $session->messageTow($salle->nom_Salle . " supprimer avec succès.");
    redirect_to(url_for('/staff/salle/index.php'));
}
?>


<?php $page_title = 'Supprimer salle'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-right table-title">
                    <p class="for-back"><a class="text-right" href="<?php echo url_for('staff/salle/index.php'); ?>">Salle</a> <i
                            class="fa fa-angle-double-right"></i> supprimer</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Supprimer la Salle :</h3>
                        <div class="card-text">
                            <form action="<?php echo url_for('/staff/salle/delete.php?id='. h(u($id))); ?>"
                                method="post">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nom de la Salle <span
                                            class="required_inp">*</span></label>
                                    <input disabled type="text" name="nom_Salle" value="<?php echo $salle->nom_Salle; ?>"
                                        class="form-control form-control-sm" placeholder="Tapez votre Nom la Salle">
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