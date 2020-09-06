<?php

class Sport extends DatabaseObject {
    static protected $table_name = 'type_sport';
    static protected $db_columns = ['id', 'nom_Type'];

    public $id;
    public $nom_Type;
    public $IdSalle;
    public $prix;
    

    public function __construct($args = [])
    {
        $this->nom_Type = $args['nom_Type'] ?? '';
        $this->IdSalle = $args['IdSalle'] ?? '';
        $this->prix = $args['prix'] ?? '';
    }

    static public function find_all()
    {
        $sql = "SELECT s.IdSalle,t.nom_Type,s.prix,t.id FROM Type_Sport t join SportSalle s on t.id = s.IdType";
        return static::find_by_sql($sql);
    }

    protected function create()
    {
        parent::create();
        $sql = "INSERT INTO SportSalle (IdSalle, IdType, prix) ";
        $sql .= "VALUES (";
        $sql .= "'" . self::$database->escape_string($this->IdSalle) . "', ";
        $sql .= "'" . self::$database->escape_string($this->id) . "', ";
        $sql .= "'" . self::$database->escape_string($this->prix) . "'";
        $sql .= ")";
        $result = self::$database->query($sql);
        return $result;
    }

    protected function update()
    {
        parent::update();
        $sql = "UPDATE SportSalle SET ";
        $sql .= "IdSalle='" . self::$database->escape_string($this->IdSalle) . "', ";
        $sql .= "prix='" . self::$database->escape_string($this->prix) . "' ";
        $sql .= "WHERE IdType='" . self::$database->escape_string($this->id) . "' ";
        $sql .= "LIMIT 1";
        $result = self::$database->query($sql);
        return $result;
    }

    static public function find_by_id($id)
    {
        $sql = "SELECT s.IdSalle,t.nom_Type,s.prix,t.id FROM " . static::$table_name . " t join SportSalle s on t.id = s.IdType";
        $sql .= " WHERE id = '" . self::$database->escape_string($id) . "'";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return array_shift($obj_array); 
        } else {
            return false;
        }
    }

    static public function find_salle_by_sport($id)
    {
      $sql  = "select * from sportsalle ";
      $sql .= "where IdType='" . $id . "' ";
      $sql .= "LIMIT 1";
      //echo $sql;
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return array_shift($obj_array); 
        } else {
            return false;
        }
    }

    protected function validate()
    {
    $this->errors = [];

    if (is_blank($this->nom_Type)) {
      $this->errors[] = "nom_Type cannot be blank.";
    } elseif (!has_length($this->nom_Type, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "nom_Type must be between 2 and 255 characters.";
    }
  
    if (is_blank($this->prix)) {
      $this->errors[] = "prix cannot be blank.";
    } elseif (!has_length($this->prix, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "prix must be between 2 and 255 characters.";
    }
    return $this->errors;
  }
}

