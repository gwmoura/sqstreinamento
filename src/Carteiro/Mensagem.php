<?php

namespace Carteiro;

class Mensagem
{
    public $corpo;
    protected $idCorrelacao;
    protected $atributos;

    public function __construct($acao, $idCorrelacao = null)
    {
        $newIdCorrelacao = uniqid($acao.'-');
        $this->atributos = new MensagemAtributoColecao();
        $this->idCorrelacao = $newIdCorrelacao;

        if (!empty($idCorrelacao)) {
            $this->idCorrelacao = $idCorrelacao . '|' . $newIdCorrelacao;
        }

        $atributo = new MensagemAtributo('IDCorrelacao', $this->idCorrelacao, MensagemAtributo::TEXTO);
        $this->setAtributo($atributo);
    }

    public function setAtributo(MensagemAtributo $atributo)
    {
        $this->atributos->add($atributo);
    }

    public function getAtributos()
    {
        return $this->atributos;
    }

    public function __toString()
    {
        $msg = [
            'corpo' => $this->corpo,
            'atributo' => $this->getAtributos()->toArray()
        ];
        return '<Mensagem ' . json_encode($msg) . '>';
    }
}
