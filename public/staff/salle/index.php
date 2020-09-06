<?php 
require_once('../../../private/initialize.php');
require_login();

if(is_post_request()){
    $args = $_POST['salle'];
    $salle = new Salle($args);
    $result = $salle->save();
    if($result === true){
        $session->message("Salle créé avec succès.");
        redirect_to(url_for('/staff/salle/index.php'));
      }else{
        //show errors
      }

}else{
    $salle = new Salle;
}

?>


<?php $page_title = 'Salle'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card form_global">
                    <div class="card-body">
                        <h3 class="card-title">Ajouter Salle :</h3>
                        <div class="card-text">
                            <?= display_session_message() ?>
                            <?= display_errors($salle->errors); ?>
                            <form action="<?php echo url_for('/staff/salle/index.php'); ?>" method="post">
                            <?php include('form_fields.php'); ?>
                                <button type="submit" class="btn btn-success btn-block">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?= display_session_messageTow() ?>
                <h1 class="table-title">La liste des salles :</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nom de la Salle</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <!-- show all salles -->
                        <?php $salles = Salle::find_all(); ?>
                        <?php foreach($salles as $salle):  ?>
                        <tr>
                            <td><?php echo h($salle->nom_Salle); ?></td>
                            <td><a class="edit"
                                    href="<?php echo url_for('/staff/salle/edit.php?id='. h(u($salle->id))); ?>"><i
                                        class="fa fa-pencil-square-o"></i></a>
                                <a class="delete"
                                    href="<?php echo url_for('/staff/salle/delete.php?id='. h(u($salle->id))); ?>"><i
                                        class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <!-- show all salles -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>