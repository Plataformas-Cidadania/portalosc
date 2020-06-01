<?php


namespace App\Repositories\Osc;


use App\Models\Osc\Osc;
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
        $osc = $this->model->find($id)->dados;

        //$dados = $osc->dados;

        //$resumo = $dados->tx_resumo_osc;

        //print_r($resumo);

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