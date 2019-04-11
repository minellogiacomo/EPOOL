<?php
try {
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $bulk = new MongoDB\Driver\BulkWrite();
    $doc = ['_id' => new MongoDB\BSON\ObjectID(), 'name' => 'Toyota'];
    $bulk->insert($doc);
    $mng->executeBulkWrite('testPHP.LOG', $bulk);
} catch (MongoDB\Driver\Exception\Exception $e) {
    //Errore
}
?>
