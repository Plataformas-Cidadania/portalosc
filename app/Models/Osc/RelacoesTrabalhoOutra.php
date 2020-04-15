<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_relacoes_trabalho_outra
 * @property int $id_osc
 * @property int $nr_trabalhadores
 * @property string $ft_trabalhadores
 * @property string $tx_tipo_relacao_trabalho
 * @property string $ft_tipo_relacao_trabalho
 * @property Osc.tbOsc $osc.tbOsc
 */
class RelacoesTrabalhoOutra extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_relacoes_trabalho_outra';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_relacoes_trabalho_outra';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'nr_trabalhadores', 'ft_trabalhadores', 'tx_tipo_relacao_trabalho', 'ft_tipo_relacao_trabalho'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
