<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_certificado
 * @property int $id_osc
 * @property int $cd_certificado
 * @property float $cd_municipio
 * @property float $cd_uf
 * @property string $ft_certificado
 * @property string $dt_inicio_certificado
 * @property string $ft_inicio_certificado
 * @property string $dt_fim_certificado
 * @property string $ft_fim_certificado
 * @property boolean $bo_oficial
 * @property string $ft_municipio
 * @property string $ft_uf
 * @property Spat.edMunicipio $spat.edMunicipio
 * @property Spat.edUf $spat.edUf
 * @property Syst.dcCertificado $syst.dcCertificado
 * @property Osc.tbOsc $osc.tbOsc
 */
class Certificado extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_certificado';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_certificado';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'cd_certificado', 'cd_municipio', 'cd_uf', 'ft_certificado', 'dt_inicio_certificado', 'ft_inicio_certificado', 'dt_fim_certificado', 'ft_fim_certificado', 'bo_oficial', 'ft_municipio', 'ft_uf'];


    protected $with = ['dc_certificado', 'municipio', 'uf'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo('App\Models\Spat\Municipio', 'cd_municipio', 'edmu_cd_municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function uf()
    {
        return $this->belongsTo('App\Models\Spat\Uf', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dc_certificado()
    {
        return $this->belongsTo('App\Models\Syst\DCCertificado', 'cd_certificado', 'cd_certificado');
    }
}
