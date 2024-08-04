<?php

declare(strict_types=1);

require_once __DIR__ . "../../connect/connect.php";

class Fill extends Conexao
{
    private array $retorno;
    private string $nom;
    private array $id_;
    private PDOStatement $banco;
    private array $atual;
    private string $nome_estado, $nome, $cidade, $matricula, $mv_3, $mv_6, $mv_12, $mc_3, $mc_6, $mc_9, $mc_12;
    private array $agora;
    private array $agoradet;
    public string $fim;
    private array $es;
    private array $at, $id_esc, $esc_esc;

    function __construct()
    {
        parent::__construct();
    }

    private function mostre(string $retorne): void
    {
        $this->banco = $this->conectar()->prepare(
                "SELECT id, nome_estado, escolas FROM $retorne "
            );
        $this->banco->execute();
        $this->atual = $this->banco->fetchAll(PDO::FETCH_ASSOC);
    }

    private function mostredet(string $retorne, string $volt): void
    {
        $this->banco = $this->conectar()->prepare(
                "SELECT nome_estado, escolas, cidade, matricula, mv_3, mv_6, mv_12, mc_3, mc_6, mc_9, mc_12 FROM $retorne WHERE id=:id "
            );

        $this->banco->bindParam(":id", $volt, PDO::PARAM_STR);
        $this->banco->execute();
        $this->atual = $this->banco->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getmostre(string $retorne): void
    {
        $this->mostre($retorne);
        $this->retorno = array();
        $this->id_ = array();
        foreach ($this->atual as $resultado) {
            $this->nom = $resultado['nome_estado'];
            $this->id_[] = $resultado["id"];
            $this->retorno[] = $resultado["escolas"];
            //echo '<div class="ee" style="color: blue"><p>' . $resultado['escolas'] . "</p><div>";
        }
        array_push($this->retorno, $this->nom);

        $this->agora = array(
            "retorno" => $this->retorno,
            "id" => $this->id_
        );
        echo json_encode($this->agora);
    }

    public function getdetalhes(string $retorne, string $volt): void
    {
        $this->mostredet($retorne, $volt);
        foreach ($this->atual as $resultado) {
            $this->nome_estado = $resultado['nome_estado'];
            $this->nome = $resultado['escolas'];
            $this->cidade = $resultado['cidade'];
            $this->matricula = $resultado['matricula'];
            $this->mv_3 = $resultado['mv_3'];
            $this->mv_6 = $resultado['mv_6'];
            $this->mv_12 = $resultado['mv_12'];
            $this->mc_3 = $resultado['mc_3'];
            $this->mc_6 = $resultado['mc_6'];
            $this->mc_9 = $resultado['mc_9'];
            $this->mc_12 = $resultado['mc_12'];
            //echo '<div class="ee" style="color: blue"><p>' . $resultado['escolas'] . "</p><div>";
        }

        $this->agoradet = array(
            "nome_estado" => $this->nome_estado,
            "nome" => $this->nome,
            "cidade" => $this->cidade,
            "matricula" => $this->matricula,
            "mv_3" => $this->mv_3,
            "mv_6" => $this->mv_6,
            "mv_12" => $this->mv_12,
            "mc_3" => $this->mc_3,
            "mc_6" => $this->mc_6,
            "mc_9" => $this->mc_9,
            "mc_12" => $this->mc_12
        );
        echo json_encode($this->agoradet);
    }

    private function escola($retorne):void
    {
        $this->banco = $this->conectar()->prepare(
                "SELECT escolas, id FROM $retorne "
            );
        $this->banco->execute();
        $this->es = $this->banco->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getescola($retorne):void
    {
        $this->escola($retorne);
        $this->id_esc = array();
        $this->esc_esc = array();
        foreach ($this->es as $value) {
            $this->id_esc[] = $value['escolas'];
            $this->esc_esc[] = $value['id'];
        }
        $this->at = array(
            "escolas" => $this->id_esc,
            "id" => $this->esc_esc
        );
        echo json_encode($this->at);
    }

    private function alterar(string $retorne, string $tabela, string $sch, string $val): void
    {
        $atualize = "UPDATE `$retorne` SET `$sch` = :sc WHERE id = :id";
        $this->banco = $this->conectar()->prepare($atualize);
        $this->banco->bindParam(':sc', $val, PDO::PARAM_STR);
        $this->banco->bindParam(':id', $tabela, PDO::PARAM_STR);
        $this->banco->execute();
    }

    public function get_alterar(string $retorne, string $tabela, string $sch, string $val): void
    {
        $this->alterar($retorne, $tabela, $sch, $val);
    }
}

/*
require_once __DIR__ . "../../connect/connect.php";

class Fill extends Conexao
{
    private $retorno;
    private $nom;
    private $id_;
    private $banco;
    private $atual;
    private $agora;
    private $nome, $cidade, $matricula, $mv_3, $mv_6, $mv_9, $mv_12, $mc_3, $mc_6, $mc_9, $mc_12;
    private $agoradet;
    public $fim;

    function __construct()
    {
        parent::__construct();
    }
    
    private function mostre($retorne)
    {
        $this->banco = $this->conectar()->prepare
        (
            "SELECT id, nome_estado, escolas FROM $retorne "
        );
        $this->banco->execute();
        $this->atual = $this->banco->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function mostredet($retorne)
    {
        $this->banco = $this->conectar()->prepare
        (
            "SELECT nome, cidade, matricula, mv_3, mv_6, mv_9, mv_12, mc_3, mc_6, mc_9, mc_12 FROM $retorne "
        );
        $this->banco->execute();
        $this->atual = $this->banco->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getmostre($retorne)
    {
        $this->mostre($retorne);
        $this->retorno = array();
        $this->id_ = array();
        foreach ($this->atual as $resultado) {
            $this->nom = $resultado['nome_estado'];
            $this->id_[] = $resultado["id"];
            $this->retorno[] = $resultado["escolas"];
            //echo '<div class="ee" style="color: blue"><p>' . $resultado['escolas'] . "</p><div>";
        }
        array_push($this->retorno, $this->nom);

        $this->agora = array(
            "retorno" => $this->retorno,
            "id" => $this->id_
        );
        echo json_encode($this->agora);
    }

    public function getdetalhes($retorne)
    {
        $this->mostredet($retorne);
        foreach ($this->atual as $resultado) {
            $this->nome = $resultado['nome'];
            $this->cidade = $resultado['cidade'];
            $this->matricula = $resultado['matricula'];
            $this->mv_3 = $resultado['mv_3'];
            $this->mv_6 = $resultado['mv_6'];
            $this->mv_9 = $resultado['mv_9'];
            $this->mv_12 = $resultado['mv_12'];
            $this->mc_3 = $resultado['mc_3'];
            $this->mc_6 = $resultado['mc_6'];
            $this->mc_9 = $resultado['mc_9'];
            $this->mc_12 = $resultado['mc_12'];
            //echo '<div class="ee" style="color: blue"><p>' . $resultado['escolas'] . "</p><div>";
        }

        $this->agoradet = array(
            "nome" => $this->nome,
            "cidade" => $this->cidade,
            "matricula" => $this->matricula,
            "mv_3" => $this->mv_3,
            "mv_6" => $this->mv_6,
            "mv_9" => $this->mv_9,
            "mv_12" => $this->mv_12,
            "mc_3" => $this->mc_3,
            "mc_6" => $this->mc_6,
            "mc_9" => $this->mc_9,
            "mc_12" => $this->mc_12
        );
        echo json_encode($this->agoradet);
    }
    
    private function alterar($retorne, $sch, $val)
    {
        $atualize = "UPDATE `$retorne` SET `$sch` = :sc ";
        $this->banco = $this->conectar()->prepare($atualize);
        $this->banco->bindParam(':sc', $val, PDO::PARAM_STR);
        $this->tru();
    }

    public function get_alterar($retorne, $sch, $val)
    {
        $this->alterar($retorne, $sch, $val);
    }

    public function tru()
    {
        if (!$this->banco->execute())
        {
        echo "Erro ao executar a declaração preparada.";
        $errorInfo = $this->banco->errorInfo();
        echo "Código de erro: " . $errorInfo[0] . "<br>";
        echo "Código do driver: " . $errorInfo[1] . "<br>";
        echo "Mensagem de erro: " . $errorInfo[2] . "<br>";
        exit;
    }else{
        $this->fim = "salvo";
    }
}

}
    /*
    
    private function mostre($retorne)
    {
        $this->banco = $this->conectar()->prepare
        (
            "SELECT escolas FROM $retorne "
        );
        $this->banco->execute();
        $this->atual = $this->banco->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getmostre($retorne)
    {
        $this->mostre($retorne);
        $this->retorno = array();
        foreach ($this->atual as $resultado) {
            $this->retorno[] = $resultado["escolas"];
            //echo '<div class="ee" style="color: blue"><p>' . $resultado['escolas'] . "</p><div>";
        }
        echo json_encode($this->retorno);
    }

}

*/