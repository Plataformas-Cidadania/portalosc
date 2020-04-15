<?php

namespace App\Models\IpeaData;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $cd_indice
 * @property string $tx_nome_indice
 * @property string $tx_sigla
 * @property string $tx_tema
 * @property Ipeadata.tbIpeadatum[] $ipeadata.tbIpeadatas
 * @property Ipeadata.tbIpeadataUf[] $ipeadata.tbIpeadataUfs
 */
class Indice extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ipeadata.tb_indice';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'cd_indice';

    /**
     * @var array
     */
    protected $fillable = ['tx_nome_indice', 'tx_sigla', 'tx_tema'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Ipeadatas()
    {
        return $this->hasMany('App\Models\IpeaData\IpeaData', 'cd_indice', 'cd_indice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function IpeadataUfs()
    {
        return $this->hasMany('App\Models\IpeaData\IpeaDataUf', 'cd_indice', 'cd_indice');
    }
}
