<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_fonte_geocodoficacao
 * @property string $tx_fonte_geocodificacao
 * @property Osc.tbLocalizacao[] $osc.tbLocalizacaos
 */
class FonteGeocodificacao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_fonte_geocodificacao';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_fonte_geocodoficacao';

    /**
     * @var array
     */
    protected $fillable = ['tx_fonte_geocodificacao'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Localizacaos()
    {
        return $this->hasMany('App\Models\Osc\Localizacao', 'cd_fonte_geocodificacao', 'cd_fonte_geocodoficacao');
    }
}
