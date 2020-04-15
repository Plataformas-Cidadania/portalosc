<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_area_atuacao_declarada
 * @property string $tx_nome_area_atuacao_declarada
 * @property string $ft_nome_area_atuacao_declarada
 * @property Osc.tbAreaAtuacaoOutra[] $osc.tbAreaAtuacaoOutras
 */
class AreaAtuacaoDeclarada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_area_atuacao_declarada';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_area_atuacao_declarada';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_area_atuacao_declarada', 'ft_nome_area_atuacao_declarada'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function AreaAtuacaoOutras()
    {
        return $this->hasMany('App\Models\Osc\AreaAtuacaoOutra', 'id_area_atuacao_declarada', 'id_area_atuacao_declarada');
    }
}
