<?php

namespace App\Models\Graph;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_senaes
 * @property string $nom_1
 * @property string $end_2
 * @property string $bai_3
 * @property string $cep_3
 * @property string $cod_munic
 * @property string $mun_4
 * @property string $uf
 * @property string $micro_reg
 * @property string $ema_6
 * @property string $con_7
 * @property string $cnpj_8
 * @property string $tem_cnpj
 * @property string $nat_9
 * @property string $nat_9_or
 * @property string $vin_10
 * @property string $red_11
 * @property string $red_11_or
 * @property string $atu_12_a
 * @property string $atu_12_b
 * @property string $atu_12_c
 * @property string $atu_12_d
 * @property string $atu_12_e
 * @property string $atu_12_f
 * @property string $atu_12_o
 * @property string $atu_12_or
 * @property string $abr_13
 * @property string $abr_13_2_1
 * @property string $abr_13_2_2
 * @property string $abr_13_2_3
 * @property string $abr_13_2_4
 * @property string $abr_13_2_5
 * @property string $abr_13_2_6
 * @property string $abr_13_2_7
 * @property string $num_uf
 * @property string $abr_13_3_1
 * @property string $abr_13_3_2
 * @property string $abr_13_3_3
 * @property string $abr_13_3_4
 * @property string $abr_13_3_5
 * @property string $abr_13_3_6
 * @property string $abr_13_3_7
 * @property string $abr_13_3_8
 * @property string $abr_13_3_9
 * @property string $abr_13_3_10
 * @property string $abr_13_3_11
 * @property string $abr_13_3_12
 * @property string $abr_13_3_13
 * @property string $abr_13_3_14
 * @property string $abr_13_3_15
 * @property string $abr_13_3_16
 * @property string $abr_13_3_17
 * @property string $abr_13_3_18
 * @property string $abr_13_3_19
 * @property string $abr_13_3_20
 * @property string $abr_13_3_21
 * @property string $abr_13_3_22
 * @property string $abr_13_3_23
 * @property string $abr_13_3_24
 * @property string $abr_13_3_25
 * @property string $abr_13_3_26
 * @property string $abr_13_3_27
 * @property string $abr_13_3_28
 * @property string $abr_13_3_29
 * @property string $abr_13_3_30
 * @property string $abr_13_3_31
 * @property string $abr_13_3_32
 * @property string $abr_13_3_33
 * @property string $abr_13_3_34
 * @property string $abr_13_3_35
 * @property string $num_mun
 * @property string $resp
 * @property string $data_cad
 * @property string $website
 * @property string $auto_declarado
 * @property string $auto_declarado_atualizacao
 * @property string $ano_declaracao
 * @property string $num_fone_1
 * @property string $num_fone_2
 * @property string $num_fone_3
 * @property string $num_fone_4
 * @property string $num_fone_5
 * @property string $num_fone_6
 * @property string $ddd_1
 * @property string $ddd_2
 * @property string $ddd_3
 * @property string $ddd_4
 * @property string $ddd_5
 * @property string $ddd_6
 * @property string $tipo_fone_1
 * @property string $tipo_fone_2
 * @property string $tipo_fone_3
 * @property string $tipo_fone_4
 * @property string $tipo_fone_5
 * @property string $tipo_fone_6
 */
class Senaes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'graph.tb_senaes';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_senaes';

    /**
     * @var array
     */
    protected $fillable = ['nom_1', 'end_2', 'bai_3', 'cep_3', 'cod_munic', 'mun_4', 'uf', 'micro_reg', 'ema_6', 'con_7', 'cnpj_8', 'tem_cnpj', 'nat_9', 'nat_9_or', 'vin_10', 'red_11', 'red_11_or', 'atu_12_a', 'atu_12_b', 'atu_12_c', 'atu_12_d', 'atu_12_e', 'atu_12_f', 'atu_12_o', 'atu_12_or', 'abr_13', 'abr_13_2_1', 'abr_13_2_2', 'abr_13_2_3', 'abr_13_2_4', 'abr_13_2_5', 'abr_13_2_6', 'abr_13_2_7', 'num_uf', 'abr_13_3_1', 'abr_13_3_2', 'abr_13_3_3', 'abr_13_3_4', 'abr_13_3_5', 'abr_13_3_6', 'abr_13_3_7', 'abr_13_3_8', 'abr_13_3_9', 'abr_13_3_10', 'abr_13_3_11', 'abr_13_3_12', 'abr_13_3_13', 'abr_13_3_14', 'abr_13_3_15', 'abr_13_3_16', 'abr_13_3_17', 'abr_13_3_18', 'abr_13_3_19', 'abr_13_3_20', 'abr_13_3_21', 'abr_13_3_22', 'abr_13_3_23', 'abr_13_3_24', 'abr_13_3_25', 'abr_13_3_26', 'abr_13_3_27', 'abr_13_3_28', 'abr_13_3_29', 'abr_13_3_30', 'abr_13_3_31', 'abr_13_3_32', 'abr_13_3_33', 'abr_13_3_34', 'abr_13_3_35', 'num_mun', 'resp', 'data_cad', 'website', 'auto_declarado', 'auto_declarado_atualizacao', 'ano_declaracao', 'num_fone_1', 'num_fone_2', 'num_fone_3', 'num_fone_4', 'num_fone_5', 'num_fone_6', 'ddd_1', 'ddd_2', 'ddd_3', 'ddd_4', 'ddd_5', 'ddd_6', 'tipo_fone_1', 'tipo_fone_2', 'tipo_fone_3', 'tipo_fone_4', 'tipo_fone_5', 'tipo_fone_6'];

}
