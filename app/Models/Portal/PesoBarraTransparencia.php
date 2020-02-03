<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_peso_barra_transparencia
 * @property string $nome_secao
 * @property float $peso_secao
 */
class PesoBarraTransparencia extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'portal.tb_peso_barra_transparencia';

    /**
     * @var array
     */
    protected $fillable = ['id_peso_barra_transparencia', 'nome_secao', 'peso_secao'];

}
