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
    public function ipeadata.tbIndice()
    {
        return $this->belongsTo('App\Models\IpeaData\Ipeadata.tbIndice', 'cd_indice', 'cd_indice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spat.edMunicipio()
    {
        return $this->belongsTo('App\Models\IpeaData\Spat.edMunicipio', 'cd_municipio', 'edmu_cd_municipio');
    }
}
