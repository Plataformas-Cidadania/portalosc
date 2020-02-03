<?php

namespace App\Models\Spat;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $edmu_cd_municipio
 * @property integer $eduf_cd_uf
 * @property string $edmu_nm_municipio
 * @property mixed $edmu_geometry
 * @property mixed $edmu_centroid
 * @property mixed $edmu_bounding_box
 * @property Spat.edUf $spat.edUf
 * @property Osc.tbCertificado[] $osc.tbCertificados
 * @property Ipeadata.tbIpeadatum[] $ipeadata.tbIpeadatas
 * @property Osc.tbProjeto[] $osc.tbProjetos
 * @property Portal.tbUsuario[] $portal.tbUsuarios
 */
class Municipio extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'spat.ed_municipio';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'edmu_cd_municipio';

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
    protected $fillable = ['eduf_cd_uf', 'edmu_nm_municipio', 'edmu_geometry', 'edmu_centroid', 'edmu_bounding_box'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spat.edUf()
    {
        return $this->belongsTo('App\Models\Spat\Spat.edUf', 'eduf_cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbCertificados()
    {
        return $this->hasMany('App\Models\Spat\Osc.tbCertificado', 'cd_municipio', 'edmu_cd_municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ipeadata.tbIpeadatas()
    {
        return $this->hasMany('App\Models\Spat\Ipeadata.tbIpeadatum', 'cd_municipio', 'edmu_cd_municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbProjetos()
    {
        return $this->hasMany('App\Models\Spat\Osc.tbProjeto', 'cd_municipio', 'edmu_cd_municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function portal.tbUsuarios()
    {
        return $this->hasMany('App\Models\Spat\Portal.tbUsuario', 'cd_municipio', 'edmu_cd_municipio');
    }
}
