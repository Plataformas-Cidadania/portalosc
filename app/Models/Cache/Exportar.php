<?php

namespace App\Models\Cache;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_exportar
 * @property string $tx_chave
 * @property string $tx_valor
 */
class Exportar extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cache.tb_exportar';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_exportar';

    /**
     * @var array
     */
    protected $fillable = ['tx_chave', 'tx_valor'];

}
