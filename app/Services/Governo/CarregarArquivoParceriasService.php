<?php

namespace App\Services\Governo;

use App\Enums\NomenclaturaAtributoEnum;
use App\Services\Service;
use App\Services\Model;
use App\Dao\GovernoDao;
use App\Enums\TipoUsuarioEnum;

class CarregarArquivoParceriasService extends Service
{
	public function executar()
	{
	    $dataHora = date("d-m-Y H:i:s");
	    
	    $usuario = $this->requisicao->getUsuario();
	    if($usuario->tipo_usuario == TipoUsuarioEnum::ADMINISTRADOR){
			$contrato = [
				'arquivo' => ['apelidos' => NomenclaturaAtributoEnum::ARQUIVO, 'obrigatorio' => true, 'tipo' => 'arquivo'],
				'tipo_arquivo' => ['apelidos' => NomenclaturaAtributoEnum::TIPO_ARQUIVO, 'obrigatorio' => true, 'tipo' => 'string'],
				'localidade' => ['apelidos' => NomenclaturaAtributoEnum::LOCALIDADE, 'obrigatorio' => true, 'tipo' => 'integer'],
				'dicionario' => ['apelidos' => NomenclaturaAtributoEnum::DICIONARIO, 'obrigatorio' => false, 'tipo' => 'array']
			];
	    }else{
	    	$contrato = [
	    			'arquivo' => ['apelidos' => NomenclaturaAtributoEnum::ARQUIVO, 'obrigatorio' => true, 'tipo' => 'arquivo'],
	    			'tipo_arquivo' => ['apelidos' => NomenclaturaAtributoEnum::TIPO_ARQUIVO, 'obrigatorio' => true, 'tipo' => 'string'],
	    			'dicionario' => ['apelidos' => NomenclaturaAtributoEnum::DICIONARIO, 'obrigatorio' => false, 'tipo' => 'array']
	    	];
	    }
		
		$model = new Model($contrato, $this->requisicao->getConteudo());
		$flagModel = $this->analisarModel($model);
		
		if($flagModel){
			$requisicao = $model->getRequisicao();
			
			$dicionario = new \stdClass();
			if($requisicao->dicionario){
				$dicionario = json_decode($requisicao->dicionario);
			}
			
			if(!property_exists($dicionario, 'numero_parceria')) $dicionario->numero_parceria = 'numero_parceria';
			if(!property_exists($dicionario, 'cnpj_proponente')) $dicionario->cnpj_proponente = 'cnpj_proponente';
			if(!property_exists($dicionario, 'data_inicio')) $dicionario->data_inicio = 'data_inicio';
			if(!property_exists($dicionario, 'data_conclusao')) $dicionario->data_conclusao = 'data_conclusao';
			if(!property_exists($dicionario, 'tipo_parceria')) $dicionario->tipo_parceria = 'tipo_parceria';
			if(!property_exists($dicionario, 'valor_total')) $dicionario->valor_total = 'valor_total';
			if(!property_exists($dicionario, 'valor_pago')) $dicionario->valor_pago = 'valor_pago';
			if(!property_exists($dicionario, 'orgao_concedente')) $dicionario->orgao_concedente = 'orgao_concedente';
			if(!property_exists($dicionario, 'razao_social_proponente')) $dicionario->razao_social_proponente = 'razao_social_proponente';
			if(!property_exists($dicionario, 'nome_fantasia_proponente')) $dicionario->nome_fantasia_proponente = 'nome_fantasia_proponente';
			if(!property_exists($dicionario, 'municipio_proponente')) $dicionario->municipio_proponente = 'municipio_proponente';
			if(!property_exists($dicionario, 'endereco_proponente')) $dicionario->endereco_proponente = 'endereco_proponente';
			if(!property_exists($dicionario, 'objeto_parceria')) $dicionario->objeto_parceria = 'objeto_parceria';
			if(!property_exists($dicionario, 'situacao_parceria')) $dicionario->situacao_parceria = 'situacao_parceria';
			
			$enderecoArquivo = $requisicao->arquivo->getPathName();
			$flagTipoArquivo = $this->verificarTipoArquivo($enderecoArquivo);
			
			if($flagTipoArquivo){
    			$dados = $this->carregarDados($requisicao->tipo_arquivo, $enderecoArquivo, $dicionario);
    			
    			if($dados){
    	        	$dadosValidados = $this->validarDados($dados, $dicionario);
    	        	
    	            if($dadosValidados){
    	            	if(env('UPLOAD_FILE_PATH') == null){
    	            		$diretorioArquivo = realpath(__DIR__ . '/../../../') . '/storage/app/gov/' . $usuario->id_usuario . '/';
    					}else{
    					    $diretorioArquivo = env('UPLOAD_FILE_PATH') . '/' . $usuario->id_usuario . '/';
    					}
    					
    					$assinatura = new \stdClass();
    					$assinatura->data = $dataHora;
    					$assinatura->nome_arquivo = $requisicao->arquivo->getClientOriginalName();
    					$assinatura->hash = md5(serialize($dados));
    					$assinatura->usuario = $usuario->id_usuario;
    					
    					if($usuario->tipo_usuario == TipoUsuarioEnum::ADMINISTRADOR){
    						if(strlen($requisicao->localidade) == 2){
    							$assinatura->fonte_recursos = 'Governo estadual';
    						}else if(strlen($requisicao->localidade) == 6 || strlen($requisicao->localidade) == 7){
    							$assinatura->fonte_recursos = 'Governo municipal';
    						}
    						
    						$assinatura->localidade = substr($requisicao->localidade, 0, 6);
    					}else{
    						if($usuario->tipo_usuario == TipoUsuarioEnum::GOVERNO_MUNICIPAL){
    							$assinatura->fonte_recursos = 'Governo municipal';
    						}else if($usuario->tipo_usuario == TipoUsuarioEnum::GOVERNO_ESTADUAL){
    							$assinatura->fonte_recursos = 'Governo estadual';
    						}
    						
	    					$assinatura->localidade = substr($usuario->localidade, 0, 6);
    					}
    					
    					$dados = $this->prepararDados($dados, $assinatura, $dicionario);
    					
    	            	$flagDao = true;
    	            	foreach($dados as $dado){
    	            		try{
    	            		    $resultadoDao = (new GovernoDao())->inserirParceria((array) $dado);
    	            		}catch(\Exception $e){
    	            			$mensagem = 'Ocorreu um erro na gravação de dados no banco de dados.';
    	            			
    	            			if($e->getCode() == 13053){
    	            				$mensagem = 'Ocorreu um erro na conexão com o banco de dados.';
    	            			}
    	            			
    	            			$this->resposta->prepararResposta(['msg' => $mensagem], 500);
    	            			$flagDao = false;
    	            			break;
    					    }
    	            	}
    	            	
    	            	if($flagDao){
    	            		$this->resposta->prepararResposta(['msg' => 'Upload do arquivo realiado com sucesso.'], 200);
    	            	}else{
    	            	    $nomeArquivo = time() . '.json';
    	            	    
    	            	    if(!file_exists($diretorioArquivo)) {
    	            	        mkdir($diretorioArquivo, 0644, true);
    	            	    }
    	            	    
    	            	    try{
    	            	        $dadosJson = json_encode($dados, JSON_UNESCAPED_UNICODE);
    	            	        
    	            	        if($dadosJson){
        	            	        $fp = fopen($diretorioArquivo . $nomeArquivo, 'w');
        	            	        fwrite($fp, $dadosJson);
            	            		fclose($fp);
            	            		
            	            		$this->resposta->prepararResposta(['msg' => 'Upload do arquivo realiado com sucesso.'], 200);
    	            	        }else{
    	            	            $this->resposta->prepararResposta(['msg' => 'Ocorreu um erro na preparação dos dados.'], 200);
    	            	        }
    	            	    }catch(\Exception $e){
    	            	        $mensagem = 'Ocorreu um erro no carregamento dos dados.';
    	            	        $this->resposta->prepararResposta(['msg' => $mensagem], 500);
    	            	    }
    	            	}
    				}
    			}
			}
			
			if(file_exists($enderecoArquivo)){
            	unlink($enderecoArquivo);
			}
		}
	}
	
