<?php

use PHPUnit\Framework\TestCase;
use Carteiro\Mensagem;

final class MensagemTest extends TestCase
{
    public function testContruindoMensagem()
    {
        $m = new Mensagem('test');
        $this->assertStringContainsString('test', $m->getAtributos()->obterPorChave('IDCorrelacao')->getValor());
    }

    public function testContarNumeroDeAtributosNaMensagem()
    {
        $m = new Mensagem('test');
        $this->assertCount(1, $m->getAtributos());
    }

}
