<?php

class Client extends DatabaseObject
{
    static protected $table_name = 'clients';
    static protected $db_columns = ['id', 'nom', 'prenom', 'Tel', 'img'];

    public $id;
    public $nom;
    public $prenom;
    public $Tel = 'Nothing';
    public $img;
    public $last_pay;
    public $IdSalle;
    public $IdType;
    public $active;

    public const STATES = [
        'Tout' => '',
        'Activer' => '1',
        'Desactiver' => '0'
    ];

    protected $img_size;
    protected $img_error;


    public function __construct($args = [])
    {
        $this->nom = $args['nom'] ?? '';
        $this->prenom = $args['prenom'] ?? '';
        $this->Tel = $args['Tel'] ?? '';
        $this->img = $args['img'] ?? '';
        $this->active = $args['active'] ?? '';
        $this->IdSalle = $args['IdSalle'] ?? '';
        $this->IdType = $args['IdType'] ?? '';
        $this->img_size = $args['size'] ?? '';
        $this->img_error = $args['img_error'] ?? '';
        $this->active = $args['active'] ?? '';
    }

    private function img_not_required()
    {
        $img_is_not_set = false;
        if ($this->img_error == 4) {
            //img file is blank
            $img_is_not_set =   true;
        }
        return $img_is_not_set;
    }

