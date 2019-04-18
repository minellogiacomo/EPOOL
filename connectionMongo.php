<?php
/**
 * @param $document
 */
function mongoLog($document)
{
    if (extension_loaded("mongodb")) {
        try {
            $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
            $bulk = new MongoDB\Driver\BulkWrite();
            $document = ['_id' => new MongoDB\BSON\ObjectID(), $document];
            $bulk->insert($document);
            $mng->executeBulkWrite('testPHP.LOG', $bulk);
        } catch (MongoDB\Driver\Exception\Exception $e) {
            //Errore
        }
    }
}

?>
