<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_fonte_recursos_projeto
 * @property int $id_projeto
 * @property int $cd_fonte_recursos_projeto
 * @property int $cd_origem_fonte_recursos_projeto
 * @property string $ft_fonte_recursos_projeto
 * @property boolean $bo_oficial
 * @property string $tx_orgao_concedente
 * @property string $ft_orgao_concedente
 * @property string $tx_tipo_parceria_outro
 * @property Osc.tbProjeto $osc.tbProjeto
 * @property Syst.dcFonteRecursosProjeto $syst.dcFonteRecursosProjeto
 * @property Syst.dcOrigemFonteRecursosProjeto $syst.dcOrigemFonteRecursosProjeto
 * @property Osc.tbTipoParceriaProjeto[] $osc.tbTipoParceriaProjetos
 */
class FonteRecursosProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_fonte_recursos_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_fonte_recursos_projeto';

    /**
     * @var array
     */
    protected $fillable = ['id_projeto', 'cd_fonte_recursos_projeto', 'cd_origem_fonte_recursos_projeto', 'ft_fonte_recursos_projeto', 'bo_oficial', 'tx_orgao_concedente', 'ft_orgao_concedente', 'tx_tipo_parceria_outro'];

    protected $with = [
        'dc_fonte_recursos_projeto',
        'dc_origem_fonte_recursos_projeto',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projeto()
    {
        return $this->belongsTo('App\Models\Osc\Projeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dc_fonte_recursos_projeto()
    {
        return $this->belongsTo('App\Models\Syst\DCFonteRecursosProjeto', 'cd_fonte_recursos_projeto', 'cd_fonte_recursos_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dc_origem_fonte_recursos_projeto()
    {
        return $this->belongsTo('App\Models\Syst\DCOrigemFonteRecursosProjeto', 'cd_origem_fonte_recursos_projeto', 'cd_origem_fonte_recursos_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function TipoParceriaProjetos()
    {
        return $this->hasMany('App\Models\Osc\TipoParceriaProjeto', 'id_fonte_recursos_projeto', 'id_fonte_recursos_projeto');
    }
}
