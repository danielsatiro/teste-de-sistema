<?php
namespace test;

class UsuarioViewTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    private $novoUsuarioPage;
    
    protected function setUp()
    {
        $this->setBrowserUrl('http://localhost:8080');
        $this->novoUsuarioPage = new NovoUsuarioPage($this);
    }
    
    public function testDeveCriarNovoUsuario() {
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm('Satiro', 'daniel@satiro.me')
        ->enviaForm();
        
        $this->assertTrue($this->novoUsuarioPage->existeValue('Satiro'));
        $this->assertTrue($this->novoUsuarioPage->existeValue('daniel@satiro.me'));
        
        sleep(2);
    }
    
    public function testDeveRetornarErroSemNome() {
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm('', 'daniel@satiro.me')
        ->enviaForm();
        
        $this->assertTrue($this->novoUsuarioPage->existeValue('Nome obrigatorio!'));
    }
    
    public function testDeveRetornarErroSemEmail() {
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm('Satiro', '')
        ->enviaForm();
        
        $this->assertTrue($this->novoUsuarioPage->existeValue('E-mail obrigatorio!'));
    }
    
    public function testDeveRetornarErroSemNomeEEmail() {
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm('', '')
        ->enviaForm();
        
        $this->assertTrue($this->novoUsuarioPage->existeValue('Nome obrigatorio!'));
        $this->assertTrue($this->novoUsuarioPage->existeValue('E-mail obrigatorio!'));
    }
    
    public function testDeveExibirInfos() {
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm('Satiro', 'daniel@satiro.me')
        ->enviaForm();
        
        $this->byLinkText('exibir')->click();
        
        $this->assertTrue($this->novoUsuarioPage->existeValue('Satiro'));
        $this->assertTrue($this->novoUsuarioPage->existeValue('daniel@satiro.me'));
    }
    
    public function testDeveEditar() {
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm('Satiro', 'daniel@satiro.me')
        ->enviaForm();
        
        $this->byLinkText('editar')->click();
        
        $this->novoUsuarioPage->populaNovoForm('Marco', 'marco@quinho.me')
        ->enviaForm();
        
        $this->assertTrue($this->novoUsuarioPage->existeValue('Marco'));
        $this->assertTrue($this->novoUsuarioPage->existeValue('marco@quinho.me'));
    }
    
    public function testNaoDeveExcluirQdoCancelado() {
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm('Satiro', 'daniel@satiro.me')
        ->enviaForm();
        
        $btnExcluir = $this->byTag('button');
        $btnExcluir->click();
        $this->dismissAlert();
        
        $this->assertTrue($this->novoUsuarioPage->existeValue('Satiro'));
        $this->assertTrue($this->novoUsuarioPage->existeValue('daniel@satiro.me'));
    }
    
    public function testDeveExcluirQdoConfirmado() {
        $this->novoUsuarioPage->acessaNew()
        ->populaNovoForm('Satiro', 'daniel@satiro.me')
        ->enviaForm();
        
        $btnExcluir = $this->byTag('button');
        $btnExcluir->click();
        $this->acceptAlert();
        
        $this->novoUsuarioPage->acessa();
        
        $this->assertFalse($this->novoUsuarioPage->existeValue('Satiro'));
        $this->assertFalse($this->novoUsuarioPage->existeValue('daniel@satiro.me'));
    } 
    
    public function tearDown() {
        $this->url("/apenas-teste/limpa");
    }
}

