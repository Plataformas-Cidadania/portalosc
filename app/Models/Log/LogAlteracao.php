<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_log_alteracao
 * @property int $id_carga
 * @property string $tx_nome_tabela
 * @property int $id_osc
 * @property string $tx_fonte_dados
 * @property string $dt_alteracao
 * @property mixed $tx_dado_anterior
 * @property mixed $tx_dado_posterior
 * @property Log.tbLogCarga $log.tbLogCarga
 */
class LogAlteracao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'log.tb_log_alteracao';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_log_alteracao';

    /**
     * @var array
     */
    protected $fillable = ['id_carga', 'tx_nome_tabela', 'id_osc', 'tx_fonte_dados', 'dt_alteracao', 'tx_dado_anterior', 'tx_dado_posterior'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function LogCarga()
    {
        return $this->belongsTo('App\Models\Log\LogCarga', 'id_carga', 'id_carga');
    }
}
