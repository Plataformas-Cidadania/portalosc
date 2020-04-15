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
    protected $fillable = ['tx_apelido_osc', 'ft_apelido_osc', 'cd_identificador_osc', 'ft_identificador_osc', 'ft_osc_ativa', 'bo_osc_ativa', 'bo_nao_possui_projeto', 'ft_nao_possui_projeto'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function RelacoesTrabalho()
    {
        return $this->hasOne('App\Models\Osc\RelacoesTrabalho', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function RecursosOscs()
    {
        return $this->hasMany('App\Models\Osc\RecursosOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Governancas()
    {
        return $this->hasMany('App\Models\Osc\Governanca', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ConselhoFiscals()
    {
        return $this->hasMany('App\Models\Osc\ConselhoFiscal', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Certificados()
    {
        return $this->hasMany('App\Models\Osc\Certificado', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ObjetivoOscs()
    {
        return $this->hasMany('App\Models\Osc\ObjetivoOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function DadosGerai()
    {
        return $this->hasOne('App\Models\Osc\DadosGerai', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ParticipacaoSocialOutras()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialOutra', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ParticipacaoSocialConferencias()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialConferencium', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ParticipacaoSocialConselhos()
    {
        return $this->hasMany('App\Models\Osc\ParticipacaoSocialConselho', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function RepresentanteConselhos()
    {
        return $this->hasMany('App\Models\Osc\RepresentanteConselho', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Localizacao()
    {
        return $this->hasOne('App\Models\Osc\Localizacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function AreaAtuacaos()
    {
        return $this->hasMany('App\Models\Osc\AreaAtuacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Contato()
    {
        return $this->hasOne('App\Models\Osc\Contato', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Projetos()
    {
        return $this->hasMany('App\Models\Osc\Projeto', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function RelacoesTrabalhoOutras()
    {
        return $this->hasMany('App\Models\Osc\RelacoesTrabalhoOutra', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sRepresentacaos()
    {
        return $this->hasMany('App\Models\Portal\Representacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function RecursosOutroOscs()
    {
        return $this->hasMany('App\Models\Osc\RecursosOutroOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function AreaAtuacaoOutras()
    {
        return $this->hasMany('App\Models\Osc\AreaAtuacaoOutra', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc_tbOscParceiraProjetos()
    {
        return $this->hasMany('App\Models\Osc\OscParceiraProjeto', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function portal_tbBarraTransparencium()
    {
        return $this->hasOne('App\Models\Portal\BarraTransparencium', 'id_osc', 'id_osc');
    }
}
