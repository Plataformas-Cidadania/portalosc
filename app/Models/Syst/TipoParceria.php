<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_tipo_parceria
 * @property string $tx_nome_tipo_parceria
 * @property Osc.tbTipoParceriaProjeto[] $osc.tbTipoParceriaProjetos
 */
class TipoParceria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_tipo_parceria';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_tipo_parceria';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_tipo_parceria'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function TipoParceriaProjetos()
    {
        return $this->hasMany('App\Models\Osc\TipoParceriaProjeto', 'cd_tipo_parceria_projeto', 'cd_tipo_parceria');
    }
}
