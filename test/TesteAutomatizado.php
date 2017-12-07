<?php
namespace test;

class TesteAutomatizado extends \PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowserUrl('http://google.com');
    }
    
    public function testTitle()
    {
        $this->url("/");
        $campoDeTexto = $this->byName('q');
        $campoDeTexto->value('Caelum');
        $campoDeTexto->submit();
        sleep(2);
    }
}

