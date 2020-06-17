<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_osc
 * @property string $tx_apelido_osc
 * @property string $ft_apelido_osc
 * @property float $cd_identificador_osc
 * @property string $ft_identificador_osc
 * @property string $ft_osc_ativa
 * @property boolean $bo_osc_ativa
 * @property boolean $bo_nao_possui_projeto
 * @property string $ft_nao_possui_projeto
 * @property Osc.tbRelacoesTrabalho $osc.tbRelacoesTrabalho
 * @property Osc.tbRecursosOsc[] $osc.tbRecursosOscs
 * @property Osc.tbGovernanca[] $osc.tbGovernancas
 * @property Osc.tbConselhoFiscal[] $osc.tbConselhoFiscals
 * @property Osc.tbCertificado[] $osc.tbCertificados
 * @property Osc.tbObjetivoOsc[] $osc.tbObjetivoOscs
 * @property Osc.tbDadosGerai $osc.tbDadosGerai
 * @property Osc.tbParticipacaoSocialOutra[] $osc.tbParticipacaoSocialOutras
 * @property Osc.tbParticipacaoSocialConferencium[] $osc.tbParticipacaoSocialConferencias
 * @property Osc.tbParticipacaoSocialConselho[] $osc.tbParticipacaoSocialConselhos
 * @property Osc.tbRepresentanteConselho[] $osc.tbRepresentanteConselhos
 * @property Osc.tbLocalizacao $osc.tbLocalizacao
 * @property Osc.tbAreaAtuacao[] $osc.tbAreaAtuacaos
 * @property Osc.tbContato $osc.tbContato
 * @property Osc.tbProjeto[] $osc.tbProjetos
 * @property Osc.tbRelacoesTrabalhoOutra[] $osc.tbRelacoesTrabalhoOutras
 * @property Portal.tbRepresentacao[] $portal.tbRepresentacaos
 * @property Osc.tbRecursosOutroOsc[] $osc.tbRecursosOutroOscs
 * @property Osc.tbAreaAtuacaoOutra[] $osc.tbAreaAtuacaoOutras
 * @property Osc.tbOscParceiraProjeto[] $osc.tbOscParceiraProjetos
 * @property Portal.tbBarraTransparencium $portal.tbBarraTransparencium
 */
class Osc extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_osc';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_osc';



    /**
     * @var array
     */
    protected $fillable = [
        'tx_apelido_osc',
        'ft_apelido_osc',
        'cd_identificador_osc',
        'ft_identificador_osc',
        'ft_osc_ativa',
        'bo_osc_ativa',
        'bo_nao_possui_projeto',
        'ft_nao_possui_projeto'
    ];

    /**
     * @var array
     */
    protected $with = [
        'contato',
        'dados_gerais',
        'areas_e_subareas_atuacao',
        'titulos_e_certificados',
        'trabalhadores',
        'quadro_de_dirigentes',
        'conselho_fiscal',
        'conselhos_politicas_publicas',
        'conferencias_politicas_publicas',
        'outros_espacos_participacao_social',
        'projetos',
        //'localizacao'

    ];

    /**
     * @var desativar coluna BD
     */
    public $timestamps = false;

    //------------------------------------------METODOS DE RELACIONAMENTOS-------------------------------------------------------------------------------------//
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dados_gerais()
    {
        return $this->hasOne('App\Models\Osc\DadosGerais', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function titulos_e_certificados()
    {
        return $this->hasMany('App\Models\Osc\Certificado', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quadro_de_dirigentes()
    {
        return $this->hasMany('App\Models\Osc\Governanca', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conselho_fiscal()
    {
        return $this->hasMany('App\Models\Osc\ConselhoFiscal', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function trabalhadores()
    {
        return $this->hasOne('App\Models\Osc\RelacoesTrabalho', 'id_osc', 'id_osc');
    }

    //-----------------------------------Espaço de Participação Social----------------------------------------//
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conselhos_politicas_publicas()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialConselho', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function conferencias_politicas_publicas()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialConferencia', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outros_espacos_participacao_social()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialOutra', 'id_osc', 'id_osc');
    }

    //-----------------------------------FIM Espaço de Participação Social----------------------------------------//

    //-----------------------------------Projetos----------------------------------------//

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projetos()
    {
        return $this->hasMany('App\Models\Osc\Projeto', 'id_osc', 'id_osc');
    }

    //-----------------------------------FIM Projetos----------------------------------------//

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objetivos()
    {
        return $this->hasMany('App\Models\Osc\ObjetivoOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function representantesConselho()
    {
        return $this->hasMany('App\Models\Osc\RepresentanteConselho', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function localizacao()
    {
        return $this->hasOne('App\Models\Osc\Localizacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function areas_e_subareas_atuacao()
    {
        return $this->hasMany('App\Models\Osc\AreaAtuacao', 'id_osc', 'id_osc');
        //return $this->hasManyThrough('App\Models\Syst\DCAreaAtuacao', 'App\Models\Osc\AreaAtuacao', 'id_osc', 'cd_area_atuacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contato()
    {
        return $this->hasOne('App\Models\Osc\Contato', 'id_osc', 'id_osc');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relacoesTrabalhoOutras()
    {
        return $this->hasMany('App\Models\Osc\RelacoesTrabalhoOutra', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function representacoes()
    {
        return $this->hasMany('App\Models\Portal\Representacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recursosOutrosOsc()
    {
        return $this->hasMany('App\Models\Osc\RecursosOutroOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function areasAtuacaoOutras()
    {
        return $this->hasMany('App\Models\Osc\AreaAtuacaoOutra', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parceirasProjetos()
    {
        return $this->hasMany('App\Models\Osc\OscParceiraProjeto', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function barraTransparencia()
    {
        return $this->hasOne('App\Models\Portal\BarraTransparencia', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recursos()
    {
        return $this->hasMany('App\Models\Osc\RecursosOsc', 'id_osc', 'id_osc');
    }
}
