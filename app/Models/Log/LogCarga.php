<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_carga
 * @property int $cd_status
 * @property string $tx_carga
 * @property string $dt_inicio
 * @property string $dt_fim
 * @property Syst.dcStatusCarga $syst.dcStatusCarga
 * @property Log.tbLogErroCarga[] $log.tbLogErroCargas
 * @property Log.tbLogAlteracao[] $log.tbLogAlteracaos
 */
class LogCarga extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'log.tb_log_carga';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_carga';

    /**
     * @var array
     */
    protected $fillable = ['cd_status', 'tx_carga', 'dt_inicio', 'dt_fim'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syst.dcStatusCarga()
    {
        return $this->belongsTo('App\Models\Log\Syst.dcStatusCarga', 'cd_status', 'cd_status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log.tbLogErroCargas()
    {
        return $this->hasMany('App\Models\Log\Log.tbLogErroCarga', 'id_carga', 'id_carga');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log.tbLogAlteracaos()
    {
        return $this->hasMany('App\Models\Log\Log.tbLogAlteracao', 'id_carga', 'id_carga');
    }
}
