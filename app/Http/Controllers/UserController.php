<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dao\UserDao;
use App\Util\ValidacaoUtil;

class UserController extends Controller
{
	private $dao;
	private $email;

	public function __construct()
	{
		$this->dao = new UserDao();
		$this->email = new EmailController();
	}

    public function getUser(Request $request, $id)
    {
		$id = trim($id);
        $resultDao = $this->dao->getUser($id);
		$this->configResponse($resultDao);
        return $this->response();
    }

    public function createUser(Request $request)
    {
		$validacao = new ValidacaoUtil();

        $email = $request->input('tx_email_usuario');
    	$senha = sha1($request->input('tx_senha_usuario'));
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	$representacao = $request->input('representacao');
        $token = md5($cpf.time());

		$cpf = preg_replace('/[^0-9]/', '', $cpf);

		if(!$validacao->validarCPF($cpf)){
			$result = ['msg' => 'CPF inválido.'];
			$this->configResponse($result, 400);
		}
		elseif(!$validacao->validarEmail($email)){
			$result = ['msg' => 'E-mail inválido.'];
			$this->configResponse($result, 400);
		}
		else{
			$flag_osc_exist = false;
			$flag_email_user = false;

			$message = $this->email->confirmation($nome, $token);
			$flag_email_user = $this->email->send($email, "Confirmação de Cadastro Mapa das Organizações da Sociedade Civil", $message);

			foreach($representacao as $value) {
				$id_osc = $value['id_osc'];

				$params_osc = [$id_osc];

				$osc_email = $this->dao->getOscEmail($params_osc);

				if($osc_email != null){
					$flag_osc_exist = true;

					$nomeOsc = $osc_email->tx_razao_social_osc;
					$emailOsc = $osc_email->tx_email;

					$user = ["nome"=>$nome, "email"=>$email, "cpf"=>$cpf];
					$emailIpea = "mapaosc@ipea.gov.br";

					if($emailOsc == null){
						$emailOsc = "Esta Organização não possui email para contato.";
						$osc = ["nomeOsc"=>$nomeOsc, "emailOsc"=>$emailOsc];

						$message = $this->email->informationIpea($user, $osc);
						$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das OSCs", $message);
					}
					else{
						$message = $this->email->informationOSC($user, $nomeOsc);

						$this->email->send($emailOsc, "Notificação de cadastro no Mapa das Organizações da Sociedade Civil", $message);
						$osc = ["nomeOsc"=>$nomeOsc, "emailOsc"=>$emailOsc];

						$message = $this->email->informationIpea($user, $osc);
						$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das OSCs", $message);
					}
				}
			}

			if($flag_osc_exist && $flag_email_user){
				$params = [$email, $senha, $nome, $cpf, $lista_email, $representacao, $token];
				$resultDao = $this->dao->createUser($params);

				if($resultDao->status){
					$result = ['msg' => $resultDao->mensagem];
					$this->configResponse($result, 200);
				}
				else{
					$result = ['msg' => $resultDao->mensagem];
					$this->configResponse($result, 400);
				}
			}
			else{
				if(!$flag_osc_exist) $result = ['msg' => 'Não existe OSC com este ID.'];
				elseif(!$flag_email_user) $result = ['msg' => 'Ocorreu um erro ao enviar o e-mail de ativação do cadastro.'];
				$this->configResponse($result, 400);
			}
		}

        return $this->response();
    }

