<?php
namespace test;

class LanceViewTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    private $novoUsuarioPage;
    private $novoLeilaoPage;
    
    protected function setUp()
    {
        $this->setBrowserUrl('http://localhost:8080');
        $this->novoUsuarioPage = new NovoUsuarioPage($this);
        $this->novoLeilaoPage = new NovoLeilaoPage($this);
    }
    
    public function testNaoDeveDarLanceSemUsuario() {
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('Playstation 4', 2300.0, null)
        ->enviaForm();
        
        $this->byLinkText('exibir')->click();
        
        $campoLance = $this->byName('lance.valor');
        $campoLance->value(15);
        $campoLance->submit();
        
        sleep(5);
        
        $this->assertFalse(strpos($this->source(), '15.0') !== false);
    }
    
    public function testDeveCriarLance() {
        $nomeUsuario = 'Satiro';
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm($nomeUsuario, 'daniel@satiro.me')
        ->enviaForm();
        
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('Playstation 4', 2300.0, $nomeUsuario)
        ->enviaForm();
        
        $this->byLinkText('exibir')->click();
        
        $campoLance = $this->byName('lance.valor');
        $campoLance->value(15);
        $btnDarLance = $this->byId('btnDarLance');
        $btnDarLance->click();
        
        sleep(5);
        
        $this->assertTrue(strpos($this->source(), '15.0') !== false);
    }
    
    public function tearDown() {
        $this->url("/apenas-teste/limpa");
    }
}

