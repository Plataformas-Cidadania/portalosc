<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_projeto
 * @property int $id_osc
 * @property int $cd_status_projeto
 * @property int $cd_abrangencia_projeto
 * @property int $cd_zona_atuacao_projeto
 * @property int $cd_municipio
 * @property int $cd_uf
 * @property string $tx_nome_projeto
 * @property string $ft_nome_projeto
 * @property string $ft_status_projeto
 * @property string $dt_data_inicio_projeto
 * @property string $ft_data_inicio_projeto
 * @property string $dt_data_fim_projeto
 * @property string $ft_data_fim_projeto
 * @property string $tx_link_projeto
 * @property string $ft_link_projeto
 * @property int $nr_total_beneficiarios
 * @property string $ft_total_beneficiarios
 * @property float $nr_valor_captado_projeto
 * @property string $ft_valor_captado_projeto
 * @property float $nr_valor_total_projeto
 * @property string $ft_valor_total_projeto
 * @property string $ft_abrangencia_projeto
 * @property string $ft_zona_atuacao_projeto
 * @property string $tx_descricao_projeto
 * @property string $ft_descricao_projeto
 * @property string $ft_metodologia_monitoramento
 * @property string $tx_metodologia_monitoramento
 * @property string $tx_identificador_projeto_externo
 * @property string $ft_identificador_projeto_externo
 * @property boolean $bo_oficial
 * @property string $tx_status_projeto_outro
 * @property string $ft_municipio
 * @property string $ft_uf
 * @property Syst.dcZonaAtuacaoProjeto $syst.dcZonaAtuacaoProjeto
 * @property Syst.dcAbrangenciaProjeto $syst.dcAbrangenciaProjeto
 * @property Spat.edMunicipio $spat.edMunicipio
 * @property Syst.dcStatusProjeto $syst.dcStatusProjeto
 * @property Spat.edUf $spat.edUf
 * @property Osc.tbOsc $osc.tbOsc
 * @property Osc.tbFonteRecursosProjeto[] $osc.tbFonteRecursosProjetos
 * @property Osc.tbTipoParceriaProjeto[] $osc.tbTipoParceriaProjetos
 * @property Osc.tbLocalizacaoProjeto[] $osc.tbLocalizacaoProjetos
 * @property Osc.tbFinanciadorProjeto[] $osc.tbFinanciadorProjetos
 * @property Osc.tbAreaAtuacaoOutraProjeto[] $osc.tbAreaAtuacaoOutraProjetos
 * @property Osc.tbAreaAtuacaoProjeto[] $osc.tbAreaAtuacaoProjetos
 * @property Osc.tbPublicoBeneficiadoProjeto[] $osc.tbPublicoBeneficiadoProjetos
 * @property Osc.tbObjetivoProjeto[] $osc.tbObjetivoProjetos
 * @property Osc.tbOscParceiraProjeto[] $osc.tbOscParceiraProjetos
 */
class Projeto extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_projeto';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_projeto';

    /**
     * @var array
     */
    protected $fillable = ['id_osc', 'cd_status_projeto', 'cd_abrangencia_projeto', 'cd_zona_atuacao_projeto', 'cd_municipio', 'cd_uf', 'tx_nome_projeto', 'ft_nome_projeto', 'ft_status_projeto', 'dt_data_inicio_projeto', 'ft_data_inicio_projeto', 'dt_data_fim_projeto', 'ft_data_fim_projeto', 'tx_link_projeto', 'ft_link_projeto', 'nr_total_beneficiarios', 'ft_total_beneficiarios', 'nr_valor_captado_projeto', 'ft_valor_captado_projeto', 'nr_valor_total_projeto', 'ft_valor_total_projeto', 'ft_abrangencia_projeto', 'ft_zona_atuacao_projeto', 'tx_descricao_projeto', 'ft_descricao_projeto', 'ft_metodologia_monitoramento', 'tx_metodologia_monitoramento', 'tx_identificador_projeto_externo', 'ft_identificador_projeto_externo', 'bo_oficial', 'tx_status_projeto_outro', 'ft_municipio', 'ft_uf'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syst.dcZonaAtuacaoProjeto()
    {
        return $this->belongsTo('App\Models\Osc\Syst.dcZonaAtuacaoProjeto', 'cd_zona_atuacao_projeto', 'cd_zona_atuacao_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syst.dcAbrangenciaProjeto()
    {
        return $this->belongsTo('App\Models\Osc\Syst.dcAbrangenciaProjeto', 'cd_abrangencia_projeto', 'cd_abrangencia_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spat.edMunicipio()
    {
        return $this->belongsTo('App\Models\Osc\Spat.edMunicipio', 'cd_municipio', 'edmu_cd_municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syst.dcStatusProjeto()
    {
        return $this->belongsTo('App\Models\Osc\Syst.dcStatusProjeto', 'cd_status_projeto', 'cd_status_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spat.edUf()
    {
        return $this->belongsTo('App\Models\Osc\Spat.edUf', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function osc.tbOsc()
    {
        return $this->belongsTo('App\Models\Osc\Osc.tbOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbFonteRecursosProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbFonteRecursosProjeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbTipoParceriaProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbTipoParceriaProjeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbLocalizacaoProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbLocalizacaoProjeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbFinanciadorProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbFinanciadorProjeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbAreaAtuacaoOutraProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbAreaAtuacaoOutraProjeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbAreaAtuacaoProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbAreaAtuacaoProjeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbPublicoBeneficiadoProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbPublicoBeneficiadoProjeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbObjetivoProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbObjetivoProjeto', 'id_projeto', 'id_projeto');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbOscParceiraProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbOscParceiraProjeto', 'id_projeto', 'id_projeto');
    }
}
