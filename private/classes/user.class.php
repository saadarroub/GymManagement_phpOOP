<?php

class User extends DatabaseObject
{
  static protected $table_name = 'utilisateur';
  static protected $db_columns = ['id', 'Nom', 'Prenom', 'UserName', 'Password_User'];

  public $id;
  public $Nom;
  public $Prenom;
  public $UserName;
  protected $Password_User;
  public $password;
  public $confirm_password;
  protected $password_required = true;

  public function __construct($args = [])
  {
    $this->Nom = $args['Nom'] ?? '';
    $this->Prenom = $args['Prenom'] ?? '';
    $this->Prenom = $args['Prenom'] ?? '';
    $this->UserName = $args['UserName'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->confirm_password = $args['confirm_password'] ?? '';
  }

  protected function set_hashed_password()
  {
    $this->Password_User = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function verify_password($password)
  {
    return password_verify($password, $this->Password_User);
  }

  
  protected function create()
  {
    $this->set_hashed_password();  
    return parent::create();
  }

  protected function update()
  {
    if ($this->password != '') {
      $this->set_hashed_password();
      //validate password
    } else {
      //skip hashing and
      $this->password_required = false;
    }
    return parent::update();
  }

  protected function validate()
  {
    $this->errors = [];

    if (is_blank($this->Nom)) {
      $this->errors[] = "First name cannot be blank.";
    } elseif (!has_length($this->Nom, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "First name must be between 2 and 255 characters.";
    }

    if (is_blank($this->Prenom)) {
      $this->errors[] = "Last name cannot be blank.";
    } elseif (!has_length($this->Prenom, array('min' => 2, 'max' => 255))) {
      $this->errors[] = "Last name must be between 2 and 255 characters.";
    }

    if (is_blank($this->UserName)) {
      $this->errors[] = "Username cannot be blank.";
    } elseif (!has_length($this->UserName, array('min' => 8, 'max' => 255))) {
      $this->errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($this->UserName, $this->id ?? 0)) {
      $this->errors[] = "Username not allowed, try another.";
    }

    if ($this->password_required) {
      if (is_blank($this->password)) {
        $this->errors[] = "Password cannot be blank.";
      } elseif (!has_length($this->password, array('min' => 12))) {
        $this->errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $this->password)) {
        $this->errors[] = "Password must contain at least 1 symbol";
      }

      if (is_blank($this->confirm_password)) {
        $this->errors[] = "Confirm password cannot be blank.";
      } elseif ($this->password !== $this->confirm_password) {
        $this->errors[] = "Password and confirm password must match.";
      }

      
    }

    return $this->errors;
  }


  static public function find_by_username($username)
  {
    $sql = "SELECT * FROM " . static::$table_name;
    $sql .= " WHERE UserName = '" . self::$database->escape_string($username) . "'";
    $obj_array = static::find_by_sql($sql);
    if (!empty($obj_array)) {
      return array_shift($obj_array);
    } else {
      return false;
    }
  }
}
?>