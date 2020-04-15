<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_osc
 * @property int $id_barra_transparencia
 * @property float $transparencia_dados_gerais
 * @property float $peso_dados_gerais
 * @property float $transparencia_area_atuacao
 * @property float $peso_area_atuacao
 * @property float $transparencia_descricao
 * @property float $peso_descricao
 * @property float $transparencia_titulos_certificacoes
 * @property float $peso_titulos_certificacoes
 * @property float $transparencia_relacoes_trabalho_governanca
 * @property float $peso_relacoes_trabalho_governanca
 * @property float $transparencia_espacos_participacao_social
 * @property float $peso_espacos_participacao_social
 * @property float $transparencia_projetos_atividades_programas
 * @property float $peso_projetos_atividades_programas
 * @property float $transparencia_fontes_recursos
 * @property float $peso_fontes_recursos
 * @property float $transparencia_osc
 * @property Osc.tbOsc $osc.tbOsc
 */
class BarraTransparencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'portal.tb_barra_transparencia';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'id_barra_transparencia', 'transparencia_dados_gerais', 'peso_dados_gerais', 'transparencia_area_atuacao', 'peso_area_atuacao', 'transparencia_descricao', 'peso_descricao', 'transparencia_titulos_certificacoes', 'peso_titulos_certificacoes', 'transparencia_relacoes_trabalho_governanca', 'peso_relacoes_trabalho_governanca', 'transparencia_espacos_participacao_social', 'peso_espacos_participacao_social', 'transparencia_projetos_atividades_programas', 'peso_projetos_atividades_programas', 'transparencia_fontes_recursos', 'peso_fontes_recursos', 'transparencia_osc'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Portal\Osc', 'id_osc', 'id_osc');
    }
}