	private function verificarTipoArquivo($enderecoArquivo)
	{
	    $resultado = false;
	    
	    $finfo = finfo_open(FILEINFO_MIME);
	    $tipoArquivo = substr(finfo_file($finfo, $enderecoArquivo), 0, 4);
	    
	    if($tipoArquivo == 'text'){
	        $resultado = true;
	    }else{
	        $mensagem = 'Arquivo inválido.';
	        $this->resposta->prepararResposta(['msg' => $mensagem], 400);
	    }
	    
	    return $resultado;
	}
    
    private function carregarDados($tipo_arquivo, $enderecoArquivo, $dicionario)
    {
    	$dados = null;
    	
    	switch($tipo_arquivo) {
    		case 'csv':
    			$dadosCsv = $this->carregarCsv($enderecoArquivo, $dicionario);
    			if($dadosCsv){
    				$dados = $this->converterCsv($dadosCsv);
    			}
    			
    			break;
    			
    		case 'json':
    		    $dados = $this->carregarJson($enderecoArquivo, $dicionario);
    		    
    		    if($dados == null){
    		        $this->resposta->prepararResposta(['msg' => 'Ocorreu um erro na leitura dos dados. Verifique a formatação dos dados enviados no arquivo.'], 400);
    		    }
    		    
    			break;
    			
    		default:
    			$this->resposta->prepararResposta(['msg' => 'Formato de arquivo inválido.'], 400);
    	}
    	
    	return $dados;
    }
    
