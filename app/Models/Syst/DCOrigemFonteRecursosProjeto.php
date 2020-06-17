<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_origem_fonte_recursos_projeto
 * @property string $tx_nome_origem_fonte_recursos_projeto
 * @property Osc.tbFonteRecursosProjeto[] $osc.tbFonteRecursosProjetos
 * @property Syst.dcFonteRecursosProjeto[] $syst.dcFonteRecursosProjetos
 */
class DCOrigemFonteRecursosProjeto extends Model
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
    public function fontes_recursos_projeto()
    {
        return $this->hasMany('App\Models\Osc\FonteRecursosProjeto', 'cd_origem_fonte_recursos_projeto', 'cd_origem_fonte_recursos_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dc_fonte_recursos_projeto()
    {
        return $this->hasMany('App\Models\Syst\DCFonteRecursosProjeto', 'cd_origem_fonte_recursos_projeto', 'cd_origem_fonte_recursos_projeto');
    }
}
