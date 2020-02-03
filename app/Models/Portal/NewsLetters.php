<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_newsletters
 * @property string $tx_nome_assinante
 * @property string $tx_email_assinante
 */
class NewsLetters extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'portal.tb_newsletters';

    /**
     * @var array
     */
    protected $fillable = ['id_newsletters', 'tx_nome_assinante', 'tx_email_assinante'];

}
