<?php

namespace Carteiro;

class MensagemAtributo
{
    protected $chave;
    protected $valor;
    protected $tipoDado;

    const NUMERO = 'Number';
    const TEXTO = 'String';
    const BOOLEANO = 'Boolean';

    public function __construct($chave = null, $valor = null, $tipoDado = null)
    {
        $this->chave = $chave;
        $this->valor = $valor;
        $this->tipoDado = $tipoDado;
    }

    public function setChave($chave)
    {
        $this->chave = $chave;
    }

    public function getChave()
    {
        return $this->chave;
    }

    public function setvalor($valor)
    {
        $this->valor = $valor;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setTipoDado($tipoDado)
    {
        $this->tipoDado = $tipoDado;
    }

    public function getTipoDado()
    {
        return $this->tipoDado;
    }
}
