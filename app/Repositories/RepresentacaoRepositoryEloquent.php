<?php


namespace App\Repositories;


use App\Models\Portal\Representacao;

class RepresentacaoRepositoryEloquent implements RepresentacaoRepositoryInterface
{
    private $model;

    public function __construct(Representacao $representacao)
    {
        $this->model = $representacao;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function get($id)
    {
        // TODO: Implement get() method.
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