    private function ajustarDado($dado){
    	$dado = $this->removerUtf8Bom($dado);
    	$dado = trim($dado);
    	
    	$dado = rtrim($dado, '\'');
    	$dado = ltrim($dado, '\'');
    	$dado = rtrim($dado, '"');
    	$dado = ltrim($dado, '"');
    	
    	return $dado;
    }
    
    private function removerUtf8Bom($dado)
    {
    	$bom = pack('H*','EFBBBF');
    	return preg_replace("/^$bom/", '', $dado);
    }
    
    private function carregarCsv($enderecoArquivo, $dicionario){
    	$resultado = array();
    	$delimitador = ';';
    	
    	$dados = file($enderecoArquivo);
    	$titulos = explode($delimitador, $dados[0]);
    	
    	$flagDadosObrigatorios = $this->verificarDadosObrigatoriosCsv($titulos, $dicionario);
    	if($flagDadosObrigatorios){
	    	foreach ($dados as $value){
	    		array_push($resultado, explode($delimitador, trim($value)));
	    	}
    	}
    	
    	return $resultado;
    }
    
    private function carregarJson($enderecoArquivo, $dicionario){
    	$resultado = array();
    	
    	$dado = file_get_contents($enderecoArquivo);
    	$dado = json_decode($dado);
    	
    	if(is_object($dado)){
    		$resultado = $dado->parcerias;
    	}else if(is_array($dado)){
    		$resultado = $dado;
    	}
    	
    	return $resultado;
    }
    
    private function verificarDadosObrigatoriosCsv($title, $dicionario){
    	$resultado = false;
    	
    	$titulos = array();
    	foreach ($title as $key => $value){
    		array_push($titulos, $this->ajustarDado($value));
    	}
    	
    	$obrigatorios = [$dicionario->numero_parceria, $dicionario->cnpj_proponente, $dicionario->data_inicio, $dicionario->data_conclusao, $dicionario->tipo_parceria, $dicionario->valor_total, $dicionario->valor_pago];
    	
    	$flagObrigatorios = count(array_intersect($titulos, $obrigatorios)) == count($obrigatorios);
    	
    	if($flagObrigatorios){
    		$resultado = true;
    	}else{
    		$this->resposta->prepararResposta(['msg' => 'Dados obrigatórios não enviados.'], 400);
    	}
    	
    	return $resultado;
    }
    