    static public function find_by_id($id)
    {
        $sql = "SELECT c.*,s.IdType FROM " . static::$table_name . " c JOIN SportClients s ON c.id = s.IdClient";
        $sql .= " WHERE id = '" . self::$database->escape_string($id) . "'";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return array_shift($obj_array); 
        } else {
            return false;
        }
       
    }

    static public function find_actives()
    {
        $sql = "SELECT c.*,s.IdType FROM " . static::$table_name . " c JOIN SportClients s ON c.id = s.IdClient";
        $sql .= " WHERE c.active = true";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return $obj_array; 
        } else {
            return false;
        }
       
    }

    static public function find_active_by_id($id)
    {
        $sql = "SELECT c.*,s.IdType FROM " . static::$table_name . " c JOIN SportClients s ON c.id = s.IdClient";
        $sql .= " WHERE id = '" . self::$database->escape_string($id) . "' ";
        $sql .= "AND c.active = true";
        //echo $sql;
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return $obj_array; 
        } else {
            return false;
        }
       
    }

    protected function create()
    {
        if (!$this->img_not_required()) {
            $img_random = rand(0, 200000);
            $img_extension = get_extenssion($this->img);
            $this->img = $img_random . '.' . $img_extension;
        }else{
            $this->img = 'avatar.jpg';
        }
        parent::create();
        $sql = "INSERT INTO sportclients (IdClient, IdSalle, IdType) ";
        $sql .= "VALUES (";
        $sql .= "'" . self::$database->escape_string($this->id) . "', ";
        $sql .= "'" . self::$database->escape_string($this->IdSalle) . "', ";
        $sql .= "'" . self::$database->escape_string($this->IdType) . "'";
        $sql .= ")";
        $result = self::$database->query($sql);
        return $result;
    }

    protected function update()
    {
        if (!$this->img_not_required()) {
            self::$db_columns = ['id', 'nom', 'prenom', 'Tel', 'img', 'active'];
            $img_random = rand(0, 200000);
            $img_extension = get_extenssion($this->img);
            $this->img = $img_random . '.' . $img_extension;
        }else{
            self::$db_columns = ['id', 'nom', 'prenom', 'Tel', 'active'];
        }
        
        parent::update();
        $sql = "UPDATE sportclients SET ";
        $sql .= "IdSalle='" . self::$database->escape_string($this->IdSalle) . "', ";
        $sql .= "IdType='" . self::$database->escape_string($this->IdType) . "' ";
        $sql .= "WHERE IdClient='" . self::$database->escape_string($this->id) . "' ";
        $sql .= "LIMIT 1";
        //echo $sql;
        $result = self::$database->query($sql);
        return $result;
    }

    public function filter()
    {
        $sport_sent = !is_blank($this->IdType);
        $nom_sent = !is_blank($this->nom);
        $active_sent = !is_blank($this->active);


        $sql = "SELECT c.*,s.IdType FROM Clients c JOIN sportclients s ON c.id = s.IdClient ";
        if ($nom_sent && $sport_sent && $active_sent) {
            $sql .= "WHERE c.nom LIKE '%" . self::$database->escape_string($this->nom) . "%' 
            AND s.IdType ='" . self::$database->escape_string($this->IdType) . "' AND c.active = '" . self::$database->escape_string($this->active) . "' ";
        } elseif ($nom_sent && $sport_sent) {
            $sql .= "WHERE c.nom LIKE '%" . self::$database->escape_string($this->nom) . "%' AND s.IdType ='" . self::$database->escape_string($this->IdType) . "'";
        } elseif ($sport_sent && $active_sent) {
            $sql .= "WHERE s.IdType ='" . self::$database->escape_string($this->IdType) . "' AND c.active = '" . self::$database->escape_string($this->active) . "'";
        } elseif ($nom_sent && $active_sent) {
            $sql .= "WHERE c.nom LIKE '%" . self::$database->escape_string($this->nom) . "%' AND c.active = '" . self::$database->escape_string($this->active) . "'";
        } elseif ($nom_sent) {
            $sql .= "WHERE c.nom LIKE '%" . self::$database->escape_string($this->nom) . "%'";
        } elseif ($sport_sent) {
            $sql .= "WHERE s.IdType ='" . self::$database->escape_string($this->IdType) . "'";
        } elseif ($active_sent) {
            $sql .= "WHERE c.active = '" . self::$database->escape_string($this->active) . "'";
        }

        return static::find_by_sql($sql);
    }

    static public function show_notifications(){
        $notifications = [];
        foreach(self::find_actives() as $client){
            if($client->last_pay !== NULL){
                $date_now = new DateTime('now');
                $client_pay_date = new DateTime($client->last_pay);
                $interval = date_diff($date_now, $client_pay_date);
                $count_days = $interval->format('%a');
                if ($count_days >= 28 && $count_days <= 30) {  
                   $notifications[$client->id] = "L'abonnement de dette personne se termine très bientôt";
                }
                elseif ($count_days > 30 && $count_days <= 40) { 
                    $notifications[$client->id] = "L'abonnement de cette personne est terminé";
                }
                elseif ($count_days > 40) { 
                    $notifications[$client->id] = "Vous pouvez désactiver cette personne, car son abonnement est terminé il y a longtemps";
                }
             }
        }
        return $notifications;
    }

    protected function validate()
    {
        $this->errors = [];

        // nom client 
        if (is_blank($this->nom)) {
            $this->errors[] = "Le nom ne peut pas être vide.";
        } elseif (!has_length($this->nom, ['min' => 2, 'max' => 255])) {
            $this->errors[] = "Nom doit comprendre entre 2 et 255 caractères.";
        }

        // prenom client 
        if (is_blank($this->prenom)) {
            $this->errors[] = "Le prenom ne peut pas être vide.";
        } elseif (!has_length($this->prenom, ['min' => 2, 'max' => 255])) {
            $this->errors[] = "Prenom doit comprendre entre 2 et 255 caractères.";
        }

        // tel client 
        if (is_blank($this->Tel)) {
            $this->errors[] = "Tel ne peut pas être vide.";
        } elseif (!has_length($this->Tel, ['min' => 2, 'max' => 255])) {
            $this->errors[] = "Tel doit comprendre entre 2 et 255 caractères.";
        }

        if (!$this->img_not_required()) {
            if ($this->img_size > 200000) {
                $this->errors[] = "image can't more than 2 Mo.";
            }

            //check file is valide
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            //get end of the array as string (extension)
            $extension = explode('.', $this->img);
            $img_extension = strtolower(end($extension));
            //checking if extensions in my_array_extensions
            if (!in_array($img_extension, $allowed_extensions)) {
                $this->errors[] = "invalide image.";
            }
        }

        return $this->errors;
    }
}
