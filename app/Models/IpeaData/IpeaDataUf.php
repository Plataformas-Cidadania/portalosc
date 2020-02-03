<?php

namespace App\Models\IpeaData;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_ipeadata_uf
 * @property float $cd_uf
 * @property int $cd_indice
 * @property int $nr_ano
 * @property float $nr_valor
 * @property Ipeadata.tbIndice $ipeadata.tbIndice
 * @property Spat.edUf $spat.edUf
 */
class IpeaDataUf extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ipeadata.tb_ipeadata_uf';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_ipeadata_uf';

    /**
     * @var array
     */
    protected $fillable = ['cd_uf', 'cd_indice', 'nr_ano', 'nr_valor'];

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
    public function spat.edUf()
    {
        return $this->belongsTo('App\Models\IpeaData\Spat.edUf', 'cd_uf', 'eduf_cd_uf');
    }
}
