<?php

include __DIR__.'/../bootstrap.php';

use Carteiro\FilaAws;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('devfila');

$log->pushHandler(new StreamHandler(__DIR__.'/logs/consumer.log', Logger::DEBUG));

$filaClient = new FilaAws('devfila');

$filaClient->consumir(function($msg) use ($filaClient, $log) {

    try {
        var_dump([
            $msg['MessageId'],
            $msg['Body']
        ]);

        $filaClient->apagarMensagem($msg['ReceiptHandle']);
    } catch(\Exception $e) {
        var_dump($e->getMessage());
        $idCorrelacao = $msg['MessageAttributes']['IDCorrelacao'];
        $msgErro = $idCorrelacao . ' Erro: ' . $e->getMessage();
        $msgErro .= $e->getTraceAsString();
        // error_log($msgErro);
        $log->error($msgErro);
    }

});
