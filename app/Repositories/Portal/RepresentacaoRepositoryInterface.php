<?php


namespace App\Repositories\Portal;


use App\Models\Portal\Representacao;
use Illuminate\Database\Eloquent\Model;

interface RepresentacaoRepositoryInterface
{
    public function __construct();

    public function getAll();

    public function get($id);

    public function store(array $data);

    public function update($id, array $data);

    public function destroy($id);
}