    private function converterCsv($dados){
    	$resultado = array();
    	
    	$titulos = array();
    	foreach ($dados[0] as $value){
    		array_push($titulos, $this->ajustarDado($value));
    	}
    	unset($dados[0]);
    	
    	foreach ($dados as $dado){
	    	$array = array();
	    	foreach ($dado as $key => $value){
	    		$key = $this->ajustarDado($key);
	    		$value = $this->ajustarDado($value);
	    		$array[$titulos[$key]] = $value;
	    	}
	    	array_push($resultado, (object) $array);
	    }
	    
	    return $resultado;
    }
    
    private function verificarDadosObrigatoriosJson($dados, $dicionario){
        $resultado = true;
        
        if(!property_exists($dados, $dicionario->numero_parceria)){
            $resultado = false;
        }
        
        if(!property_exists($dados, $dicionario->cnpj_proponente)){
            $resultado = false;
        }
        
        if(!property_exists($dados, $dicionario->data_inicio)){
            $resultado = false;
        }
        
        if(!property_exists($dados, $dicionario->data_conclusao)){
            $resultado = false;
        }
        
        if(!property_exists($dados, $dicionario->tipo_parceria)){
            $resultado = false;
        }
        
        if(!property_exists($dados, $dicionario->valor_total)){
            $resultado = false;
        }
        
        if(!property_exists($dados, $dicionario->valor_pago)){
            $resultado = false;
        }
        
        return $resultado;
    }
    
    private function validarDados($data, $dicionario){
    	$resultado = true;
    	
    	$separatorDate = '(\/|-|\.)';
    	$patternDate = '/^(?:(?:31'.$separatorDate.'(?:0?[13578]|1[02]))\1|(?:(?:29|30)'.$separatorDate.'(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{4})$|^(?:29'.$separatorDate.'0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])'.$separatorDate.'(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{4})$/';
    	
    	$separatorCnpj = '(\/|-|\.)';
    	$patternCnpj = '/^(([0-9]{2})'.$separatorCnpj.'?([0-9]{3})'.$separatorCnpj.'?([0-9]{3})'.$separatorCnpj.'?([0-9]{4})('.$separatorCnpj.'?([0-9]{0,2})?))$/';
    	
    	$currencySymbol = '(([Rr]{1}[$]{1})|([$]{1}))?([ ]*)?';
    	$patternCurrency = '/^(('.$currencySymbol.'(\d{1,3}(?:[\.]?\d{3})*)([,]{1}\d{2})?)|('.$currencySymbol.'(\d*)([\.]{1})(\d{1,2})?))$/';
    	
    	$invalidLineData = array();
    	foreach($data as $key => $value){
    	    $flagDadosObrigatorios = $this->verificarDadosObrigatoriosJson($value, $dicionario);
    	    
    	    $error = array();
    	    
    	    if($flagDadosObrigatorios){
        	    $cnpj = str_replace(['/', '-', '.'], '', $value->{$dicionario->cnpj_proponente});
        	    
        		$checkDataInicio = preg_match_all($patternDate, $value->{$dicionario->data_inicio});
        		$checkDataConclusao = preg_match_all($patternDate, $value->{$dicionario->data_conclusao});
        		$checkCnpj = preg_match_all($patternCnpj, $cnpj);
        		$checkValorTotal = preg_match_all($patternCurrency, $value->{$dicionario->valor_total});
        		$checkValorPago = preg_match_all($patternCurrency, $value->{$dicionario->valor_pago});
        		
        		if(!$checkDataInicio){
        			array_push($error, 'Formatação do campo data_inicio está incorreta.');
        		}
        		
        		if(!$checkDataConclusao){
        			array_push($error, 'Formatação do campo data_conclusao está incorreta.');
        		}
        		
        		$data_inicio_ajustada = substr($value->{$dicionario->data_inicio}, -4) . '-' . substr($value->{$dicionario->data_inicio}, -7, 2) . '-' . substr($value->{$dicionario->data_inicio}, 0, 2);
        		$data_conclusao_ajustada = substr($value->{$dicionario->data_conclusao}, -4) . '-' . substr($value->{$dicionario->data_conclusao}, -7, 2) . '-' . substr($value->{$dicionario->data_conclusao}, 0, 2);
        		
    	    	if(strtotime($data_inicio_ajustada) >= strtotime($data_conclusao_ajustada)){
    	    		array_push($error, 'Os campos data_inicio e data_conclusao estão desconformes. A data informada no campo data_inicio deve ser anterior a data informada no campo data_conclusao.');
    	    	}
        		
        		if(!$checkCnpj){
        			array_push($error, 'Formatação do campo cnpj_proponente está incorreta.');
        		}
        		
        		if(!$checkValorTotal){
        			array_push($error, 'Formatação do campo valor_total está incorreta.');
        		}
        		
        		if(!$checkValorPago){
        			array_push($error, 'Formatação do campo valor_pago está incorreta.');
        		}
        	}else{
        	    array_push($error, 'Dados obrigatórios não enviados.');
        	}
        	
        	if($error){
        	    array_push($invalidLineData, [$dicionario->numero_parceria => $value->{$dicionario->numero_parceria}, 'erro' => $error]);
        	}
    	}
    	
    	if($invalidLineData){
    		$msg = ['msg' => 'Dados não validados.', 'linha_erro' => $invalidLineData];
    		$this->resposta->prepararResposta($msg, 400);
    		
    		$resultado = false;
    	}
    	
    	return $resultado;
    }
    
