<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_log_erro_carga
 * @property integer $cd_status
 * @property int $id_carga
 * @property float $cd_identificador_osc
 * @property string $tx_mensagem
 * @property string $dt_carregamento_dados
 * @property Syst.dcStatusCarga $syst.dcStatusCarga
 * @property Log.tbLogCarga $log.tbLogCarga
 */
class LogErroCarga extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'log.tb_log_erro_carga';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_log_erro_carga';

    /**
     * @var array
     */
    protected $fillable = ['cd_status', 'id_carga', 'cd_identificador_osc', 'tx_mensagem', 'dt_carregamento_dados'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syst.dcStatusCarga()
    {
        return $this->belongsTo('App\Models\Log\Syst.dcStatusCarga', 'cd_status', 'cd_status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function log.tbLogCarga()
    {
        return $this->belongsTo('App\Models\Log\Log.tbLogCarga', 'id_carga', 'id_carga');
    }
}
