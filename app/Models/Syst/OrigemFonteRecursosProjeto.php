<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_origem_fonte_recursos_projeto
 * @property string $tx_nome_origem_fonte_recursos_projeto
 * @property Osc.tbFonteRecursosProjeto[] $osc.tbFonteRecursosProjetos
 * @property Syst.dcFonteRecursosProjeto[] $syst.dcFonteRecursosProjetos
 */
class OrigemFonteRecursosProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_origem_fonte_recursos_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_origem_fonte_recursos_projeto';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_origem_fonte_recursos_projeto'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbFonteRecursosProjetos()
    {
        return $this->hasMany('App\Models\Syst\Osc.tbFonteRecursosProjeto', 'cd_origem_fonte_recursos_projeto', 'cd_origem_fonte_recursos_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function syst.dcFonteRecursosProjetos()
    {
        return $this->hasMany('App\Models\Syst\Syst.dcFonteRecursosProjeto', 'cd_origem_fonte_recursos_projeto', 'cd_origem_fonte_recursos_projeto');
    }
}
