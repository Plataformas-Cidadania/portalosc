<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_status_projeto
 * @property string $tx_nome_status_projeto
 * @property Osc.tbProjeto[] $osc.tbProjetos
 */
class StatusProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_status_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_status_projeto';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_status_projeto'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbProjetos()
    {
        return $this->hasMany('App\Models\Syst\Osc.tbProjeto', 'cd_status_projeto', 'cd_status_projeto');
    }
}
