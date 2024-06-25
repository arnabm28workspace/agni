<?php

namespace App\Repositories;

use App\Interfaces\UnitInterface;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UnitRepository implements UnitInterface
{
    /**
     * This method is for show unit list
     *
     */
    public function listAll()
    {
        return Unit::all();
    }

    public function activeUnits()
    {
        return Unit::where('status', 1)->get();
    }

    public function unitDetails($id)
    {
        return Unit::find($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try{
            $collectedData = collect($data);
            $newEntry = new Unit;
            $newEntry->name = $collectedData['name'];
            $newEntry->description = $collectedData['description'];
            $newEntry->value = strtolower($collectedData['name']);
            // $newEntry->status = $collectedData['status'];
            $newEntry->save();

            DB::commit();
            return $newEntry;

        }catch(\Throwable $th){
            throw $th;
            DB::rollback();
        }
    }

    public function update($id,array $data)
    {
        DB::beginTransaction();
        try {
            
            $updatedEntry = Unit::findOrFail($id);
            // dd($updatedEntry);
            $collectedData = collect($data);
            $updatedEntry->name = $collectedData['name'];
            $updatedEntry->description = $collectedData['description'];
            $updatedEntry->value = strtolower($collectedData['name']);
            $updatedEntry->save();

            DB::commit();
            return $updatedEntry;
        } catch (\Throwable $th) {
        //    dd($th);
            throw $th;
            DB::rollback();
        }
    }

    public function toggleStatus($id){
        $unit = Unit::findOrFail($id);

        $status = ( $unit->status == 1 ) ? 0 : 1;
        $unit->status = $status;
        $unit->save();

        return $unit;
    }

    public function existUnitName($name)
    {
        $check = Unit::where('name', $name)->first();
        return (empty($check)) ? true : false;
    }

    public function existUnitNameUpdate($id, $name)
    {
        $check = Unit::where('name', $name)->where('id', '!=', $id)->first();
        return (empty($check)) ? true : false;
    }

    public function bulkSuspend(array $array)
    {
        Unit::whereIn('id', $array)->update(['status' => 0]);
        return true;
    }

}
