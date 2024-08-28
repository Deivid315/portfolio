<?php

namespace App\Models\Admin\Buscas;

use CodeIgniter\Model;

class Buscas extends Model
{
    private function escola(string $retorne): array
    {
        return $this->db->table($retorne)->select('escolas, id')->get()->getResultArray();
    }

    public function getEscola(string $retorne): array
    {

        $retorno = $this->escola($retorne);
        $id_esc = array();
        $esc_esc = array();

        foreach ($retorno as $value) {
            $id_esc[] = $value['escolas'];
            $esc_esc[] = $value['id'];
        }
        $at = array(
            "escolas" => $id_esc,
            "id" => $esc_esc
        );
        return $at;
    }

    private function mostreDet(string $tabela, string $id): array
    {
        return $this->db->table($tabela)
            ->select('nome_estado, escolas, cidade, matricula, mv_3, mv_6, mv_9, mv_12, mc_3, mc_6, mc_9, mc_12')
            ->where('id', $id)
            ->get()
            ->getResultArray();
    }

    public function getDetalhes(string $tabela, string $id): array
    {
        $atual = $this->mostreDet($tabela, $id);

        foreach ($atual as $resultado) {
            $nome_estado = $resultado['nome_estado'];
            $nome = $resultado['escolas'];
            $cidade = $resultado['cidade'];
            $matricula = $resultado['matricula'];
            $mv_3 = $resultado['mv_3'];
            $mv_6 = $resultado['mv_6'];
            $mv_9 = $resultado['mv_9'];
            $mv_12 = $resultado['mv_12'];
            $mc_3 = $resultado['mc_3'];
            $mc_6 = $resultado['mc_6'];
            $mc_9 = $resultado['mc_9'];
            $mc_12 = $resultado['mc_12'];
        }

        $ret = array(
            "nome_estado" => $nome_estado,
            "nome" => $nome,
            "cidade" => $cidade,
            "matricula" => $matricula,
            "mv_3" => $mv_3,
            "mv_6" => $mv_6,
            "mv_9" => $mv_9,
            "mv_12" => $mv_12,
            "mc_3" => $mc_3,
            "mc_6" => $mc_6,
            "mc_9" => $mc_9,
            "mc_12" => $mc_12
        );
        return $ret;
    }
}
