<?php


namespace App\Services;


use App\Repositories\RepresentacaoRepositoryInterface;

class RepresentacaoService
{
    private $repo;

    public function __construct(RepresentacaoRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->getAll();
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