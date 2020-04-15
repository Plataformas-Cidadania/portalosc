<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_osc
 * @property string $tx_telefone
 * @property string $ft_telefone
 * @property string $tx_email
 * @property string $ft_email
 * @property string $nm_representante
 * @property string $ft_representante
 * @property string $tx_site
 * @property string $ft_site
 * @property string $tx_facebook
 * @property string $ft_facebook
 * @property string $tx_google
 * @property string $ft_google
 * @property string $tx_linkedin
 * @property string $ft_linkedin
 * @property string $tx_twitter
 * @property string $ft_twitter
 * @property boolean $bo_nao_possui_email
 * @property boolean $bo_nao_possui_site
 * @property Osc.tbOsc $osc.tbOsc
 */
class Contato extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_contato';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_osc';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['tx_telefone', 'ft_telefone', 'tx_email', 'ft_email', 'nm_representante', 'ft_representante', 'tx_site', 'ft_site', 'tx_facebook', 'ft_facebook', 'tx_google', 'ft_google', 'tx_linkedin', 'ft_linkedin', 'tx_twitter', 'ft_twitter', 'bo_nao_possui_email', 'bo_nao_possui_site'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
