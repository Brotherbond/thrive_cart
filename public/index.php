<?php

$data = [
    'host' => $_SERVER['HTTP_HOST'],
    'timestamp' => time(),
];

echo json_encode($data, JSON_PRETTY_PRINT);
