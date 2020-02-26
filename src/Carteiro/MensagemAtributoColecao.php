<?php

namespace Carteiro;

class MensagemAtributoColecao
{
    protected $mensagemAtributos = [];

    public function __construct($mensagemAtributos = [])
    {
        foreach ($mensagemAtributos as $mensagemAtributo) {
            if ($mensagemAtributo instanceof MensagemAtributo) {
                $this->mensagemAtributos[] = $mensagemAtributo;
            }
        }
    }

    public function add(MensagemAtributo $atributo)
    {
        $this->mensagemAtributos[] = $atributo;
    }

    public function toArray()
    {
        $atributos = [];

        foreach ($this->mensagemAtributos as $atributo) {
            $chave = $atributo->getChave();
            $atributos[$chave] = [
                'DataType' => $atributo->getTipoDado(),
                'StringValue' => (string) $atributo->getValor()
            ];
        }

        return $atributos;
    }
}
