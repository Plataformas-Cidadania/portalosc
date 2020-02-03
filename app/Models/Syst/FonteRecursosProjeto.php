<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_fonte_recursos_projeto
 * @property int $cd_origem_fonte_recursos_projeto
 * @property string $tx_nome_fonte_recursos_projeto
 * @property Syst.dcOrigemFonteRecursosProjeto $syst.dcOrigemFonteRecursosProjeto
 * @property Osc.tbFonteRecursosProjeto[] $osc.tbFonteRecursosProjetos
 */
class FonteRecursosProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_fonte_recursos_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_fonte_recursos_projeto';

    /**
     * @var array
     */
    protected $fillable = ['cd_origem_fonte_recursos_projeto', 'tx_nome_fonte_recursos_projeto'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syst.dcOrigemFonteRecursosProjeto()
    {
        return $this->belongsTo('App\Models\Syst\Syst.dcOrigemFonteRecursosProjeto', 'cd_origem_fonte_recursos_projeto', 'cd_origem_fonte_recursos_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbFonteRecursosProjetos()
    {
        return $this->hasMany('App\Models\Syst\Osc.tbFonteRecursosProjeto', 'cd_fonte_recursos_projeto', 'cd_fonte_recursos_projeto');
    }
}
