<?php

namespace App\Models\Osc;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_osc
 * @property int $cd_fonte_geocodificacao
 * @property string $tx_endereco
 * @property string $ft_endereco
 * @property string $nr_localizacao
 * @property string $ft_localizacao
 * @property string $tx_endereco_complemento
 * @property string $ft_endereco_complemento
 * @property string $tx_bairro
 * @property string $ft_bairro
 * @property float $cd_municipio
 * @property string $ft_municipio
 * @property mixed $geo_localizacao
 * @property string $ft_geo_localizacao
 * @property float $nr_cep
 * @property string $ft_cep
 * @property string $tx_endereco_corrigido
 * @property string $ft_endereco_corrigido
 * @property string $tx_bairro_encontrado
 * @property string $ft_bairro_encontrado
 * @property string $ft_fonte_geocodificacao
 * @property string $dt_geocodificacao
 * @property string $ft_data_geocodificacao
 * @property boolean $bo_oficial
 * @property string $qualidade_classificacao
 * @property Syst.dcFonteGeocodificacao $syst.dcFonteGeocodificacao
 * @property Osc.tbOsc $osc.tbOsc
 */
class Localizacao extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'osc.tb_localizacao';

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
    protected $fillable = ['cd_fonte_geocodificacao', 'tx_endereco', 'ft_endereco', 'nr_localizacao', 'ft_localizacao', 'tx_endereco_complemento', 'ft_endereco_complemento', 'tx_bairro', 'ft_bairro', 'cd_municipio', 'ft_municipio', 'geo_localizacao', 'ft_geo_localizacao', 'nr_cep', 'ft_cep', 'tx_endereco_corrigido', 'ft_endereco_corrigido', 'tx_bairro_encontrado', 'ft_bairro_encontrado', 'ft_fonte_geocodificacao', 'dt_geocodificacao', 'ft_data_geocodificacao', 'bo_oficial', 'qualidade_classificacao'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function FonteGeocodificacao()
    {
        return $this->belongsTo('App\Models\Syst\FonteGeocodificacao', 'cd_fonte_geocodificacao', 'cd_fonte_geocodoficacao');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Osc()
    {
        return $this->belongsTo('App\Models\Osc\Osc', 'id_osc', 'id_osc');
    }
}
