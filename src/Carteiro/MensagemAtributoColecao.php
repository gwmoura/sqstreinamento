<?php

namespace Carteiro;

use Iterator;
use Countable;

class MensagemAtributoColecao implements Iterator, Countable
{
    private $posicao = 0;
    protected $mensagemAtributos = [];

    public function __construct($mensagemAtributos = [])
    {
        $this->posicao = 0;
        foreach ($mensagemAtributos as $mensagemAtributo) {
            if ($mensagemAtributo instanceof MensagemAtributo) {
                $this->mensagemAtributos[] = $mensagemAtributo;
            }
        }
    }

    function rewind()
    {
        $this->posicao = 0;
    }

    function current()
    {
        return $this->mensagemAtributos[$this->posicao];
    }

    function key()
    {
        return $this->posicao;
    }

    function next()
    {
        ++$this->posicao;
    }

    function valid()
    {
        return isset($this->mensagemAtributos[$this->posicao]);
    }

    function count()
    {
        return count($this->mensagemAtributos);
    }

    public function add(MensagemAtributo $atributo)
    {
        $this->mensagemAtributos[] = $atributo;
    }

    public function obterPorChave($chave) : MensagemAtributo
    {
        foreach ($this->mensagemAtributos as $atributo) {
            return $atributo->getChave() == $chave ? $atributo : null;
        }
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
