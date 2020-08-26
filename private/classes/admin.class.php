<?php

class Admin extends DatabaseObject {
    static protected $table_name = 'admins';
    static protected $db_columns = ['first_name', 'last_name', 'email', 'username', 'hashed_password'];

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $username;
    public $hashed_password;

    public function __construct($args = [])
    {
        $this->first_name = $args['first_name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->hashed_password = $args['hashed_password'] ?? '';
        
    }
}








?>