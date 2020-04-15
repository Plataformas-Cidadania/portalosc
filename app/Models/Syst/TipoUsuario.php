<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_tipo_usuario
 * @property string $tx_nome_tipo_usuario
 * @property Portal.tbUsuario[] $portal.tbUsuarios
 */
class TipoUsuario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_tipo_usuario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_tipo_usuario';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_tipo_usuario'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Usuarios()
    {
        return $this->hasMany('App\Models\Portal\Usuario', 'cd_tipo_usuario', 'cd_tipo_usuario');
    }
}
