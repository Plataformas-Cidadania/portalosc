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
    public function ipeadata.tbIpeadatas()
    {
        return $this->hasMany('App\Models\IpeaData\Ipeadata.tbIpeadatum', 'cd_indice', 'cd_indice');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ipeadata.tbIpeadataUfs()
    {
        return $this->hasMany('App\Models\IpeaData\Ipeadata.tbIpeadataUf', 'cd_indice', 'cd_indice');
    }
}
