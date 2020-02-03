<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_fonte_recursos_osc
 * @property int $cd_origem_fonte_recursos_osc
 * @property string $tx_nome_fonte_recursos_osc
 * @property Syst.dcOrigemFonteRecursosOsc $syst.dcOrigemFonteRecursosOsc
 * @property Osc.tbRecursosOsc[] $osc.tbRecursosOscs
 */
class FonteRecursosOsc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_fonte_recursos_osc';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_fonte_recursos_osc';

    /**
     * @var array
     */
    protected $fillable = ['cd_origem_fonte_recursos_osc', 'tx_nome_fonte_recursos_osc'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syst.dcOrigemFonteRecursosOsc()
    {
        return $this->belongsTo('App\Models\Syst\Syst.dcOrigemFonteRecursosOsc', 'cd_origem_fonte_recursos_osc', 'cd_origem_fonte_recursos_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbRecursosOscs()
    {
        return $this->hasMany('App\Models\Syst\Osc.tbRecursosOsc', 'cd_fonte_recursos_osc', 'cd_fonte_recursos_osc');
    }
}
