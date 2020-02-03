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
    public function osc.tbRelacoesTrabalho()
    {
        return $this->hasOne('App\Models\Osc\Osc.tbRelacoesTrabalho', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbRecursosOscs()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbRecursosOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbGovernancas()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbGovernanca', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbConselhoFiscals()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbConselhoFiscal', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbCertificados()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbCertificado', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbObjetivoOscs()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbObjetivoOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function osc.tbDadosGerai()
    {
        return $this->hasOne('App\Models\Osc\Osc.tbDadosGerai', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbParticipacaoSocialOutras()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbParticipacaoSocialOutra', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbParticipacaoSocialConferencias()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbParticipacaoSocialConferencium', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbParticipacaoSocialConselhos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbParticipacaoSocialConselho', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbRepresentanteConselhos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbRepresentanteConselho', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function osc.tbLocalizacao()
    {
        return $this->hasOne('App\Models\Osc\Osc.tbLocalizacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbAreaAtuacaos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbAreaAtuacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function osc.tbContato()
    {
        return $this->hasOne('App\Models\Osc\Osc.tbContato', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbProjeto', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbRelacoesTrabalhoOutras()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbRelacoesTrabalhoOutra', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function portal.tbRepresentacaos()
    {
        return $this->hasMany('App\Models\Osc\Portal.tbRepresentacao', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbRecursosOutroOscs()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbRecursosOutroOsc', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbAreaAtuacaoOutras()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbAreaAtuacaoOutra', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function osc.tbOscParceiraProjetos()
    {
        return $this->hasMany('App\Models\Osc\Osc.tbOscParceiraProjeto', 'id_osc', 'id_osc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function portal.tbBarraTransparencium()
    {
        return $this->hasOne('App\Models\Osc\Portal.tbBarraTransparencium', 'id_osc', 'id_osc');
    }
}
