<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_conferencia_declarada
 * @property string $tx_nome_conferencia_declarada
 * @property string $ft_conferencia_declarada
 */
class ConferenciaDeclarada extends Model
{
    /**
     * The table associated with the model..
     * 
     * @var string
     */
    protected $table = 'osc.tb_conferencia_declarada';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_conferencia_declarada';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_conferencia_declarada', 'ft_conferencia_declarada'];

}
