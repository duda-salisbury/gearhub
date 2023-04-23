<?php
/** empty and drop all tables */
$db = new SQLite3('../gearhub.db');

$tables = array('items', 'users', 'checkouts');

foreach ($tables as $table) {
    /** delete and empty each table, echoing success or failure */

    $result = $db->exec("DELETE FROM $table");
    if ($result) {
        echo "Deleted all rows from $table table" . PHP_EOL;
    } else {
        echo "Failed to delete all rows from $table table" . PHP_EOL;
    }

    $result = $db->exec("DROP TABLE $table");
    if ($result) {
        echo "Dropped $table table" . PHP_EOL;
    } else {
        echo "Failed to drop $table table" . PHP_EOL;
    }
}

/** Link to migrations file to start over */
echo "To start over, run: php setup/0-migrations.php" . PHP_EOL;

// close the database connection
$db->close();

