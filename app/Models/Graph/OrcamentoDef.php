<?php

namespace App\Models\Graph;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_orcamento_def
 * @property float $nr_orcamento_cnpj
 * @property int $nr_orcamento_ano
 * @property float $nr_vl_empenhado_def
 */
class OrcamentoDef extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'graph.tb_orcamento_def';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_orcamento_def';

    /**
     * @var array
     */
    protected $fillable = ['nr_orcamento_cnpj', 'nr_orcamento_ano', 'nr_vl_empenhado_def'];

}
