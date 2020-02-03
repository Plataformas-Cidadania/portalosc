<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_certificado
 * @property string $tx_nome_certificado
 * @property Osc.tbCertificado[] $osc.tbCertificados
 */
class Certificado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_certificado';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_certificado';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_certificado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbCertificados()
    {
        return $this->hasMany('App\Models\Syst\Osc.tbCertificado', 'cd_certificado', 'cd_certificado');
    }
}
