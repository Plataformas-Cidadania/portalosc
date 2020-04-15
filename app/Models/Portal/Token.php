<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_token
 * @property int $id_usuario
 * @property string $tx_token
 * @property string $dt_data_expiracao_token
 * @property Portal.tbUsuario $portal.tbUsuario
 */
class Token extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'portal.tb_token';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_token';

    /**
     * @var array
     */
    protected $fillable = ['id_usuario', 'tx_token', 'dt_data_expiracao_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Usuario()
    {
        return $this->belongsTo('App\Models\Portal\Usuario', 'id_usuario', 'id_usuario');
    }
}
