<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_dirigente
 * @property int $id_osc
 * @property string $tx_cargo_dirigente
 * @property string $ft_cargo_dirigente
 * @property string $tx_nome_dirigente
 * @property string $ft_nome_dirigente
 * @property boolean $bo_oficial
 * @property Osc.tbOsc $osc.tbOsc
 */
class Governanca extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_governanca';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_dirigente';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'tx_cargo_dirigente', 'ft_cargo_dirigente', 'tx_nome_dirigente', 'ft_nome_dirigente', 'bo_oficial'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
