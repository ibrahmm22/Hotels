<?php
namespace App\Repositories;
/**
 * Created by PhpStorm.
 * User: anoos
 * Date: 09/11/18
 * Time: 07:54 م
 */

interface IRepository
{
    public function all($sortedKey, $sortedMethod);

    public function create(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function find($id);

    public function query();
}
