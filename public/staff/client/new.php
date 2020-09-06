<?php 
require_once('../../../private/initialize.php');

require_login();

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
    $client = new Client($args);
    $result = $client->save(); 

    if($result === true){
        //set the destination 
        $destination = $_SERVER['DOCUMENT_ROOT'] . url_for('images/' . $client->img);
        //move images to my_destination
        move_uploaded_file($img_temp, $destination);
        $session->message("Client créé avec succès.");
        redirect_to(url_for('/staff/client/index.php'));
        } 
    else{
    //show errors
    }

  }else{
      $client = new Client;
  }



?>


<?php $page_title = 'Ajouter Client'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<section class="section_global">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="text-right table-title">
                     <p class="for-back"><a class="text-right" href="<?php echo url_for('/staff/client/index.php'); ?>">La liste des clients</a> <i class="fa fa-angle-double-right"></i> Ajouter client</p>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Ajouter Client :</h3>
                        <div class="card-text">
                            <?= display_errors($client->errors); ?>
                            <form action="<?php echo url_for('/staff/client/new.php'); ?>" method="post" runat="server"
                                enctype="multipart/form-data">
                                <?php include('form_fields.php'); ?>
                                <button type="submit" class="btn btn-success btn-block">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(SHARED_PATH . '/footer.php'); ?>