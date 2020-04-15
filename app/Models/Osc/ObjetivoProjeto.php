<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_objetivo_projeto
 * @property int $id_projeto
 * @property int $cd_meta_projeto
 * @property string $ft_objetivo_projeto
 * @property boolean $bo_oficial
 * @property Osc.tbProjeto $osc.tbProjeto
 * @property Syst.dcMetaProjeto $syst.dcMetaProjeto
 */
class ObjetivoProjeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_objetivo_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_objetivo_projeto';

    /**
     * @var array
     */
    protected $fillable = ['id_projeto', 'cd_meta_projeto', 'ft_objetivo_projeto', 'bo_oficial'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Projeto()
    {
        return $this->belongsTo('App\Models\Osc\Projeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function MetaProjeto()
    {
        return $this->belongsTo('App\Models\Syst\MetaProjeto', 'cd_meta_projeto', 'cd_meta_projeto');
    }
}
