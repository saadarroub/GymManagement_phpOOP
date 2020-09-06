<div class="container">
    <form action="<?php echo url_for('/staff/client/index.php'); ?>" method="post">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Choisir la Salle</label>
                    <select class="form-control form-control-sm" name="client[IdType]">
                    <option value="">Tout</option>
                    <!-- show all salle sport -->
                    <?php foreach(Sport::find_all() as $sport): ?>   
                    <?php $salle = Salle::find_by_id($sport->IdSalle);  ?>  
                    <option value="<?php echo $sport->id; ?>"<?php if($sport->id == $client->IdType) echo 'selected'; ?>><?php echo $salle->nom_Salle . "-" . $sport->nom_Type; ?></option>
                    <?php endforeach; ?>
                    <!-- show all salle sport -->
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nom du client</label> <input type="text" name="client[nom]"
                        value="<?php echo $client->nom; ?>" class="form-control form-control-sm"
                        placeholder="Tapez le Nom">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Statue</label>
                    <select class="form-control form-control-sm" name="client[active]">
                    <?php foreach(Client::STATES as $key => $value): ?> 
                    <option value="<?php echo $value; ?>"<?php if($value == $client->active) echo 'selected'; ?>><?php echo $key; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
</div>