    private function prepararDados($dados, $assinatura, $dicionario){
        $resultado = array();
        
        foreach ($dados as $key => $value){
            $parceria = new \stdClass();
            
            $dados[$key]->{$dicionario->cnpj_proponente} = $this->prepararNaoNumerico($value->{$dicionario->cnpj_proponente});
            $dados[$key]->{$dicionario->data_inicio} = $this->prepararData($value->{$dicionario->data_inicio});
            $dados[$key]->{$dicionario->data_conclusao} = $this->prepararData($value->{$dicionario->data_conclusao});
            $dados[$key]->{$dicionario->valor_total} = $this->prepararMoeda($value->{$dicionario->valor_total});
            $dados[$key]->{$dicionario->valor_pago} = $this->prepararMoeda($value->{$dicionario->valor_pago});
    	    
            $parceria->_id = md5($value->{$dicionario->numero_parceria} . $value->{$dicionario->numero_parceria});
            $parceria->id_parceria = $value->{$dicionario->numero_parceria};
            $parceria->id_localidade = $assinatura->localidade;
            $parceria->parceria = $dados[$key];
            $parceria->assinatura = $assinatura;
            
            $dados[$key] = $this->normatizarNomesCampos($dados[$key], $dicionario);
            
    	    array_push($resultado, $parceria);
    	}
    	
    	return $resultado;
    }
    
