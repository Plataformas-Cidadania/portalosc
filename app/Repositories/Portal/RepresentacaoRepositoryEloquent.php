<?php


namespace App\Repositories\Portal;

use App\Models\Portal\Representacao;
use Illuminate\Database\Eloquent\Model;

class RepresentacaoRepositoryEloquent implements RepresentacaoRepositoryInterface
{
    private $model;

    public function __construct(Representacao $_representacao)
    {
        $this->model = $_representacao;
    }

    public function getAll()
    {
        return $this->model->with('osc')->with('usuario')->get();//->whereIn('id_representacao', [1, 250, 251]);//->orderBy('id_representacao', 'asc');
    }

    public function get($id)
    {
        return $this->model->with('usuario')->with('osc')->where('id_representacao', $id)->get();
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
    }

    public function update($id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function destroy($id)
    {
        // TODO: Implement destroy() method.
    }
}