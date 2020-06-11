<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_conselheiro
 * @property int $id_osc
 * @property string $tx_nome_conselheiro
 * @property string $ft_nome_conselheiro
 * @property boolean $bo_oficial
 * @property Osc.tbOsc $osc.tbOsc
 */
class ConselhoFiscal extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_conselho_fiscal';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_conselheiro';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'tx_nome_conselheiro', 'ft_nome_conselheiro', 'bo_oficial'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
