<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Token extends Model
{


    protected $table = 'admin';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['token']; 


    public $token;
    public $sucesso;
    public $erro;
    public $atual;
    public $nulo;

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
    
    public function getToken()
    {
        return $this->select('token')->first();
    }

    public function updateToken(string $newToken): bool
{
    return $this->update(1,['token' => $newToken]);
}

}