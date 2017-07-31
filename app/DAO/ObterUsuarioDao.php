<?php

namespace App\Dao;

use App\Enums\TipoUsuarioEnum;
use App\Modules\Usuario\Models\RepresentanteOscModel;
use App\Modules\Usuario\Models\RepresentanteGovernoMunicipioModel;
use App\Modules\Usuario\Models\RepresentanteGovernoEstadoModel;
use App\Modules\Osc\Models\OscModel;
use App\Modules\Geografico\Models\MunicipioModel;
use App\Modules\Geografico\Models\EstadoModel;
use App\Dao\Dao;

class ObterUsuarioDao extends Dao
{
    private $requisicao;
    private $resposta;
    
    public function executar($usuario)
    {
        $query = 'SELECT tb_usuario.tx_email_usuario,
						tb_usuario.cd_tipo_usuario,
						tb_usuario.tx_nome_usuario,
                        tb_usuario.nr_cpf_usuario,
        				tb_usuario.cd_municipio,
        				tb_usuario.cd_uf,
						tb_usuario.bo_ativo
					FROM
						portal.tb_usuario
					WHERE
						id_usuario = ?::INTEGER;';
        
        $params = [$usuario->getId()];
        $resultadoDao = $this->executarQuery($query, true, $params);
        
        if($resultadoDao){
            $usuario->prepararObjeto($resultadoDao);
            
            if($usuario->getTipoUsuario() == TipoUsuarioEnum::OSC){
                $usuario = $this->carregarRepresentanteOsc($usuario);
            }else if($usuario->getTipoUsuario() == TipoUsuarioEnum::GOVERNO_MUNICIPAL){
                $usuario = $this->carregarRepresentanteGovernoMunicipio($usuario);
                $usuario->setCodigo($resultadoDao->cd_municipio);
            }else if($usuario->getTipoUsuario() == TipoUsuarioEnum::GOVERNO_ESTADUAL){
                $usuario = $this->carregarRepresentanteGovernoEstado($usuario);
                $usuario->setCodigo($resultadoDao->cd_uf);
            }
        }else{
            $usuario = null;
        }
        
        return $usuario;
    }
    
    private function carregarRepresentanteOsc($usuario)
    {
        $representanteOscModel = new RepresentanteOscModel();
        $representanteOscModel->clone($usuario);
        
        $query = 'SELECT id_osc FROM portal.tb_representacao WHERE id_usuario = ?::INTEGER;';
        $params = [$representanteOscModel->getId()];
        $resultadoDao = $this->executarQuery($query, false, $params);
        
        if($resultadoDao){
            foreach($resultadoDao as $value){
                $representanteOscModel->addOsc($this->carregarOsc($value));
            }
        }
        
        return $representanteOscModel;
    }
    
    private function carregarRepresentanteGovernoMunicipio($usuario)
    {
        $representanteGovernoMunicipioModel = new RepresentanteGovernoMunicipioModel();
        $representanteGovernoMunicipioModel->clone($usuario);
        
        return $representanteGovernoMunicipioModel;
    }
    
    private function carregarRepresentanteGovernoEstado($usuario)
    {
        $representanteGovernoEstadoModel = new RepresentanteGovernoEstadoModel();
        $representanteGovernoEstadoModel->clone($usuario);
        
        return $representanteGovernoEstadoModel;
    }
    
    private function carregarOsc($osc)
    {
        $oscModel = new OscModel();
        $oscModel->prepararObjeto($osc);
        
        $query = 'SELECT tx_nome_osc FROM portal.vw_osc_dados_gerais WHERE id_osc = ?::INTEGER;';
        $params = [$oscModel->getId()];
        $resultadoDao = $this->executarQuery($query, true, $params);
        
        if($resultadoDao){
            $oscModel->setNome($resultadoDao->tx_nome_osc);
        }
        
        return $oscModel;
    }
    
    private function carregarMunicipio($osc)
    {
        $municipioModel = new MunicipioModel();
        $municipioModel->prepararObjeto($osc);
        
        $query = 'SELECT tx_nome_osc FROM portal.vw_spat_municipio WHERE edmu_cd_municipio = ?::INTEGER;';
        $params = [$municipioModel->getId()];
        $resultadoDao = $this->executarQuery($query, true, $params);
        
        if($resultadoDao){
            $oscModel->setNome($resultadoDao->tx_nome_osc);
        }
        
        return $oscModel;
    }
    
    private function carregarEstado($osc)
    {
        $estadoModel = new EstadoModel();
        $estadoModel->prepararObjeto($osc);
        
        $query = 'SELECT tx_nome_osc FROM portal.vw_spat_estado WHERE eduf_cd_uf = ?::INTEGER;';
        $params = [$estadoModel->getId()];
        $resultadoDao = $this->executarQuery($query, true, $params);
        
        if($resultadoDao){
            $oscModel->setNome($resultadoDao->tx_nome_osc);
        }
        
        return $oscModel;
    }
}