    public function updateUser(Request $request, $id)
    {
		$validacao = new ValidacaoUtil();

        $email = $request->input('tx_email_usuario');
    	$senha = sha1($request->input('tx_senha_usuario'));
    	$nome = $request->input('tx_nome_usuario');
    	$cpf = $request->input('nr_cpf_usuario');
    	$lista_email = $request->input('bo_lista_email');
    	$representacao = $request->input('representacao');

        if(!$validacao->validarCPF($cpf)){
			$result = ['msg' => 'CPF inválido.'];
			$this->configResponse($result, 400);
		}
		elseif(!$validacao->validarEmail($email)){
			$result = ['msg' => 'E-mail inválido.'];
			$this->configResponse($result, 400);
		}
		else{
			$params = [$id, $email, $senha, $nome, $cpf, $lista_email, $representacao];
		    $resultDao = $this->dao->updateUser($params);

			if($resultDao->nova_representacao){
				foreach($resultDao->nova_representacao as $key => $value) {
					$params_osc = [$value['id_osc']];

					$osc_email = $this->dao->getOscEmail($params_osc);
					$nomeOsc = $osc_email->tx_razao_social_osc;
					$emailOsc = $osc_email->tx_email;

					$osc = ["nomeOsc"=>$nomeOsc, "emailOsc"=>$emailOsc];
					$user = ["nome"=>$nome, "email"=>$email, "cpf"=>$cpf];
					$emailIpea = "mapaosc@ipea.gov.br";

					if($emailOsc == null){
						$emailOsc = "Esta Organização não possui email para contato.";
						$message = $this->email->informationIpea($user, $osc);
						$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das OSCs", $message);
					}
					else{
						$message = $this->email->informationOSC($user, $nomeOsc);
						$this->email->send($emailOsc, "Notificação de cadastro no Mapa das Organizações da Sociedade Civil", $message);

						$message = $this->email->informationIpea($user, $osc);
						$this->email->send($emailIpea, "Notificação de cadastro de representante no Mapa das OSCs", $message);
					}
				}
			}

			$cd_tipo_usuario = 2;
			$time_expires = strtotime('+15 minutes');

			$representacao_string = '';
			foreach($representacao as $key => $value){
				$representacao_string = $representacao_string.','.$value['id_osc'];
			}

			$string_token = $id.'_'.$cd_tipo_usuario.'_'.$representacao_string.'_'.$time_expires;
			$token = openssl_encrypt($string_token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));

			$json_token = ['id_usuario' => $id,
						'tx_nome_usuario' => $nome,
						'access_token' => $token,
						'token_type' => 'Bearer',
						'expires_in' => $time_expires];

			$result = ['token' => $json_token,
						'msg' => $resultDao->mensagem];

			$this->configResponse($result, 200);
		}

