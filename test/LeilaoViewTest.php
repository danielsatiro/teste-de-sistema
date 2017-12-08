<?php
namespace test;

class LeilaoViewTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    private $novoUsuarioPage;
    private $novoLeilaoPage;
    
    protected function setUp()
    {
        $this->setBrowserUrl('http://localhost:8080');
        $this->novoUsuarioPage = new NovoUsuarioPage($this);
        $this->novoLeilaoPage = new NovoLeilaoPage($this);
    }
    
    public function testDeveCriarNovoLeilaoComUsuario() {
        $nomeUsuario = 'Satiro';
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm($nomeUsuario, 'daniel@satiro.me')
        ->enviaForm();
        
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('Playstation 4', 2300.0, $nomeUsuario)
        ->enviaForm();
        
        $this->assertTrue($this->novoLeilaoPage->existeValue('Playstation 4'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('2300.0'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('Satiro'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('Não'));
    }
    
    public function testDeveCriarNovoLeilaoSemUsuario() {
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('Playstation 4', 2300.0, null)
        ->enviaForm();
        
        $this->assertTrue($this->novoLeilaoPage->existeValue('Playstation 4'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('2300.0'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('Não'));
    }
    
    public function testDeveRetornarErroSemNome() {
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('', 2300.0, null)
        ->enviaForm();
        
        $this->assertTrue($this->novoLeilaoPage->existeValue('Nome obrigatorio!'));
    }
    
    public function testDeveRetornarErroSemValor() {
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('Playstation 4', '', null)
        ->enviaForm();
        
        $this->assertTrue($this->novoLeilaoPage->existeValue('Valor inicial deve ser maior que zero!'));
    }
    
    public function testDeveRetornarErroComValorMenorOuIgualZero() {
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('Playstation 4', 0, null)
        ->enviaForm();
        
        $this->assertTrue($this->novoLeilaoPage->existeValue('Valor inicial deve ser maior que zero!'));
    }
    
    public function testDeveExibirInfos() {
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('Playstation 4', 2300.0, null)
        ->enviaForm();
        
        $this->byLinkText('exibir')->click();
        
        $this->assertTrue($this->novoLeilaoPage->existeValue('Playstation 4'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('2300.0'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('Não'));
    }
    
    public function testDeveCriarNovoLeilaoComProdutoUsado() {
        $this->novoLeilaoPage->acessaNew()
        ->populaNovoForm('Playstation 4', 2300.0, null, true)
        ->enviaForm();
        
        $this->assertTrue($this->novoLeilaoPage->existeValue('Playstation 4'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('2300.0'));
        $this->assertTrue($this->novoLeilaoPage->existeValue('Sim'));
    }
    
    public function tearDown() {
        $this->url("/apenas-teste/limpa");
    }
}

