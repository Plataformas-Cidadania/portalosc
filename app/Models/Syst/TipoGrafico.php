<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_grafico
 * @property string $nome_tipo_grafico
 * @property int $status
 * @property Portal.tbAnalise[] $portal.tbAnalises
 */
class TipoGrafico extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.tb_tipo_grafico';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_grafico';

    /**
     * @var array
     */
    protected $fillable = ['nome_tipo_grafico', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Analises()
    {
        return $this->hasMany('App\Models\Portal\Analise', 'tipo_grafico', 'id_grafico');
    }
}
