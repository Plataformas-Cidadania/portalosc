<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_usuario
 * @property int $cd_tipo_usuario
 * @property int $cd_municipio
 * @property int $cd_uf
 * @property string $tx_email_usuario
 * @property string $tx_senha_usuario
 * @property string $tx_nome_usuario
 * @property float $nr_cpf_usuario
 * @property boolean $bo_lista_email
 * @property boolean $bo_ativo
 * @property string $dt_cadastro
 * @property string $dt_atualizacao
 * @property boolean $bo_email_confirmado
 * @property string $tx_telefone_1
 * @property string $tx_telefone_2
 * @property string $tx_orgao_trabalha
 * @property string $tx_dado_institucional
 * @property string $tx_email_confirmacao
 * @property boolean $bo_lista_atualizacao_anual
 * @property boolean $bo_lista_atualizacao_trimestral
 * @property Spat.edMunicipio $spat.edMunicipio
 * @property Syst.dcTipoUsuario $syst.dcTipoUsuario
 * @property Spat.edUf $spat.edUf
 * @property Portal.tbToken[] $portal.tbTokens
 * @property Portal.tbRepresentacao[] $portal.tbRepresentacaos
 */
class Usuario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'portal.tb_usuario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * @var array
     */
    protected $fillable = ['cd_tipo_usuario', 'cd_municipio', 'cd_uf', 'tx_email_usuario', 'tx_senha_usuario', 'tx_nome_usuario', 'nr_cpf_usuario', 'bo_lista_email', 'bo_ativo', 'dt_cadastro', 'dt_atualizacao', 'bo_email_confirmado', 'tx_telefone_1', 'tx_telefone_2', 'tx_orgao_trabalha', 'tx_dado_institucional', 'tx_email_confirmacao', 'bo_lista_atualizacao_anual', 'bo_lista_atualizacao_trimestral'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function municipio()
    {
        return $this->belongsTo('App\Models\Spat\Municipio', 'cd_municipio', 'edmu_cd_municipio');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoUsuario()
    {
        return $this->belongsTo('App\Models\Syst\TipoUsuario', 'cd_tipo_usuario', 'cd_tipo_usuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function uf()
    {
        return $this->belongsTo('App\Models\Spat\Uf', 'cd_uf', 'eduf_cd_uf');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tokens()
    {
        return $this->hasMany('App\Models\Portal\Token', 'id_usuario', 'id_usuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function representacoes()
    {
        return $this->hasMany('App\Models\Portal\Representacao', 'id_usuario', 'id_usuario');
    }
}
