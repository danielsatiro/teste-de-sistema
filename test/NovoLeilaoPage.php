<?php
namespace test;

class NovoLeilaoPage
{
    private $page;
    
    public function __construct(\PHPUnit_Extensions_Selenium2TestCase $page) {
        $this->page = $page;
    }
    
    public function acessa() {
        $this->page->url("/leiloes");
        return $this;
    }
    
    public function acessaNew() {
        $this->page->url("/leiloes/new");
        return $this;
    }
    
    public function populaNovoForm($nome, $valorInicial, $usuario = null, $usado = false)
    {
        $campoNome = $this->page->byName('leilao.nome');
        $campoNome->value($nome);
        $campoValorInicial = $this->page->byName('leilao.valorInicial');
        $campoValorInicial->value($valorInicial);
        
        if (!is_null($usuario)) {
            $selectUsuario = $this->page->select($this->page->byName('leilao.usuario.id'));
            $selectUsuario->selectOptionByLabel($usuario);
        }        
        
        if ($usado === true) {
            $campoUsado = $this->page->byName('leilao.usado');
            $campoUsado->click();
        }
        
        return $this;
    }
    
    public function enviaForm() {
        $btnSalvar = $this->page->byTag('button');
        $btnSalvar->click();
        return $this;
    }
    
    public function existeValue($value)
    {
        return strpos($this->page->source(), $value) !== false;
    }
}

