<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_analise
 * @property int $tipo_grafico
 * @property string $configuracao
 * @property string $titulo
 * @property string $legenda
 * @property string $titulo_colunas
 * @property string $legenda_x
 * @property string $legenda_y
 * @property mixed $parametros
 * @property mixed $series_1
 * @property mixed $series_2
 * @property string $fontes
 * @property boolean $inverter_label
 * @property string $slug
 * @property boolean $ativo
 * @property int $status
 * @property Syst.tbTipoGrafico $syst.tbTipoGrafico
 */
class Analise extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'portal.tb_analise';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_analise';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['tipo_grafico', 'configuracao', 'titulo', 'legenda', 'titulo_colunas', 'legenda_x', 'legenda_y', 'parametros', 'series_1', 'series_2', 'fontes', 'inverter_label', 'slug', 'ativo', 'status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function TipoGrafico()
    {
        return $this->belongsTo('App\Models\Syst\TipoGrafico', 'tipo_grafico', 'id_grafico');
    }
}
