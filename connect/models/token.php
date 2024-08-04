<?php

require_once __DIR__ . "../../connect/connect.php";

class Token extends Conexao
{
    public $token;
    private $banco;
    public $sucesso;
    public $erro;
    public $atual;
    private $mostre;
    public $nulo;

    function __construct()
    {
        parent::__construct();
        $this->mostre();
    }

    public function confirma(): void
    {
        if (($this->token !== "") && (!preg_match("/[^A-Za-z0-9]/", $this->token)))
        {
            
            if(strlen($this->token) > 100)
            {
                $this->altera();
                $this->atual();
            }else
            {
            $this->atual();
            $this->nulo = true; 
            }
        } else {
            $this->atual();
            $this->nulo = true;
        }
    }

    private function altera()
    {
        $this->banco = $this->conectar()->prepare
        (
            "UPDATE admin SET token = :token"
        );
        $this->banco->bindParam(":token", $this->token, PDO::PARAM_STR);
        if($this->banco->execute()){
            $this->sucesso = true;
        }else{
            $this->erro = true;
        }
    }
    public function atual()
    {
        $this->banco = $this->conectar()->prepare
        (
            "SELECT token FROM admin "
        );
        $this->banco->execute();
        $this->atual = $this->banco->fetch(PDO::FETCH_ASSOC);
        $_SESSION['token'] = $this->atual['token'];
    }
    
    private function mostre()
    {
        $this->banco = $this->conectar()->prepare
        (
            "SELECT token FROM admin "
        );
        $this->banco->execute();
        $this->atual = $this->banco->fetch(PDO::FETCH_ASSOC);
        $this->mostre = $this->atual['token'];
    }

    public function getmostre()
    {
        return $this->mostre;
    }

}