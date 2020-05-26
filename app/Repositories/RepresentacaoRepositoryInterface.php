<?php


namespace App\Repositories;


use App\Models\Portal\Representacao;

interface RepresentacaoRepositoryInterface
{
    public function __construct(Representacao $representacao);

    public function getAll();

    public function get($id);

    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);
}