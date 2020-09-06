<?php 
//TO DO : remove image from images when i update 
require_once('../../../private/initialize.php');
require_login();

if(!isset($_GET['id'])){
    redirect_to(url_for('staff/client/index.php'));
}
$id = $_GET['id'];
$client = Client::find_by_id($id);
if($client == false){
    redirect_to(url_for('/staff/client/index.php'));
}


if(is_post_request()){
  //infos files
  $img_name = $_FILES['img']['name'] ?? '';
  $img_size = $_FILES['img']['size'] ?? '';
  $img_error = $_FILES['img']['error'] ?? '';
  $img_temp = $_FILES['img']['tmp_name'] ?? '';

   //values for insert client
   $args = $_POST['client'];
   $salle = Sport::find_salle_by_sport($args['IdType']);
   $args['IdSalle'] = $salle->IdSalle;
   $args['img'] = $img_name;
   $args['size'] = $img_size;
   $args['img_error'] = $img_error;

   $client->merge_attributes($args);
   $result = $client->save(); 

   if($result === true){
      //set the destination 
      $destination = $_SERVER['DOCUMENT_ROOT'] . url_for('images/' . $client->img);
      //move images to my_destination
      move_uploaded_file($img_temp, $destination);
      $session->message("client modifier avec succès.");
       redirect_to(url_for('/staff/client/payments/index?id=' . h(u($client->id))));
       } 
   else{
   //show arrors
   }
}else{
    //show from 
    
}

?>


<?php $page_title = 'Modifier client'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
        <?php include(SHARED_PATH . '/card_info_client.php'); ?>
            <div class="col-md-8">
            <div class="text-right table-title">
                     <p class="for-back"><a class="text-right" href="<?php echo url_for('/staff/client/payments/index.php?id='. h(u($id))); ?>">Information du client</a> <i class="fa fa-angle-double-right"></i> Modifier client</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Modifier client :</h3>
                        <div class="card-text">
                            <?= display_errors($client->errors); ?>
                            <form
                                action="<?php echo url_for('/staff/client/edit.php?id=' . h(u($id))) ; ?>"
                                method="post" runat="server" enctype="multipart/form-data">
                                <?php include('form_fields.php'); ?>
                                <div class="form-group">
                                <label>Changer le statue</label>
                                    <div class="custom-control custom-switch">
                                    <input type="hidden" name="client[active]" value="0" />
                                    <input type="checkbox" name="client[active]" value="1" <?php if($client->active == "1") { echo " checked"; } ?> class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1"><?php echo ($client->active == "1") ? 'Desactiver' : 'Activer'; ?></label>
                                    </div>
                                </div>
                                <!-- end show -->
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