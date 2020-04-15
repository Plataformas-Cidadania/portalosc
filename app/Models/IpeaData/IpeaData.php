<?php

namespace App\Models\IpeaData;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_ipeadata
 * @property float $cd_municipio
 * @property int $cd_indice
 * @property int $nr_ano
 * @property float $nr_valor
 * @property Ipeadata.tbIndice $ipeadata.tbIndice
 * @property Spat.edMunicipio $spat.edMunicipio
 */
class IpeaData extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ipeadata.tb_ipeadata';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_ipeadata';

    /**
     * @var array
     */
    protected $fillable = ['cd_municipio', 'cd_indice', 'nr_ano', 'nr_valor'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Indice()
    {
        return $this->belongsTo('App\Models\IpeaData\Indice', 'cd_indice', 'cd_indice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Municipio()
    {
        return $this->belongsTo('App\Models\Spat\Municipio', 'cd_municipio', 'edmu_cd_municipio');
    }
}
