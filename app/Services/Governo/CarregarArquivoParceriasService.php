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
	    
		$contrato = [
			'arquivo' => ['apelidos' => NomenclaturaAtributoEnum::ARQUIVO, 'obrigatorio' => true, 'tipo' => 'arquivo'],
			'tipo_arquivo' => ['apelidos' => NomenclaturaAtributoEnum::TIPO_ARQUIVO, 'obrigatorio' => true, 'tipo' => 'string']
		];
		
		$model = new Model($contrato, $this->requisicao->getConteudo());
		$flagModel = $this->analisarModel($model);
		
		if($flagModel){
			$requisicao = $model->getRequisicao();
			
			$enderecoArquivo = $requisicao->arquivo->getPathName();
			$flagTipoArquivo = $this->verificarTipoArquivo($enderecoArquivo);
			
			if($flagTipoArquivo){
    			$dados = $this->carregarDados($requisicao->tipo_arquivo, $enderecoArquivo);
    			
    			if($dados){
    	        	$dadosValidados = $this->validarDados($dados);
    				
    	            if($dadosValidados){
    	            	$usuario = $this->requisicao->getUsuario();
    	            	
    	            	if(env('UPLOAD_FILE_PATH') == null){
    	            		$diretorioArquivo = realpath(__DIR__ . '/../../../') . '/storage/app/gov/' . $usuario->id_usuario . '/';
    					}else{
    					    $diretorioArquivo = env('UPLOAD_FILE_PATH') . '/' . $usuario->id_usuario . '/';
    					}
    					
    					$fonteRecursos = 'Governo municipal ou governo estadual';
    					if($usuario->tipo_usuario == TipoUsuarioEnum::GOVERNO_MUNICIPAL){
    					    $fonteRecursos = 'Município';
    					}else if($usuario->tipo_usuario == TipoUsuarioEnum::GOVERNO_ESTADUAL){
    					    $fonteRecursos = 'Governo estadual';
    					}
    					
    					$assinatura = new \stdClass();
    					$assinatura->data = $dataHora;
    					$assinatura->usuario = $usuario->id_usuario;
    					$assinatura->fonte_recursos = $fonteRecursos;
    					$assinatura->localidade = $usuario->localidade;
    					$assinatura->nome_arquivo = $requisicao->arquivo->getClientOriginalName();
    					$assinatura->hash = md5(serialize($dados));
    					
    					$dados = $this->prepararDados($dados, $assinatura);
    					
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
    	            	        
    	            	        $fp = fopen($diretorioArquivo . $nomeArquivo, 'w');
    	            	        fwrite($fp, $dadosJson);
        	            		fclose($fp);
        	            		
        	            		$this->resposta->prepararResposta(['msg' => 'Upload do arquivo realiado com sucesso.'], 200);
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
    
    private function carregarDados($tipo_arquivo, $enderecoArquivo)
    {
    	$dados = null;
    	
    	switch($tipo_arquivo) {
    		case 'csv':
    			$dadosCsv = $this->carregarCsv($enderecoArquivo);
    			if($dadosCsv){
    				$dados = $this->converterCsv($dadosCsv);
    			}
    			break;
    				
    		case 'json':
    			$dados = $this->carregarJson($enderecoArquivo);
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
    
    private function carregarCsv($enderecoArquivo){
    	$resultado = array();
    	$delimitador = ';';
    	
    	$dados = file($enderecoArquivo);
    	$titulos = explode($delimitador, $dados[0]);
    	
    	$flagDadosObrigatorios = $this->verificarDadosObrigatorios($titulos);
    	if($flagDadosObrigatorios){
	    	foreach ($dados as $value){
	    		array_push($resultado, explode($delimitador, trim($value)));
	    	}
    	}
    	
    	return $resultado;
    }
    
    private function carregarJson($enderecoArquivo){
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
    
    private function verificarDadosObrigatorios($title){
    	$resultado = false;
    	
    	$titulos = array();
    	foreach ($title as $key => $value){
    		array_push($titulos, $this->ajustarDado($value));
    	}
    	
    	$obrigatorios = ["numero_parceria", "cnpj_proponente", "data_inicio", "data_conclusao", "situacao_parceria", "tipo_parceria", "valor_total", "valor_pago"];
    	$flagObrigatorios = count(array_intersect($obrigatorios, $titulos)) == count($obrigatorios);
    	
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
    
    private function validarDados($data){
    	$resultado = true;
    	
    	$separatorDate = '(\/|-|\.)';
    	$patternDate = '/^(?:(?:31'.$separatorDate.'(?:0?[13578]|1[02]))\1|(?:(?:29|30)'.$separatorDate.'(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{4})$|^(?:29'.$separatorDate.'0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])'.$separatorDate.'(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{4})$/';
    	
    	$separatorCnpj = '(\/|-|\.)';
    	$patternCnpj = '/^((([0-9]{2})'.$separatorCnpj.'?([0-9]{3})'.$separatorCnpj.'?([0-9]{3})'.$separatorCnpj.'?([0-9]{4})('.$separatorCnpj.'?([0-9]{2})?)))$/';
    	
    	$currencySymbol = '(([Rr]{1}[$]{1})|([$]{1}))?([ ]*)?';
    	$patternCurrency = '/^(('.$currencySymbol.'(\d{1,3}(?:[\.]?\d{3})*)([,]{1}\d{2})?)|('.$currencySymbol.'(\d*)([\.]{1})(\d{1,2})?))$/';
    	
    	$invalidLineData = array();
    	foreach ($data as $key => $value){
    	    $cnpj = str_replace(['/', '-', '.'], '', $value->cnpj_proponente);
    	    
    		$checkDataInicio = preg_match_all($patternDate, $value->data_inicio);    		
    		$checkDataConclusao = preg_match_all($patternDate, $value->data_conclusao);
    		$checkCnpj = preg_match_all($patternCnpj, $cnpj);
    		$checkValorTotal = preg_match_all($patternCurrency, $value->valor_total);
    		$checkValorPago = preg_match_all($patternCurrency, $value->valor_pago);
    		
    		$error = array();
    		if(!$checkDataInicio){
    			array_push($error, 'data_inicio');
    		}
    		
    		if(!$checkDataConclusao){
    			array_push($error, 'data_conclusao');
    		}
    		
    		if(!$checkCnpj){
    			array_push($error, 'cnpj_proponente');
    		}
    		
    		if(!$checkValorTotal){
    			array_push($error, 'valor_total');
    		}
    		
    		if(!$checkValorPago){
    			array_push($error, 'valor_pago');
    		}
    		
    		if($error){
    			array_push($invalidLineData, ['linha' => $value->numero_parceria, 'erro' => $error]);
    		}
    	}
    	
    	if($invalidLineData){
    		$msg = ['msg' => 'Dados não validados.', 'linha_erro' => $invalidLineData];
    		$this->resposta->prepararResposta($msg, 400);
    		
    		$resultado = false;
    	}
    	
    	return $resultado;
    }
    
    private function prepararDados($dados, $assinatura){        
        foreach ($dados as $key => $value){
    	    $dados[$key]->cnpj_proponente = $this->prepararNaoNumerico($value->cnpj_proponente);
    	    $dados[$key]->data_inicio = $this->prepararData($value->data_inicio);
    	    $dados[$key]->data_conclusao = $this->prepararData($value->data_conclusao);
    	    $dados[$key]->valor_total = $this->prepararMoeda($value->valor_total);
    	    $dados[$key]->valor_pago = $this->prepararMoeda($value->valor_pago);
    	    $dados[$key]->assinatura = $assinatura;
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
