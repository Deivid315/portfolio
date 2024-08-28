<?php

namespace App\Models\Admin\Salvar;

use CodeIgniter\Model;

class Salvar extends Model
{
    
    public function setAlterar(string $estado, string $escola, string $campo, string $valor): bool
    {
        $builder = $this->db->table($estado);
        $builder->set($campo, $valor);
        $builder->where('id', $escola);
        return $builder->update();
    }
    
}