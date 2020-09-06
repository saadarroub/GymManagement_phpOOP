<?php 
require_once('../../../private/initialize.php');
require_login();

if(is_post_request()){
    $args = $_POST['user'];
    $user = new User($args);
    $result = $user->save();

    if($result === true){
      $session->message("Utilisateur créé avec succès.");
      redirect_to(url_for('/staff/users/index.php'));
    }else{
      //show errors
    }
  }else{
    $user = new User; 
  }
?>


<?php $page_title = 'Utilisateur'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card form_global">
                    <div class="card-body">
                        <h3 class="card-title">Ajouter Utilisateur :</h3>
                        <div class="card-text">
                            <?= display_session_message() ?>
                            <?= display_errors($user->errors); ?>
                            <form action="<?php echo url_for('/staff/users/index.php'); ?>" method="post">
                            <?php include('form_fields.php'); ?>
                                <button type="submit" class="btn btn-success btn-block">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                  <?= display_session_messageTow() ?>
                  <?= display_session_messageInfo() ?>
                  <h1 class="table-title">La liste des Utilisateurs :</h1>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">Username</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-light">
                        <!-- show all users -->
                        <?php $users = User::find_all(); ?>
                        <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo h($user->Nom); ?></td>
                            <td><?php echo h($user->Prenom); ?></td>
                            <td><?php echo h($user->UserName); ?></td>
                            <td><a class="edit"
                                    href="<?php echo url_for('/staff/users/edit.php?id='. h(u($user->id))); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="delete"
                                    href="<?php echo url_for('/staff/users/delete.php?id='. h(u($user->id))); ?>"><i class="fa fa-trash-o"></i></a>
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