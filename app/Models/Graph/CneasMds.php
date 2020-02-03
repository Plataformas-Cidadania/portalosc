<?php

namespace App\Models\Graph;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_cneas_mds
 * @property string $cnpj
 * @property string $ibge
 * @property string $uf
 * @property string $municipio
 * @property string $nome_fantasia
 * @property string $razao_social
 * @property string $logradouro
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cep
 * @property string $email
 * @property string $telefone
 * @property string $bloco_servico
 * @property string $atividade
 */
class CneasMds extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'graph.tb_cneas_mds';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cneas_mds';

    /**
     * @var array
     */
    protected $fillable = ['cnpj', 'ibge', 'uf', 'municipio', 'nome_fantasia', 'razao_social', 'logradouro', 'numero', 'complemento', 'bairro', 'cep', 'email', 'telefone', 'bloco_servico', 'atividade'];

}
