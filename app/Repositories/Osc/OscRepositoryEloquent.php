<?php


namespace App\Repositories\Osc;

use App\Models\Osc\Osc;
use App\Models\Syst\DCAreaAtuacao;
use App\Repositories\Osc\OscRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class OscRepositoryEloquent implements OscRepositoryInterface
{
    private $model;

    public function __construct(Osc $_osc)
    {
        $this->model = $_osc;
    }

    public function getAll()
    {
        return $this->model->all();//->whereIn('id_representacao', [1, 250, 251]);//->orderBy('id_representacao', 'asc');
    }

    public function get($id)
    {
        //$osc = $this->model->find($id)->with(['dados', 'areasAtuacao.dc_area_atuacao', 'localizacao', 'recursos', 'relacoesTrabalho']);
        $osc = $this->model->find($id);
        /*
        $dados_gerais = $osc->dados;
        $areas_atuacao = $osc->areasAtuacao;



        $dc_areas_atuacao = $areas_atuacao[0]->dc_area_atuacao;
        $dc_subareas_atuacao = $areas_atuacao[0]->dc_subarea_atuacao;
        $subareas_atuacao = $dc_areas_atuacao->dc_subarea_atuacao;
        //$teste = DCAreaAtuacao::find($ida);
        //$subareas_atuacao = $areas_atuacao->
        $localizacao = $osc->localizacao;
        $recursos = $osc->recursos;
        $relacoesTrabalho = $osc->relacoesTrabalho;


        //$dados = $osc->dados;

        //$resumo = $dados->tx_resumo_osc;

        //print_r($resumo);
        */
        return $osc;
        //return $this->model->find($id);//with('dados')->where('id_osc', $id)->get();
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }
}