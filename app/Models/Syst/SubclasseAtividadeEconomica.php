<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property float $cd_subclasse_atividade_economica
 * @property string $cd_classe_atividade_economica
 * @property string $tx_nome_subclasse_atividade_economica
 * @property Syst.dcClasseAtividadeEconomica $syst.dcClasseAtividadeEconomica
 */
class SubclasseAtividadeEconomica extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'syst.dc_subclasse_atividade_economica';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_subclasse_atividade_economica';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'float';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['cd_classe_atividade_economica', 'tx_nome_subclasse_atividade_economica'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ClasseAtividadeEconomica()
    {
        return $this->belongsTo('App\Models\Syst\ClasseAtividadeEconomica', 'cd_classe_atividade_economica', 'cd_classe_atividade_economica');
    }
}
