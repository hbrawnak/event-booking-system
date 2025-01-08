<?php

$json = file_get_contents(__DIR__ . '/data/data.json');
$data = json_decode($json, true);
print_r($data);