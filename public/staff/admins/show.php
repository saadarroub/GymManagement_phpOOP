<?php require_once('../../../private/initialize.php'); ?>

<?php

$id = $_GET['id'] ?? '1'; // PHP > 7.0

$admin = Admin::find_by_id($id);

?>

<?php $page_title = 'Show admin: ' . h($admin->first_name); ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin show">
<?php echo display_session_message() ?>
    <h1>Admin: <?php echo h($admin->first_name); ?></h1>

    <div class="attributes">
      <dl>
        <dt>first_name</dt>
        <dd><?php echo h($admin->first_name); ?></dd>
      </dl>
      <dl>
        <dt>last_name</dt>
        <dd><?php echo h($admin->last_name); ?></dd>
      </dl>
      <dl>
        <dt>email</dt>
        <dd><?php echo h($admin->email); ?></dd>
      </dl>
      <dl>
        <dt>username</dt>
        <dd><?php echo h($admin->username); ?></dd>
      </dl>
    </div>

  </div>

</div>
