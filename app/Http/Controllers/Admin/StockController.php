<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\PurchaseOrderBox;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\StockBox;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockController extends Controller
{
    //

    public function listgrn(Request $request)
    {
        $product = !empty($request->product)?$request->product:'';
        $product_name = !empty($request->product_name)?$request->product_name:'';
        $paginate = 10;
        $data = Stock::select('*')->with(['purchase_order' => function($q){
            $q->select('id','unique_id');
        }])->withCount(['stock_product' => function($p){
            $p->selectRaw('quantity');
        }]);
        $totalData = Stock::select('*');

        if(!empty($product)){
            $stock_products = StockProduct::where('product_id',$product)->get();
            if(!empty($stock_products)){
                foreach($stock_products as $stock){
                    $ids[] = $stock->stock_id;
                }
            }
            $data = $data->whereIn('id',$ids);
            $totalData = $totalData->whereIn('id',$ids);
        }        
        
        $data = $data->orderBy('id','desc')->paginate($paginate);
        $totalData = $totalData->count();

        $data = $data->appends([
            'product'=>$product,
            'product_name'=>$product_name,
            'page'=>$request->page
        ]);
        // dd($data);
        return view('admin.grn.index', compact('data','totalData','product','product_name','paginate'));
    }

    public function viewgrn($id,Request $request)
    {
        $stock = Stock::with(['purchase_order' => function($q){
            $q->select('id','unique_id','supplier_id')->with('supplier:id,name');
        }])->find($id);
        $stock_products = StockProduct::where('stock_id',$id)->get();

        return view('admin.grn.detail', compact('id','stock','stock_products'));
    }

    public function barcodes($id,Request $request)
    {
        $stock = Stock::find($id);
        $stock_box = StockBox::where('stock_id',$id)->get();
        return view('admin.grn.barcode', compact('id','stock','stock_box'));
    }

    public function searchbarcodes(Request $request)
    {
        
        $search_product_name = !empty($request->search_product_name)?$request->search_product_name:'';
        $search_product_id = !empty($request->search_product_id)?$request->search_product_id:'';
        $search_barcode = !empty($request->search_barcode)?$request->search_barcode:'';
        


        $data = array();
        

        $data = StockBox::select('*')->where('is_stock_out', 0);
        if(!empty($search_product_id)){
            $data = $data->where('product_id',$search_product_id);
        }

        if(!empty($search_barcode)){
            $data = $data->where('barcode_no', 'LIKE', '%'.$search_barcode.'%');
        }

        $data = $data->get();
        if(empty($search_product_id)){
            $data = array();
        } 

        return view('admin.grn.searchbarcode', compact('data','search_product_name','search_product_id','search_barcode'));

        // dd($data);
    }
}
