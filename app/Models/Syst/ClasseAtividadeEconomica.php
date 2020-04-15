<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $cd_classe_atividade_economica
 * @property string $tx_nome_classe_atividade_economica
 * @property Syst.dcSubclasseAtividadeEconomica[] $syst.dcSubclasseAtividadeEconomicas
 */
class ClasseAtividadeEconomica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_classe_atividade_economica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_classe_atividade_economica';

    /**
     * The "type" of the auto-incrementing ID.
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
    protected $fillable = ['tx_nome_classe_atividade_economica'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function SubclasseAtividadeEconomicas()
    {
        return $this->hasMany('App\Models\Syst\SubclasseAtividadeEconomica', 'cd_classe_atividade_economica', 'cd_classe_atividade_economica');
    }
}
