<?php
echo extension_loaded("mongodb") ? "loaded\n" : "not loaded\n";
try {
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    print_r($mng);
    $bulk = new MongoDB\Driver\BulkWrite();
    $doc = ['_id' => new MongoDB\BSON\ObjectID(), 'name' => 'Toyota'];
    $bulk->insert($doc);
    $mng->executeBulkWrite('testPHP.LOG', $bulk);
} catch (MongoDB\Driver\Exception\Exception $e) {
    //Errore
}
?>
