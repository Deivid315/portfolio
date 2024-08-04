<?php

session_start();
ob_start();
require_once __DIR__ . "../../connect/connect.php";

class Valida extends Conexao
{
    public $login_usuario;
    public $senha_usuario;
    public $process;
    private $bda;
    private $dados;
    private $row;
    private $busca;
    private $token;

    function __construct()
    {
        parent::__construct();
        $this->dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    }

    public function confirma(): void
    {
        if (!empty($this->login_usuario) && !empty($this->senha_usuario))
        {
           $this->SelecionaBDA();
        } else {
            header("Location:../views/admin/index.php");
            // Campos vazios
        }
    }

    private function SelecionaBDA(): void
    {
        
        $this->bda = $this->conectar()->prepare("SELECT id_admin,
        email_admin,
        senha_admin,
        nome_admin FROM admin WHERE
        email_admin =:email_admin LIMIT 1");
        $this->bda->bindParam(":email_admin", $this->dados['login_usuario'], PDO::PARAM_STR);
        $this->bda->execute();

        if (($this->bda) and ($this->bda->rowCount() != 0))
        {
            $this->row = $this->bda->fetch(PDO::FETCH_ASSOC);

            if (password_verify($this->dados['senha_usuario'],
             $this->row['senha_admin']))
             {

                $_SESSION['id_admin'] = $this->row['id_admin'];
                $_SESSION['nome_admin'] = $this->row['nome_admin'];

                $this->busca = $this->conectar()->prepare("SELECT token FROM admin");
                $this->busca->execute();
                $this->token = $this->busca->fetch(PDO::FETCH_ASSOC);
                $_SESSION['token'] = $this->token['token'];
                header('location: ../controllers/roteinicial.php');
            } else {
                $_SESSION['senha'] = true;
                header('location:../views/admin/index.php');
                //senha não existe no bda
            }
        } else {
            $_SESSION['login'] = true;
            header('location:../views/admin/index.php');
            //email não existe no bda
        }
    }
}
