<?php

namespace Carteiro;

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

class FilaAws
{
    private $client;
    private $urlBaseFila = SQS_URL_BASE;
    private $urlFila;
    protected $nomeFila;

    public function __construct($nomeFila)
    {
        $this->nomeFila = $nomeFila;
        $this->urlFila = $this->urlBaseFila . $this->nomeFila;
        $this->client = new SqsClient([
            'profile' => PERFIL_CREDENCIAIS_AWS,
            'region' => REGIAO_AWS,
            'version' => '2012-11-05'
        ]);
    }

    public function listarFilas(): array
    {
        $filas = [];
        try {
            $result = $this->client->listQueues();
            $queues = $result->get('QueueUrls');
            return !empty($queues) ? $queues : [];
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }

        return $filas;
    }

    public function enviarMensagem(Mensagem $mensagem)
    {
        $params = [
            'DelaySeconds' => 10,
            'MessageAttributes' => $mensagem->getAtributos()->toArray(),
            'MessageBody' => $mensagem->corpo,
            'QueueUrl' => $this->urlFila
        ];

        try {
            $result = $this->client->sendMessage($params);
            return $result;
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }

    public function listarMensagens()
    {
        $menssagens = [];

        try {
            $result = $this->client->receiveMessage(array(
                'AttributeNames' => ['SentTimestamp'],
                'MaxNumberOfMessages' => 1,
                'MessageAttributeNames' => ['All'],
                'QueueUrl' => $this->urlFila, // REQUIRED
                'WaitTimeSeconds' => 20,
            ));

            if (!empty($result->get('Messages'))) {
                $menssagens = $result->get('Messages');
            }
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }

        return $menssagens;
    }

    public function apagarMensagem($id)
    {
        try {
            $result = $this->client->deleteMessage([
                'QueueUrl' => $this->urlFila, // REQUIRED
                'ReceiptHandle' => $id // REQUIRED
            ]);
            return $result;
        } catch(AwsException $e) {
            error_log($e->getMessage());
        }
    }

    public function consumir($callback)
    {
        echo "Consumindo...\n";
        $menssagens = $this->listarMensagens();

        if (!empty($menssagens)) {
            foreach($menssagens as $mensagem) {
                $callback($mensagem);
            }
        } else {
            echo "Nenhuma mensagem na fila \n";
        }

        $this->consumir($callback);
    }
}

