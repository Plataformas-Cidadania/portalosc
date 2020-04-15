<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $cd_sigla_fonte_dados
 * @property string $tx_nome_fonte_dados
 * @property string $tx_descricao_fonte_dados
 * @property string $tx_referencia_fonte_dados
 * @property int $nr_prioridade
 */
class FonteDados extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_fonte_dados';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_sigla_fonte_dados';

    /**
     * The "type" of the auto-incrementing ID..
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_fonte_dados', 'tx_descricao_fonte_dados', 'tx_referencia_fonte_dados', 'nr_prioridade'];

}
