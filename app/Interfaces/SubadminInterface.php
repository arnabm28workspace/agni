<?php

namespace App\Interfaces;

interface SubadminInterface
{
    public function listAll();
    public function listExpAdmin();
    public function listById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function toggle($id);
    public function delete($id);
}