    	return $this->response();
    }

    public function loginUser(Request $request)
    {
        $email = $request->input('tx_email_usuario');
    	$senha = sha1($request->input('tx_senha_usuario'));

		$params = [$email, $senha];
        $resultDao = $this->dao->loginUser($params);

        if($resultDao){
			if($resultDao['bo_ativo']){
				$cd_tipo_usuario = $resultDao['cd_tipo_usuario'];
				$tx_nome_usuario = $resultDao['tx_nome_usuario'];
				$id_usuario = $resultDao['id_usuario'];
				$time_expires = strtotime('+15 minutes');

				if($cd_tipo_usuario == 2){
					$representacao = $resultDao['representacao'];
					$string_token = $id_usuario.'_'.$cd_tipo_usuario.'_'.$representacao.'_'.$time_expires;
				}
				else{
					$string_token = $id_usuario.'_'.$cd_tipo_usuario.'_'.$time_expires;
				}

				$token = openssl_encrypt($string_token, 'AES-128-ECB', getenv('KEY_ENCRYPTION'));

				$params = [$id_usuario, $token];
				$result = ['id_usuario' => $id_usuario,
							'tx_nome_usuario' => $tx_nome_usuario,
							'access_token' => $token,
							'token_type' => 'Bearer',
							'expires_in' => $time_expires,
							'msg' => 'Usuário autorizado.'];

				$this->configResponse($result, 200);
			}
	        else{
				$result = ['msg' => 'Usuário não ativado.'];
				$this->configResponse($result, 403);
			}
        }
        else{
			$result = ['msg' => 'Usuário inválido.'];
			$this->configResponse($result, 401);
		}

        return $this->response();
    }

    public function logoutUser($id)
    {
		$id = trim($id);
		$params = [$id];
        $result = ['msg' => 'Usuário saiu do sistema.'];
		$this->configResponse($result);
        return $this->response();
    }

    public function activateUser($id, $token)
    {
    	$result = $this->validateToken($id, $token);

    	if($result){
    		$params = [$id];
	    	$resultDao = $this->dao->activateUser($params);
	    	$this->configResponse($resultDao);

    		$this->dao->deleteToken([$id]);

    		$osc_email = $this->dao->getUserEmail([$id]);
    		$nome = $osc_email->tx_nome_usuario;
    		$email = $osc_email->tx_email_usuario;
    		$message = $this->email->welcome($nome);
			$this->email->send($email, "Cadastro ativado", $message);

    		$result = ['msg' => 'Cadastro ativado.'];
    		$this->configResponse($result, 200);
    	}
    	else{
    		$result = ['msg' => 'Usuário e/ou token inválido.'];
    		$this->configResponse($result, 401);
    	}

        return $this->response();
    }

    public function validateToken($id, $token)
    {
    	$params = [$id, $token];
    	$resultDao = $this->dao->validateToken($params);

    	if($resultDao->result){
    		$result = ['msg' => 'Token válido.'];
    		$this->configResponse($result, 200);
    	}
    	else{
    		$result = ['msg' => 'Token inválido.'];
    		$this->configResponse($result, 400);
    	}

        return $this->response();
    }

    public function updatePassword(Request $request, $id)
    {
    	$senha = sha1($request->input('tx_senha_usuario'));
    	$token = $request->input('tx_token');

    	$params = [$id, $token];
    	$resultDao = $this->dao->validateToken($params);

    	if($resultDao->result){
	    	$params = [$id, $senha];
	    	$resultDao = $this->dao->updatePassword($params);

	    	if($resultDao->status){
	    		$this->dao->deleteToken([$id]);

	    		$result = ['msg' => $resultDao->mensagem];
	    		$this->configResponse($result, 200);
	    	}
	    	else{
	    		$result = ['msg' => 'Ocorreu um erro.'];
	    		$this->configResponse($result, 400);
	    	}
    	}
    	else{
    		$result = ['msg' => 'Usuário e/ou token inválido(s).'];
    		$this->configResponse($result, 401);
    	}

    	return $this->response();
    }

    public function forgotPassword(Request $request)
    {
		$validacao = new ValidacaoUtil();

    	$email = $request->input('tx_email_usuario');

		if(!$validacao->validarEmail($email)){
			$result = ['msg' => 'E-mail inválido.'];
			$this->configResponse($result, 400);
		}
		else{
	    	$params = [$email];
	    	$resultDao = $this->dao->getUserChangePassword($params);

	    	if($resultDao){
	    		if($resultDao->bo_ativo){

			    	$id_user = $resultDao->id_usuario;
			    	$cpf = $resultDao->nr_cpf_usuario;
			    	$nome = $resultDao->tx_nome_usuario;
			    	$token = md5($cpf.time());
			    	$date = date('Y-m-d', strtotime('+24 hours'));

			    	$params_token = [$id_user, $token, $date];
			    	$result_token = $this->dao->createToken($params_token);

			    	if($result_token->inserir_token_usuario){
		    			$message = $this->email->changePassword($nome, $token);
		    			$this->email->send($email, "Alterar Senha!", $message);

			    		$result = ['msg' => 'E-mail para a troca de senha foi enviado.'];
			    		$this->configResponse($result, 200);
			    	}
			    	else{
			    		$result = ['msg' => 'Ocorreu um erro'];
			    		$this->configResponse($result, 400);
			    	}
	    		}
	    		else{
	    			$result = ['msg' => 'Usuário não está ativado.'];
	    			$this->configResponse($result, 401);
	    		}
	    	}
	    	else{
	    		$result = ['msg' => 'Este e-mail não está cadastrado.'];
	    		$this->configResponse($result, 400);
	    	}
		}

    	return $this->response();
    }

    public function contato(Request $request)
    {
		$validacao = new ValidacaoUtil();

    	$assunto = $request->input('assunto');
    	$nome = $request->input('nome');
    	$email = $request->input('email');
    	$texto = $request->input('mensagem');

		if(!$validacao->validarEmail($email)){
			$result = ['msg' => 'E-mail inválido.'];
			$this->configResponse($result, 400);
		}
		else{
	    	$message = $this->email->contato($nome, $email, $texto);
	    	$emailIpea = "mapaosc@ipea.gov.br";
	     	$this->email->send($emailIpea, $assunto, $message);

	    	$result = ['msg' => 'E-mail enviado.'];
	    	$this->configResponse($result, 200);
		}

    	return $this->response();
    }

	public function createSubscriber(Request $request){
		$validacao = new ValidacaoUtil();

		$email = $request->input('tx_email_assinante');
    	$nome = $request->input('tx_nome_assinante');

		if(!$validacao->validarEmail($email)){
			$result = ['msg' => 'E-mail inválido.'];
			$this->configResponse($result, 400);
		}
		else{
			$params = [$email, $nome];
			$resultDao = $this->dao->createSubscriber($params);

			if($resultDao->status){
				$result = ['msg' => $resultDao->mensagem];
				$this->configResponse($result, 200);
			}
			else{
				$result = ['msg' => $resultDao->mensagem];
				$this->configResponse($result, 400);
			}
		}

		return $this->response();
	}
}
