<?php 
require_once('../../../private/initialize.php');

require_login();

$current_page = $_GET['page'] ?? 1;
$per_page = 1;
$total_count = Sport::count();
$pagination = new Pagination($current_page, $per_page, $total_count);

$sql = "SELECT s.IdSalle,t.nom_Type,s.prix,t.id FROM Type_Sport t join SportSalle s on t.id = s.IdType ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()} ";
$sports = Sport::find_by_sql($sql);


if(is_post_request()){
    $args = $_POST['sport'];
    $sport = new Sport($args);
    $result = $sport->save();
    if($result === true){
        $session->message("Salle créé avec succès.");
        redirect_to(url_for('/staff/sport/index.php')); 
      }else{
        //show errors
      }

}else{
    $sport = new Sport;
}

?>


<?php $page_title = 'Sport'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card form_global">
                    <div class="card-body">
                        <h3 class="card-title">Ajouter Sport :</h3>
                        <div class="card-text">
                            <?= display_session_message() ?>
                            <?= display_errors($sport->errors); ?>
                            <form action="<?php echo url_for('/staff/sport/index.php'); ?>" method="post">
                            <?php include('form_fields.php'); ?>
                                <button type="submit" class="btn btn-success btn-block">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?= display_session_messageTow() ?>
                <h1 class="table-title">La liste des sports :</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nom de la Salle</th>
                            <th scope="col">Nom du sport</th>
                            <th scope="col">prix</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <!-- show all sport -->
                        <?php foreach($sports as $sport): ?>
                        <?php $salle = Salle::find_by_id($sport->IdSalle); ?>
                        <tr>
                            <td><?php echo h($salle->nom_Salle); ?></td>
                            <td><?php echo h($sport->nom_Type); ?></td>
                            <td><?php echo h($sport->prix); ?></td>
                            <td><a class="edit"
                                    href="<?php echo url_for('/staff/sport/edit.php?id='. h(u($sport->id))); ?>"><i
                                        class="fa fa-pencil-square-o"></i></a>
                                <a class="delete"
                                    href="<?php echo url_for('/staff/sport/delete.php?id='. h(u($sport->id))); ?>"><i
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