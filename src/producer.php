<?php

require __DIR__.'/../bootstrap.php';

use Carteiro\FilaAws;
use Carteiro\Mensagem;
use Carteiro\MensagemAtributo;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$filaClient = new FilaAws('devfila');
$log = new Logger('devfila');

$log->pushHandler(new StreamHandler(__DIR__.'/../logs/producer.log', Logger::DEBUG));

$mensagem = new Mensagem('ACAO');
$atr = new MensagemAtributo('Data', date('Y-m-d'), MensagemAtributo::TEXTO);
$mensagem->setAtributo($atr);
$atr = new MensagemAtributo('Autor', 'George Moura', MensagemAtributo::TEXTO);
$mensagem->setAtributo($atr);
$atr = new MensagemAtributo('Time', time(), MensagemAtributo::NUMERO);
$mensagem->setAtributo($atr);

$pedido = [
    'id' => uniqid(),
    'valor' => rand(0, 100),
    'data_compra' => date('Y-m-d H:i:s')
];

$mensagem->corpo = json_encode($pedido);

$log->info('Enviando mensagem: ' . $mensagem);

try {
    $resultado = $filaClient->enviarMensagem($mensagem);
    $msg = 'Mensagem '. $resultado['MessageId'] .' enviada!'.PHP_EOL;
    echo $msg;
    $log->info($msg);
} catch (\Exception $e) {
    echo $e->getMessage();
    $log->error($e->getMessage(), [$e]);
}

