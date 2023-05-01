<?php
class Checkout {
    public $id;
    public $user_id;
    public $item_id;
    public $quantity;
    public $start_date;
    public $due_date;
    public $returned_date;
    public $created_at;
    public $updated_at;

    public function save() {
        $db = new SQLite3('../gearhub.db');

        if ($this->id) {
            // Update an existing checkout
            $stmt = $db->prepare('UPDATE checkouts SET user_id=:user_id, item_id=:item_id, quantity=:quantity, start_date=:start_date, due_date=:due_date, returned_date=:returned_date, updated_at=CURRENT_TIMESTAMP WHERE id=:id');
            $stmt->bindValue(':id', $this->id, SQLITE3_INTEGER);
        } else {
            // Create a new checkout
            $stmt = $db->prepare('INSERT INTO checkouts (user_id, item_id, quantity, start_date, due_date, returned_date) VALUES (:user_id, :item_id, :quantity, :start_date, :due_date, :returned_date)');
        }

        $stmt->bindValue(':user_id', $this->user_id, SQLITE3_INTEGER);
        $stmt->bindValue(':item_id', $this->item_id, SQLITE3_INTEGER);
        $stmt->bindValue(':quantity', $this->quantity, SQLITE3_INTEGER);
        $stmt->bindValue(':start_date', $this->start_date, SQLITE3_TEXT);
        $stmt->bindValue(':due_date', $this->due_date, SQLITE3_TEXT);
        $stmt->bindValue(':returned_date', $this->returned_date, SQLITE3_TEXT);
        $stmt->execute();

        if (!$this->id) {
            $this->id = $db->lastInsertRowID();
        }

        $db->close();

        return true;
    }

    public static function find($id) {
        $db = new SQLite3('gearhub.db');
        $stmt = $db->prepare('SELECT * FROM checkouts WHERE id=:id');
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $checkout = $result->fetchArray(SQLITE3_ASSOC);
        $db->close();

        return $checkout;
    }

    public static function all() {
        $db = new SQLite3('gearhub.db');
        $stmt = $db->prepare('SELECT * FROM checkouts');
        $result = $stmt->execute();
        $checkouts = [];
        while ($checkout = $result->fetchArray(SQLITE3_ASSOC)) {
            $checkouts[] = new Checkout($checkout['id'], $checkout['user_id'], $checkout['item_id'], $checkout['quantity'], $checkout['start_date'], $checkout['due_date'], $checkout['returned_date'], $checkout['created_at'], $checkout['updated_at']);
        }
        $db->close();

        return $checkouts;
    }

    public function delete() {
        $db = new SQLite3('gearhub.db');
        $stmt = $db->prepare('DELETE FROM checkouts WHERE id=:id');
        $stmt->bindValue(':id', $this->id, SQLITE3_INTEGER);
        $stmt->execute();
        $db->close();

        return true;
    }
}
