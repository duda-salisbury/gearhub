<?php
namespace App\Models;
class User {
    private $id;
    private $name;
    private $email;
    private $type;
    private $password;
    private $created_at;
    private $updated_at;

    public function __construct($id = null, $name = null, $email = null, $type= null,  $password = null, $created_at = null, $updated_at = null) {
        $this->id = $id;

        $this->name = $name;
        $this->email = $email;
        $this->type = $type;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }


    public static function findById($id) {

        $db = new SQLite3('../gearhub.db');
        $results = $db->query("SELECT * FROM users WHERE id = $id");
        $user = $results->fetchArray(SQLITE3_ASSOC);
        $db->close();

        return new User($user['id'], $user['name'], $user['email'], $user['type'], $user['password'], $user['created_at'], $user['updated_at']);
    }

    public static function findAll() {
        $db = new SQLite3('../gearhub.db');
        $results = $db->query("SELECT * FROM users");
        $users = [];
        while ($user = $results->fetchArray(SQLITE3_ASSOC)) {
            $users[] = new User($user['id'], $user['name'], $user['email'], $user['type'], $user['password'], $user['created_at'], $user['updated_at']);
        }
        $db->close();
        return $users;
    }


    public function save() {
        $db = new SQLite3('../gearhub.db');
        // if the id is null, then we are creating a new record
        
        if ($this->id == null) {
            $results = $db->query("INSERT INTO users (name, email, type, password, created_at, updated_at) VALUES ('$this->name', '$this->email', '$this->type', '$this->password', '$this->created_at', '$this->updated_at')");
            $this->id = $db->lastInsertRowID();
        } else {
            $results = $db->query("UPDATE users SET name = '$this->name', email = '$this->email', type = '$this->type', password = '$this->password', created_at = '$this->created_at', updated_at = '$this->updated_at' WHERE id = $this->id");
        }

        $changes = $db->changes();
        $db->close();

        if ($changes > 0) {
           
            return true;
        } else {
            
            return false;
        }
    }

}
