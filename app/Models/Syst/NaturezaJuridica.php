<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $cd_natureza_juridica
 * @property string $tx_nome_natureza_juridica
 * @property Osc.tbDadosGerai[] $osc.tbDadosGerais
 */
class NaturezaJuridica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_natureza_juridica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_natureza_juridica';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_natureza_juridica'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function DadosGerais()
    {
        return $this->hasMany('App\Models\Osc\DadosGerai', 'cd_natureza_juridica_osc', 'cd_natureza_juridica');
    }
}
