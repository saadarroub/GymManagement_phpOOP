<?php 
require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/users/index.php'));
}
$id = $_GET['id'];

//check : can't delete the current user from this page
$user = User::find_by_id($id);
if($user->id == $_SESSION['admin_id']){
    $session->messageInfo("vous ne pouvez pas supprimer l'utilisateur actuel, utilisez la page de profil.");
    redirect_to(url_for('staff/users/index.php'));
}


if(is_post_request()){
    $result = $user->delete();
    $session->messageTow($user->UserName . " supprimer avec succès.");
    redirect_to(url_for('/staff/users/index.php'));
    }
?>


<?php $page_title = 'Supprimer Utilisateur'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="text-right table-title">
                     <p class="for-back"><a class="text-right" href="<?php echo url_for('staff/users/index.php'); ?>">Utilisateur</a> <i class="fa fa-angle-double-right"></i> supprimer</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Supprimer Utilisateur :</h3>
                        <div class="card-text">
                            <form
                                action="<?php echo url_for('/staff/users/delete.php?id=' . h(u($id))); ?>"
                                method="post">
                                <div class="form-group">
                                    <label>Nom</label>
                                    <input type="text" disabled name="nom" value="<?= h($user->Nom) ?>"
                                        class="form-control form-control-sm" placeholder="Tapez votre Nom">
                                </div>
                                <div class="form-group">
                                    <label>Prenom</label>
                                    <input type="text" disabled name="prenom" value="<?php echo h($user->Prenom) ?>"
                                        class="form-control form-control-sm" placeholder="Tapez votre Prenom">
                                </div>
                                <div class="form-group">
                                    <label>Nom de Utilisateur</label>
                                    <input type="text" disabled name="username" value="<?php echo h($user->UserName) ?>"
                                        class="form-control form-control-sm"
                                        placeholder="Tapez votre Nom de Utilisateur">
                                </div>
                                <div class="form-group">
                                    <p><i class="fa fa-exclamation-circle"></i> voulez vous vraiment supprimer cette enregistrement.</p>
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