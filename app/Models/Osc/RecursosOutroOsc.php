<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_recursos_outro_osc
 * @property int $id_osc
 * @property string $tx_nome_fonte_recursos_outro_osc
 * @property string $ft_nome_fonte_recursos_outro_osc
 * @property string $dt_ano_recursos_outro_osc
 * @property string $ft_ano_recursos_outro_osc
 * @property float $nr_valor_recursos_outro_osc
 * @property string $ft_valor_recursos_outro_osc
 * @property Osc.tbOsc $osc.tbOsc
 */
class RecursosOutroOsc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_recursos_outro_osc';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_recursos_outro_osc';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'tx_nome_fonte_recursos_outro_osc', 'ft_nome_fonte_recursos_outro_osc', 'dt_ano_recursos_outro_osc', 'ft_ano_recursos_outro_osc', 'nr_valor_recursos_outro_osc', 'ft_valor_recursos_outro_osc'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
