<?php

namespace App\Models\Graph;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_cnes
 * @property string $nu_cnpj_requerente
 * @property string $no_pessoa
 * @property string $no_regiao
 * @property string $sg_uf
 * @property string $no_municipio
 * @property string $a_lei
 * @property string $tempestividade
 * @property string $nu_sipar
 * @property string $dt_protocolo
 * @property string $dt_protocolo_menor
 * @property string $assunto
 * @property string $cebas_atual
 * @property string $inicio_validade_anterior
 * @property string $fim_validade_anterior
 * @property string $cnes
 * @property string $co_cnes
 * @property string $nu_cnpj
 * @property string $nu_cnpj_mantenedora
 * @property string $no_razao_social
 * @property string $no_fantasia
 * @property string $regiao
 * @property string $uf
 * @property string $co_municipio
 * @property string $municipio
 * @property string $no_logradouro
 * @property string $nu_endereco
 * @property string $no_complemento
 * @property string $no_bairro
 * @property string $co_cep
 * @property string $co_natureza_jur
 * @property string $ds_natureza_juridica
 * @property string $ds_retencao_tributo
 * @property string $ds_motivo_desab
 * @property string $co_natureza_organizacao
 * @property string $ds_natureza_organizacao
 * @property string $co_esfera_administrativa
 * @property string $ds_esfera_administrativa
 * @property string $ds_tipo_unidade
 * @property string $ds_gestao
 * @property string $st_registro_ativo
 */
class Cnes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'graph.tb_cnes';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_cnes';

    /**
     * @var array
     */
    protected $fillable = ['nu_cnpj_requerente', 'no_pessoa', 'no_regiao', 'sg_uf', 'no_municipio', 'a_lei', 'tempestividade', 'nu_sipar', 'dt_protocolo', 'dt_protocolo_menor', 'assunto', 'cebas_atual', 'inicio_validade_anterior', 'fim_validade_anterior', 'cnes', 'co_cnes', 'nu_cnpj', 'nu_cnpj_mantenedora', 'no_razao_social', 'no_fantasia', 'regiao', 'uf', 'co_municipio', 'municipio', 'no_logradouro', 'nu_endereco', 'no_complemento', 'no_bairro', 'co_cep', 'co_natureza_jur', 'ds_natureza_juridica', 'ds_retencao_tributo', 'ds_motivo_desab', 'co_natureza_organizacao', 'ds_natureza_organizacao', 'co_esfera_administrativa', 'ds_esfera_administrativa', 'ds_tipo_unidade', 'ds_gestao', 'st_registro_ativo'];

}
