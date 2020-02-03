<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_abrangencia_projeto
 * @property string $tx_nome_abrangencia_projeto
 * @property Osc.tbProjeto[] $osc.tbProjetos
 */
class AbrangenciaProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_abrangencia_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_abrangencia_projeto';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_abrangencia_projeto'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbProjetos()
    {
        return $this->hasMany('App\Models\Syst\Osc.tbProjeto', 'cd_abrangencia_projeto', 'cd_abrangencia_projeto');
    }
}
