<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_edital
 * @property string $tx_orgao
 * @property string $tx_programa
 * @property string $tx_area_interesse_edital
 * @property string $dt_vencimento
 * @property string $tx_link_edital
 * @property string $tx_numero_chamada
 */
class Edital extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'portal.tb_edital';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_edital';

    /**
     * @var array
     */
    protected $fillable = ['tx_orgao', 'tx_programa', 'tx_area_interesse_edital', 'dt_vencimento', 'tx_link_edital', 'tx_numero_chamada'];

}
