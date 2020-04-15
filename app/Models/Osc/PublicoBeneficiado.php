<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_publico_beneficiado
 * @property string $tx_nome_publico_beneficiado
 * @property string $ft_publico_beneficiado
 */
class PublicoBeneficiado extends Model
{
    /**
     * The table associated with the model..
     * 
     * @var string
     */
    protected $table = 'osc.tb_publico_beneficiado';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_publico_beneficiado';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_publico_beneficiado', 'ft_publico_beneficiado'];

}
