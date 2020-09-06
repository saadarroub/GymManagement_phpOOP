<?php
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    $user = User::find_by_username($username);
    // test if admin found and password is correct
    if($user != false && $user->verify_password($password)) {
      // Mark admin as logged in
      $session->login($user);
      redirect_to(url_for('/staff/index.php'));
    } else {
      // username not found or password does not match
      $errors[] = "Log in was unsuccessful.";
    }
  }

}

?>

<?php $page_title = 'Log in'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_login">
  <div class="global-container">
    <div class="card login-form">
      <div class="card-body">
        <h3 class="card-title text-center">Log in to SM-Program</h3>
        <div class="card-text">
          <?= display_session_message() ?>
          <?= display_errors($errors); ?>
          <form action="<?php echo url_for('/staff/login.php'); ?>" method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Nom d'utilisateur</label>
              <input type="text" name="username" value="<?php echo h($username); ?>"
                class="form-control form-control-sm" placeholder="Tapez votre Nom d'utilisateur">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Le mot de passe</label>
              <input type="password" name="password" class="form-control form-control-sm" id="exampleInputPassword1"
                placeholder="Le mot de passe">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            <!-- check if user is not registred -->
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>
