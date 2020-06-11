<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_osc
 * @property int $nr_trabalhadores_vinculo
 * @property string $ft_trabalhadores_vinculo
 * @property int $nr_trabalhadores_deficiencia
 * @property string $ft_trabalhadores_deficiencia
 * @property int $nr_trabalhadores_voluntarios
 * @property string $ft_trabalhadores_voluntarios
 * @property Osc.tbOsc $osc.tbOsc
 */
class RelacoesTrabalho extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_relacoes_trabalho';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_osc';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['nr_trabalhadores_vinculo', 'ft_trabalhadores_vinculo', 'nr_trabalhadores_deficiencia', 'ft_trabalhadores_deficiencia', 'nr_trabalhadores_voluntarios', 'ft_trabalhadores_voluntarios'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
