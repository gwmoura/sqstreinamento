<?php

require './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('SQS_URL_BASE', getenv('SQS_URL_BASE'));
define('PERFIL_CREDENCIAIS_AWS', getenv('PERFIL_CREDENCIAIS_AWS'));
define('REGIAO_AWS', getenv('REGIAO_AWS'));
