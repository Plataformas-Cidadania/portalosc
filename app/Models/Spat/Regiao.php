<?php

namespace App\Models\Spat;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $edre_cd_regiao
 * @property string $edre_sg_regiao
 * @property string $edre_nm_regiao
 * @property mixed $edre_geometry
 * @property mixed $edre_centroid
 * @property mixed $edre_bounding_box
 * @property Spat.edUf[] $spat.edUfs
 */
class Regiao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'spat.ed_regiao';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'edre_cd_regiao';

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
    protected $fillable = ['edre_sg_regiao', 'edre_nm_regiao', 'edre_geometry', 'edre_centroid', 'edre_bounding_box'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Ufs()
    {
        return $this->hasMany('App\Models\Spat\Uf', 'edre_cd_regiao', 'edre_cd_regiao');
    }
}
