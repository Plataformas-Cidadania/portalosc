<?php

namespace App\Models\Graph;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_tb_rais
 * @property integer $id_estab
 * @property int $codemun
 * @property string $nm_mun
 * @property int $uf
 * @property string $nm_uf
 * @property int $regiao
 * @property string $nm_regiao
 * @property string $secao_cnae20
 * @property int $div_cnae20
 * @property int $grp_cnae20
 * @property int $clas_cnae20
 * @property int $sbcl_cnae20
 * @property int $nat_jur
 * @property string $razao_social
 * @property int $tamestab
 * @property int $tamestab2
 * @property int $qtd_vinc_ativos
 * @property int $qtd_portador_defic
 * @property string $data_abertura
 * @property string $data_encerramento
 * @property string $data_baixa
 * @property int $ind_atividade
 * @property int $ind_rais_neg
 * @property int $ind_osc
 * @property int $ano_abertura
 * @property int $ano_rais
 * @property string $nat_jur_corrigido
 * @property string $sbcl_cnae_corrigido
 * @property int $in_cnis16
 * @property int $ano_true
 * @property string $div_cnae20_corrigido
 * @property string $grp_cnae20_corrigido
 * @property string $clas_cnae20_corrigido
 * @property string $secao_cnae20_corrigido
 * @property string $micro_area_atuacao
 * @property string $macro_area_atuacao
 */
class Rais extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'graph.tb_rais';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_tb_rais';

    /**
     * @var array
     */
    protected $fillable = ['id_estab', 'codemun', 'nm_mun', 'uf', 'nm_uf', 'regiao', 'nm_regiao', 'secao_cnae20', 'div_cnae20', 'grp_cnae20', 'clas_cnae20', 'sbcl_cnae20', 'nat_jur', 'razao_social', 'tamestab', 'tamestab2', 'qtd_vinc_ativos', 'qtd_portador_defic', 'data_abertura', 'data_encerramento', 'data_baixa', 'ind_atividade', 'ind_rais_neg', 'ind_osc', 'ano_abertura', 'ano_rais', 'nat_jur_corrigido', 'sbcl_cnae_corrigido', 'in_cnis16', 'ano_true', 'div_cnae20_corrigido', 'grp_cnae20_corrigido', 'clas_cnae20_corrigido', 'secao_cnae20_corrigido', 'micro_area_atuacao', 'macro_area_atuacao'];

}
