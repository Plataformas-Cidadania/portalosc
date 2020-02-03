<?php

namespace App\Models\Graph;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_siafi
 * @property int $ano
 * @property int $mes_numero
 * @property string $funcional
 * @property int $gnd_cod
 * @property int $mod_aplic_cod
 * @property int $elemento_despesa_cod
 * @property integer $id_estab
 * @property float $empenhado
 * @property float $pago
 * @property float $empenhado_def
 * @property float $pago_def
 */
class Siafi extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'graph.siafi';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_siafi';

    /**
     * @var array
     */
    protected $fillable = ['ano', 'mes_numero', 'funcional', 'gnd_cod', 'mod_aplic_cod', 'elemento_despesa_cod', 'id_estab', 'empenhado', 'pago', 'empenhado_def', 'pago_def'];

}
