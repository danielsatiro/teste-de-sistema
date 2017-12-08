<?php
namespace test;

class NovoUsuarioPage
{
    private $page;
    
    public function __construct(\PHPUnit_Extensions_Selenium2TestCase $page) {
        $this->page = $page;
    }
    
    public function acessa() {
        $this->page->url("/usuarios");
        return $this;
    }
    
    public function acessaNew() {
        $this->page->url("/usuarios/new");
        return $this;
    }
    
    public function populaNovoForm($nome, $email)
    {
        $campoNome = $this->page->byName('usuario.nome');
        $campoNome->value($nome);
        $campoEmail = $this->page->byName('usuario.email');
        $campoEmail->value($email);
        return $this;
    }
    
    public function enviaForm() {
        $btnSalvar = $this->page->byId('btnSalvar');
        $btnSalvar->click();
        return $this;
    }
    
    public function existeValue($value)
    {
        return strpos($this->page->source(), $value) !== false;
    }
}

