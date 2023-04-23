<?php 
class Item
{
    private $id;
    public $name;
    public $description;
    private $category;
    private $condition;
    private $location;
    private $quantity;
    private $available;
    private $max_checkout;
    private $image_url;
    private $created_at;
    private $updated_at;
    
    public function __construct($id=null, $name=null, $description=null, $category=null, $condition=null, $location=null, $quantity=null, $available=null, $max_checkout=null, $image_url=null, $created_at=null, $updated_at=null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
        $this->condition = $condition;
        $this->location = $location;
        $this->quantity = $quantity;
        $this->available = $available;
        $this->max_checkout = $max_checkout;
        $this->image_url = $image_url;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    
    public static function findById($id)
    {
        // TODO: Retrieve an item by its ID from the database
        $db = new SQLite3('gearhub.db');
        $results = $db->query("SELECT * FROM items WHERE id = $id");
        $item = $results->fetchArray();
        $db->close();

        return new Item($item['id'], $item['name'], $item['description'], $item['category'], $item['condition'], $item['location'], $item['quantity'], $item['available'], $item['max_checkout'], $item['image_url'], $item['created_at'], $item['updated_at']);
        
    }
    
    public static function findAll()
    {
        // TODO: Retrieve all items from the database
        $db = new SQLite3('gearhub.db');
        $results = $db->query("SELECT * FROM items");
        // check for sqlite error
        if (!$results) {
            echo $db->lastErrorMsg();
        }
        $items = [];
        while ($item = $results->fetchArray()) {
            $items[] = new Item($item['id'], $item['name'], $item['description'], $item['category'], $item['condition'], $item['location'], $item['quantity'], $item['available'], $item['max_checkout'], $item['image_url'], $item['created_at'], $item['updated_at']);
        }
        $db->close();
        return $items;
    }
    
    public function save()
    {
        // TODO: Save the item to the database (INSERT if new, UPDATE if existing)

        $db = new SQLite3('gearhub.db');

        if ($this->id) {
            $db->exec("UPDATE items SET name = '$this->name', description = '$this->description', category = '$this->category', condition = '$this->condition', location = '$this->location', quantity = '$this->quantity', available = '$this->available', max_checkout = '$this->max_checkout', image_url = '$this->image_url', updated_at = '$this->updated_at' WHERE id = $this->id");
        } else {
            $db->exec("INSERT INTO items (name, description, category, condition, location, quantity, available, max_checkout, image_url, created_at, updated_at) VALUES ('$this->name', '$this->description', '$this->category', '$this->condition', '$this->location', '$this->quantity', '$this->available', '$this->max_checkout', '$this->image_url', '$this->created_at', '$this->updated_at')");
        }

        // return true or false

        $changes = $db->changes();
        $db->close();

        if ($changes > 0) {
           
            return true;
        } else {
            
            return false;
        }
    }
    
    public function delete()
    {
        // TODO: Delete the item from the database and return true or false on success or fail

        $db = new SQLite3('gearhub.db');
        $db->exec("DELETE FROM items WHERE id = $this->id");

        $changes = $db->changes();
        $db->close();

        // return true or false

        if ($changes > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // Getters and setters for all properties
    
    public function getId()
    {
        return $this->id;
    }

    public function getProp($prop) {
        $index = $prop;

        // if object has $index property, return it
        if (property_exists($this, $index)) {
            return $this->$index;
        } else {
            return null;
        }

    }
}