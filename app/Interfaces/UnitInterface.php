<?php

namespace App\Interfaces;

interface UnitInterface
{
    public function listAll();
    public function activeUnits();
    public function unitDetails($id);
    public function create(array $data);
    public function update($id,array $data);
    public function toggleStatus($id);
    public function existUnitName($name);
    public function existUnitNameUpdate($id, $name);
    public function bulkSuspend(array $array);

}
