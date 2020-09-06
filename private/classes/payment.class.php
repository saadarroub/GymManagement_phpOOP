<?php

class Payment extends DatabaseObject {
    static protected $table_name = 'payments';
    static protected $db_columns = ['id', 'date_Payment', 'IdClient', 'IdSalle', 'IdType', 'prix'];

    public $id;
    public $date_Payment;
    public $IdClient;
    public $IdSalle;
    public $IdType;
    public $prix;

    public function __construct($args = [])
    {
        $this->date_Payment = $args['date_Payment'] ?? '';
        $this->IdClient = $args['IdClient'] ?? '';
        $this->IdSalle = $args['IdSalle'] ?? '';
        $this->IdType = $args['IdType'] ?? '';
        $this->prix = $args['prix'] ?? '';
    }

    static public function find_by_id_client($id)
    {
        $sql = "SELECT * FROM " . static::$table_name;
        $sql .= " WHERE IdClient = '" . self::$database->escape_string($id) . "'";
        return static::find_by_sql($sql);
    }

    public function update_last_pay(){
        $sql = "UPDATE clients SET "; 
        $sql .= "last_pay='" . self::$database->escape_string($this->date_Payment) . "' ";
        $sql .= "WHERE id='" . self::$database->escape_string($this->IdClient) . "' ";
        $sql .= "LIMIT 1";
        //echo $sql;
        $result = self::$database->query($sql);
        return $result;

    }

    static public function find_max_date_payment_by_id($id){
        $sql = "SELECT MAX(date_Payment) as date_Payment from payments ";
        $sql .= "WHERE IdClient='" . self::$database->escape_string($id) . "' ";
        $sql .= "LIMIT 1";
        $obj_array = static::find_by_sql($sql);
        if (!empty($obj_array)) {
            return array_shift($obj_array); 
        } else {
            return false;
        }
    }

    public function update_last_pay_after_delete($max_date_payment){
        $sql = "UPDATE clients SET "; 
        $sql .= "last_pay='" . self::$database->escape_string($max_date_payment) . "' ";
        $sql .= "WHERE id='" . self::$database->escape_string($this->IdClient) . "' ";
        $sql .= "LIMIT 1";
        //echo $sql;
        $result = self::$database->query($sql);
        return $result;

    }

    protected function validate()
    {
        $this->errors = [];

        // date_Payment
        if (is_blank($this->date_Payment)) {
            $this->errors[] = "date_Payment ne peut pas être vide.";
        }

        // prix
        if (is_blank($this->prix)) {
            $this->errors[] = "Le prenom ne peut pas être vide.";
        }

        return $this->errors;
    }

}