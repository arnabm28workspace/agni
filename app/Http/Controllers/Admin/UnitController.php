<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UnitInterface;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    //

    public function __construct(UnitInterface $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function index(Request $request)
    {
        $term = !empty($request->term)?$request->term:'';
        // $data = $this->unitRepository->listAll();
        $data = Unit::where('name','LIKE','%'.$term.'%')->paginate(5);
        $data = $data->appends(['term'=>$term,'page'=>$request->page]);
        $total = Unit::count();
        return view('admin.unit.index', compact('data','term','total'));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:100",
            "description" => "max:500"
        ]);

        $params = $request->except('_token');
        // dd($params);
        $existUnitName = $this->unitRepository->existUnitName($request->name);

        if($existUnitName){
            $storeData = $this->unitRepository->create($params);
            // dd($storeData);
            if ($storeData) {
                return redirect()->route('admin.unit.index');
            } else {
                return redirect()->route('admin.unit.index')->withInput($request->all());
            }
        }else{
            return redirect()->route('admin.unit.index')->withInput($request->all())->withErrors(['error' => 'Already exists unit']);
        }




        
    }

    public function show($id)
    {
        $data = $this->unitRepository->unitDetails($id);
        return view('admin.unit.detail', compact('data'));
    }

    public function status(Request $request, $id)
    {
        $storeData = $this->unitRepository->toggleStatus($id);

        if ($storeData) {
            return redirect()->route('admin.unit.index');
        } else {
            return redirect()->route('admin.unit.create')->withInput($request->all());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:100",
            "description" => "max:500"
        ]);
        // dd($request->product_id);
        $params = $request->except('_token');
        // dd($storeData);
        $existUnitNameUpdate = $this->unitRepository->existUnitNameUpdate($request->id, $request->name);
        if($existUnitNameUpdate){
            $storeData = $this->unitRepository->update($request->id, $params);

            if ($storeData) {
                return redirect()->route('admin.unit.index')->with('success', 'Unit updated successfully');
            } else {
                // dd($request->all());
                return redirect()->route('admin.unit.view', $request->id)->withInput($request->all());
            }
        }else{
            return redirect()->route('admin.unit.view', $request->id)->withInput($request->all())->withErrors(['error' => 'Already exists unit']);

        }
        
        
    }

    public function bulkSuspend(Request $request)
    {        
        if(!empty($request->suspend_check)){
            $data = $this->unitRepository->bulkSuspend($request->suspend_check);  

            if($data){
                return redirect()->route('admin.unit.index');
            }else{
                return redirect()->route('admin.unit.index');
            }
        }else{
            return redirect()->route('admin.unit.index');
        }
        
          
    }
}
