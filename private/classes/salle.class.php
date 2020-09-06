<?php

class Salle extends DatabaseObject{
    static protected $table_name = 'salle';
    static protected $db_columns = ['id', 'nom_Salle'];

    public $id;
    public $nom_Salle;

    public function __construct($args = [])
    {
        $this->nom_Salle = $args['nom_Salle'] ?? '';
    }

    protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->nom_Salle)) {
      $this->errors[] = "nom_Salle cannot be blank.";
    } elseif (!has_length($this->nom_Salle, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "nom_Salle must be between 2 and 255 characters.";
    }
    return $this->errors;
  }
}