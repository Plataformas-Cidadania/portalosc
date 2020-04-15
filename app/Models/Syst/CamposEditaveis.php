<?php

namespace App\Models\Syst;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_campo
 * @property string $nome_campo
 * @property boolean $editavel
 */
class CamposEditaveis extends Model
{
    /**
     * The table associated with the model..
     * 
     * @var string
     */
    protected $table = 'syst.tb_campos_editaveis';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_campo';

    /**
     * @var array
     */
    protected $fillable = ['nome_campo', 'editavel'];

}
