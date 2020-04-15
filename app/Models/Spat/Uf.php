<?php

namespace App\Models\Spat;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $eduf_cd_uf
 * @property integer $edre_cd_regiao
 * @property string $eduf_nm_uf
 * @property string $eduf_sg_uf
 * @property mixed $eduf_geometry
 * @property mixed $eduf_centroid
 * @property mixed $eduf_bounding_box
 * @property Spat.edRegiao $spat.edRegiao
 * @property Osc.tbCertificado[] $osc.tbCertificados
 * @property Spat.edMunicipio[] $spat.edMunicipios
 * @property Ipeadata.tbIpeadataUf[] $ipeadata.tbIpeadataUfs
 * @property Osc.tbProjeto[] $osc.tbProjetos
 * @property Portal.tbUsuario[] $portal.tbUsuarios
 */
class Uf extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'spat.ed_uf';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'eduf_cd_uf';

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
    protected $fillable = ['edre_cd_regiao', 'eduf_nm_uf', 'eduf_sg_uf', 'eduf_geometry', 'eduf_centroid', 'eduf_bounding_box'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Regiao()
    {
        return $this->belongsTo('App\Models\Spat\Regiao', 'edre_cd_regiao', 'edre_cd_regiao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Certificados()
    {
        return $this->hasMany('App\Models\Osc\Certificado', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Municipios()
    {
        return $this->hasMany('App\Models\Spat\Municipio', 'eduf_cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function IpeadataUfs()
    {
        return $this->hasMany('App\Models\IpeaData\IpeaDataUf', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Projetos()
    {
        return $this->hasMany('App\Models\Osc\Projeto', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Usuarios()
    {
        return $this->hasMany('App\Models\Portal\Usuario', 'cd_uf', 'eduf_cd_uf');
    }
}
