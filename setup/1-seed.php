<?php

$admin_email = 'joel@dudasalisbury.com';



// Connect to the database
$db = new SQLite3('../gearhub.db');

// Define the items to seed
$items = [
    [
        'name' => 'Full Suspension Mountain Bike',
        'description' => 'A full suspension mountain bike with 27.5 inch wheels and a carbon fiber frame.',
        'category' => 'Mountain Biking',
        'condition' => 'New',
        'location' => 'San Francisco',
        'quantity' => 5,
        'available' => 5,
        'max_checkout' => 1,
        'image_url' => 'https://example.com/full-suspension-mtb.jpg',
    ],
    [
        'name' => 'Hardtail Mountain Bike',
        'description' => 'A hardtail mountain bike with 29 inch wheels and a aluminum frame.',
        'category' => 'Mountain Biking',
        'condition' => 'Used',
        'location' => 'Los Angeles',
        'quantity' => 3,
        'available' => 2,
        'max_checkout' => 2,
        'image_url' => 'https://example.com/hardtail-mtb.jpg',
    ],
    [
        'name' => 'Downhill Mountain Bike',
        'description' => 'A downhill mountain bike with 27.5 inch wheels and a steel frame.',
        'category' => 'Mountain Biking',
        'condition' => 'Used',
        'location' => 'New York',
        'quantity' => 2,
        'available' => 1,
        'max_checkout' => 1,
        'image_url' => 'https://example.com/downhill-mtb.jpg',
    ],
];

// Loop through the items and insert them into the database
foreach ($items as $item) {
    $query = "INSERT INTO items (name, description, category, condition, location, quantity, available, max_checkout, image_url)
              VALUES (:name, :description, :category, :condition, :location, :quantity, :available, :max_checkout, :image_url)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $item['name'], SQLITE3_TEXT);
    $statement->bindValue(':description', $item['description'], SQLITE3_TEXT);
    $statement->bindValue(':category', $item['category'], SQLITE3_TEXT);
    $statement->bindValue(':condition', $item['condition'], SQLITE3_TEXT);
    $statement->bindValue(':location', $item['location'], SQLITE3_TEXT);
    $statement->bindValue(':quantity', $item['quantity'], SQLITE3_INTEGER);
    $statement->bindValue(':available', $item['available'], SQLITE3_INTEGER);
    $statement->bindValue(':max_checkout', $item['max_checkout'], SQLITE3_INTEGER);
    $statement->bindValue(':image_url', $item['image_url'], SQLITE3_TEXT);
    $statement->execute();
}


$users = [
    [
        'name' => 'John Doe',
        'email' => 'test@test.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'type' => 'admin',
    ],

    [
        'name' => 'Jane Doe',
        'email' => 'test2@test.com',
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'type' => 'member',
    ],

    [
        'name' => 'Admin',
        'email' => $admin_email,
        'password' => password_hash('password', PASSWORD_DEFAULT),
        'type' => 'admin'
    ]
];

foreach ($users as $user) {
    $query = "INSERT INTO users (name, email, password, type)
              VALUES (:name, :email, :password, :type)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $user['name'], SQLITE3_TEXT);
    $statement->bindValue(':email', $user['email'], SQLITE3_TEXT);
    $statement->bindValue(':password', $user['password'], SQLITE3_TEXT);
    $statement->bindValue(':type', $user['type'], SQLITE3_TEXT);
    $statement->execute();
}

// Close the database connection
$db->close();

echo 'Items imported successfully!';
