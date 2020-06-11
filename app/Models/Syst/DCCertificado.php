<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_certificado
 * @property string $tx_nome_certificado
 * @property Osc.tbCertificado[] $osc.tbCertificados
 */
class DCCertificado extends Model
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

}
