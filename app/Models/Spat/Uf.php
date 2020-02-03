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
    public function spat.edRegiao()
    {
        return $this->belongsTo('App\Models\Spat\Spat.edRegiao', 'edre_cd_regiao', 'edre_cd_regiao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbCertificados()
    {
        return $this->hasMany('App\Models\Spat\Osc.tbCertificado', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spat.edMunicipios()
    {
        return $this->hasMany('App\Models\Spat\Spat.edMunicipio', 'eduf_cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ipeadata.tbIpeadataUfs()
    {
        return $this->hasMany('App\Models\Spat\Ipeadata.tbIpeadataUf', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbProjetos()
    {
        return $this->hasMany('App\Models\Spat\Osc.tbProjeto', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function portal.tbUsuarios()
    {
        return $this->hasMany('App\Models\Spat\Portal.tbUsuario', 'cd_uf', 'eduf_cd_uf');
    }
}
