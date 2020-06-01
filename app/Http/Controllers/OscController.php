<?php

namespace App\Http\Controllers;

use App\Services\Osc\OscService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OscController extends Controller
{
    private $service;

    /**
     * Create a new controller instance.
     *
     * @param RepresentacaoService $service
     */
    public function __construct(OscService $_service)
    {
        $this->service = $_service;
    }

    public function getAll()
    {
        try {
            return response()->json($this->service->getAll(), Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function get($id)
    {
        try {
            return response()->json($this->service->get($id), Response::HTTP_OK);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request) {
        //return [];
        //return ['tx_email_usuario' => 'teste@gmail.com'];
        //return ['tx_nome_usuario' => '', 'tx_email_usuario' => '', 'tx_senha_usuario' => ''];

        //$user = new Usuario($request->all());

        //return $user;
    }
}