    private function normatizarNomesCampos($dados, $dicionario){
        if(property_exists($dados, $dicionario->numero_parceria) && $dicionario->numero_parceria != 'numero_parceria'){
            $dados->numero_parceria = $dados->{$dicionario->numero_parceria};
            unset($dados->{$dicionario->numero_parceria});
        }
        
        if(property_exists($dados, $dicionario->cnpj_proponente) && $dicionario->cnpj_proponente != 'cnpj_proponente'){
            $dados->cnpj_proponente = $dados->{$dicionario->cnpj_proponente};
            unset($dados->{$dicionario->cnpj_proponente});
        }
        
        if(property_exists($dados, $dicionario->data_inicio) && $dicionario->data_inicio != 'data_inicio'){
            $dados->data_inicio = $dados->{$dicionario->data_inicio};
            unset($dados->{$dicionario->data_inicio});
        }
        
        if(property_exists($dados, $dicionario->data_conclusao) && $dicionario->data_conclusao != 'data_conclusao'){
            $dados->data_conclusao = $dados->{$dicionario->data_conclusao};
            unset($dados->{$dicionario->data_conclusao});
        }
        
        if(property_exists($dados, $dicionario->tipo_parceria) && $dicionario->tipo_parceria != 'tipo_parceria'){
            $dados->tipo_parceria = $dados->{$dicionario->tipo_parceria};
            unset($dados->{$dicionario->tipo_parceria});
        }
        
        if(property_exists($dados, $dicionario->valor_total) && $dicionario->valor_total != 'valor_total'){
            $dados->valor_total = $dados->{$dicionario->valor_total};
            unset($dados->{$dicionario->valor_total});
        }
        
        if(property_exists($dados, $dicionario->valor_pago) && $dicionario->valor_pago != 'valor_pago'){
            $dados->valor_pago = $dados->{$dicionario->valor_pago};
            unset($dados->{$dicionario->valor_pago});
        }
        
        if(property_exists($dados, $dicionario->orgao_concedente) && $dicionario->orgao_concedente != 'orgao_concedente'){
            $dados->orgao_concedente = $dados->{$dicionario->orgao_concedente};
            unset($dados->{$dicionario->orgao_concedente});
        }
        
        if(property_exists($dados, $dicionario->razao_social_proponente) && $dicionario->razao_social_proponente != 'razao_social_proponente'){
            $dados->razao_social_proponente = $dados->{$dicionario->razao_social_proponente};
            unset($dados->{$dicionario->razao_social_proponente});
        }
        
        if(property_exists($dados, $dicionario->nome_fantasia_proponente) && $dicionario->nome_fantasia_proponente != 'nome_fantasia_proponente'){
            $dados->nome_fantasia_proponente = $dados->{$dicionario->nome_fantasia_proponente};
            unset($dados->{$dicionario->nome_fantasia_proponente});
        }
        
        if(property_exists($dados, $dicionario->municipio_proponente) && $dicionario->municipio_proponente != 'municipio_proponente'){
            $dados->municipio_proponente = $dados->{$dicionario->municipio_proponente};
            unset($dados->{$dicionario->municipio_proponente});
        }
        
        if(property_exists($dados, $dicionario->endereco_proponente) && $dicionario->endereco_proponente != 'endereco_proponente'){
            $dados->endereco_proponente = $dados->{$dicionario->endereco_proponente};
            unset($dados->{$dicionario->endereco_proponente});
        }
        
        if(property_exists($dados, $dicionario->objeto_parceria) && $dicionario->objeto_parceria != 'objeto_parceria'){
            $dados->objeto_parceria = $dados->{$dicionario->objeto_parceria};
            unset($dados->{$dicionario->objeto_parceria});
        }
        
        if(property_exists($dados, $dicionario->situacao_parceria) && $dicionario->situacao_parceria != 'situacao_parceria'){
            $dados->situacao_parceria = $dados->{$dicionario->situacao_parceria};
            unset($dados->{$dicionario->situacao_parceria});
        }
        
        return $dados;
    }
    
    private function prepararData($dado){
    	$dado = preg_replace('/[\/\.]/', '-', $dado);
    	
    	return $dado;
    }
    
    private function prepararNaoNumerico($dado){
    	$dado = preg_replace('/[^0-9]/', '', $dado);
    	
    	return $dado;
    }
    
    private function prepararMoeda($dado){
    	$dado = preg_replace('/[Rr$ ]/', '', $dado);
    	
    	if(!preg_match('/^((.*)([\.]{1})(\d{1,2})?)$/', $dado)){
    		$dado = preg_replace('/[\.]/', '', $dado);
    		$dado = preg_replace('/[,]/', '.', $dado);
    	}
    	
    	return $dado;
    }
}
