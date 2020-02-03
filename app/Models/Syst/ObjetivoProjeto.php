<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_objetivo_projeto
 * @property string $tx_nome_objetivo_projeto
 * @property string $tx_codigo_objetivo_projeto
 * @property Syst.dcMetaProjeto[] $syst.dcMetaProjetos
 */
class ObjetivoProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_objetivo_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_objetivo_projeto';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_objetivo_projeto', 'tx_codigo_objetivo_projeto'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function syst.dcMetaProjetos()
    {
        return $this->hasMany('App\Models\Syst\Syst.dcMetaProjeto', 'cd_objetivo_projeto', 'cd_objetivo_projeto');
    }
}
