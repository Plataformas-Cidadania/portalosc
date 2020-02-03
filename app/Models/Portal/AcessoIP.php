<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $tx_ip
 * @property string $dt_data_expiracao
 * @property int $nr_quantidade_acessos
 */
class AcessoIP extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'portal.tb_acesso_ip';

    /**
     * @var array
     */
    protected $fillable = ['tx_ip', 'dt_data_expiracao', 'nr_quantidade_acessos'];

}
