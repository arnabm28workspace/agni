<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\SubadminInterface;
use Auth;

class SubadminController extends Controller
{
    // private ProductInterface $productRepository;

    public function __construct(SubadminInterface $SubadminRepository)
    {
        
        $this->SubadminRepository = $SubadminRepository;
    }

    public function index(Request $request)
    {
        // if(Auth::user()->type != 1)
        //     return redirect('admin/home')->withErrors(['msg' => 'You have no permission to access sub-admin']);

        $data = $this->SubadminRepository->listExpAdmin();

        return view('admin.sub-admin.index', compact('data'));
    }

    public function create(Request $request)
    {

        return view('admin.sub-admin.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "name" => "required|string|max:100",
            "email" => "required|email|max:200",
            "type" => "required",
            'password' => 'required|string'
        ]);

        $params = $request->except('_token');
        // dd($params);
        $storeData = $this->SubadminRepository->create($params);
        // dd($storeData);
        if ($storeData) {
            return redirect()->route('admin.sub-admin.index');
        } else {
            return redirect()->route('admin.sub-admin.create')->withInput($request->all());
        }
    }

    public function show(Request $request, $id)
    {
        $data = $this->SubadminRepository->listById($id);

        // dd($images);
        return view('admin.sub-admin.detail', compact('data'));
    }


    public function edit(Request $request, $id)
    {

        $data = $this->productRepository->listById($id);




        // dd($productColorGroup);

        return view('admin.sub-admin.edit', compact('id', 'data'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "name" => "required|string|max:100",
            "email" => "required|email|max:200",
            // "type" => "required",
        ]);
        // dd($request->product_id);
        $params = $request->except('_token');
        // dd($params);
        $storeData = $this->SubadminRepository->update($request->id, $params);

        if ($storeData) {
            return redirect()->route('admin.sub-admin.index')->with('success', 'Sub Admin updated successfully');
        } else {
            // dd($request->all());
            return redirect()->route('admin.sub-admin.update', $request->id)->withInput($request->all());
        }
    }

    public function status(Request $request, $id)
    {
        $storeData = $this->SubadminRepository->toggle($id);

        if ($storeData) {
            return redirect()->route('admin.sub-admin.index');
        } else {
            return redirect()->route('admin.sub-admin.create')->withInput($request->all());
        }
    }




    public function destroy(Request $request, $id)
    {
        $this->SubadminRepository->delete($id);

        return redirect()->route('admin.sub-admin.index');
    }


}
