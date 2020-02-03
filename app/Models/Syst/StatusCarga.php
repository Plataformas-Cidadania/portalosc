<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_status
 * @property string $tx_nome_status
 * @property string $tx_descricao_status
 * @property Log.tbLogErroCarga[] $log.tbLogErroCargas
 * @property Log.tbLogCarga[] $log.tbLogCargas
 */
class StatusCarga extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_status_carga';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_status';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_status', 'tx_descricao_status'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log.tbLogErroCargas()
    {
        return $this->hasMany('App\Models\Syst\Log.tbLogErroCarga', 'cd_status', 'cd_status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function log.tbLogCargas()
    {
        return $this->hasMany('App\Models\Syst\Log.tbLogCarga', 'cd_status', 'cd_status');
    }
}
