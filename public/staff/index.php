<?php 
require_once('../../private/initialize.php');
require_login();
//number of users
$utilisateur_count = User::count();

//number of clients active
$active_clients = Client::find_actives();
$client_count = count($active_clients);

//number of sports
$sport_count = Sport::count();

//show notifications
$notifications = Client::show_notifications();
?>



<?php include(SHARED_PATH . '/header.php'); ?>
<section class="section_home">
   <div class="container">
      <div class="row mb-3 table-title">
         <div class="col-lg-3 col-md-6 col-sm-6 col-xm-12 spacing-card">
            <div class="card card-inverse card-success">
               <div class="card-block bg-success">
                  <div class="rotate">
                     <i class="fa fa-user fa-5x"></i>
                  </div>
                  <h6 class="text-uppercase">Clients</h6>
                  <h1 class="display-1"><?php echo h($client_count); ?></h1>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-xm-12 spacing-card">
            <div class="card card-inverse card-danger">
               <div class="card-block bg-danger">
                  <div class="rotate">
                     <i class="fa fa-list fa-4x"></i>
                  </div>
                  <h6 class="text-uppercase">Notifications</h6>
                  <h1 class="display-1"><?php echo h(count($notifications)); ?></h1>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-xm-12 spacing-card">
            <div class="card card-inverse card-info">
               <div class="card-block bg-info">
                  <div class="rotate">
                     <i class="fa fa-twitter fa-5x"></i>
                  </div>
                  <h6 class="text-uppercase">Utilisateurs</h6>
                  <h1 class="display-1"><?php echo h($utilisateur_count); ?></h1>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6 col-sm-6 col-xm-12 spacing-card">
            <div class="card card-inverse card-warning">
               <div class="card-block bg-warning">
                  <div class="rotate">
                     <i class="fa fa-share fa-5x"></i>
                  </div>
                  <h6 class="text-uppercase">Sports</h6>
                  <h1 class="display-1"><?php echo h($sport_count); ?></h1>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section class="wrapper-fostrap">
   <div class="container-fostrap">
      <div class="content">
         <div class="container">
         <h1 class="table-title text-left">Notifications :</h1>
            <div class="row">
               <!-- loop for get id_client -->
               <?php if(count($notifications) > 0): ?>
               <?php foreach($notifications as $key => $value): ?>
               <!-- find client -->
               <?php foreach(Client::find_active_by_id($key) as $client_has_not): ?>
               <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                  <div class="card">
                     <div class="img-card">
                        <img src="<?php echo url_for('images/' . $client_has_not->img); ?>" />
                     </div>
                     <div class="card-content">
                        <h4 class="card-title">
                        <a href="<?php echo url_for('/staff/client/payments/index?id=' . h(u($key))); ?>">
                           <?php echo strtoupper(h($client_has_not->nom) . ' ' . h($client_has_not->prenom)); ?>
                        </a>
                        </h4>
                        <p>
                           <?php echo h($value); ?>
                        </p>
                     </div>
                  </div>
               </div>
               <?php endforeach; ?>
               <?php endforeach; ?>
               <?php else: ?>
                <h1 class="table-title">No Notifications</h1>
               <?php endif; ?>

            </div>
         </div>
      </div>
   </div>
</section>


<?php include(SHARED_PATH . '/footer.php'); ?>
