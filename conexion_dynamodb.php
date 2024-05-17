<?php
require __DIR__ . '/vendor/autoload.php';


use Aws\DynamoDb\DynamoDbClient;

// Configura las credenciales y la región de AWS
$credentials = [
    'key'    => 'AKIAU6GDWIJJC3K4B75W',
    'secret' => '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',
];

// Reemplaza 'us-east-1' con la región de tu tabla DynamoDB
$region = 'us-east-2';

// Crea un cliente de DynamoDB
$client = new DynamoDbClient([
    'version'     => 'latest',
    'region'      => $region,
    'credentials' => $credentials,
]);

// Ahora puedes utilizar $client para realizar operaciones en DynamoDB

?>
