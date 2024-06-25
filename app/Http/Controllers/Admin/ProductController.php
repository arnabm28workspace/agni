<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\ProductInterface;
use App\Interfaces\UnitInterface;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // private ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository,UnitInterface $unitRepository,Request $request)
    {
        $this->productRepository = $productRepository;
        $this->unitRepository = $unitRepository;
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->id = Auth::user()->id;
            $this->type = Auth::user()->type;
            $this->designation = Auth::user()->designation;
            // dd($this->type);
            if($this->type == 2){
                $userAccesses = userAccesses($this->designation,4);
                if(!$userAccesses){
                    abort(401);
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $term = !empty($request->term)?$request->term:'';
        $paginate = 2;

        $data = Product::select('products.*','categories.name AS cat_name','sub_categories.name AS subcat_name')->leftJoin('categories','categories.id','products.cat_id')->leftJoin('sub_categories','sub_categories.id','products.sub_cat_id')->where('products.name', 'LIKE', '%' . $term . '%')->orderBy('products.id','desc')->paginate($paginate);
        $data = $data->appends(['term'=>$term,'page'=>$request->page]);
        $total = Product::count();
        return view('admin.product.index', compact('data','term','total','paginate'));
    }

    

    public function subcategoriesByCategory(Request $request)
    {
        # through ajax call...
        $cat_id = !empty($request->cat_id)?$request->cat_id:'';

        $data = $this->productRepository->subCategoryList(1,$cat_id);
        return $data;
    }

    public function create(Request $request)
    {
        $categories = $this->productRepository->categoryList(1);        
        $units = $this->unitRepository->activeUnits();
        $supplier = DB::table('suppliers')->select('id','name')->where('status',1)->get();
        // dd($units);
        return view('admin.product.create', compact('categories', 'units','supplier'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "cat_id" => "required|exists:categories,id",
            "sub_cat_id" => "required|exists:sub_categories,id",
            "name" => "required|string|max:50|unique:products,name",
            // "hsn_code" => "required|max:50",
            // "pcs" => "required",
            // "short_desc" => "required",
            // "desc" => "required",
            // "igst" => "required",
            // "cgst" => "required",
            // "sgst" => "required",            
            // "image" => "required",
            // "product_images" => "nullable|array"
        ],[
            "cat_id.required" => "Please choose category",
            "cat_id.exists" => "Unknown category",
            "sub_cat_id.required" => "Please choose sub category",
            "sub_cat_id.exists" => "Unknown sub category",
            "name.required" => "Please mention product name",
            "name.max" => "Please maintain product name within 150 character",
            "name.unique" => "Already exists product name",
            // "short_desc.required" => "Please add short description of product",
            // "desc.required" => "Please add some description of product",
            // "image.required" => "Please add an image of product"
        ]);

        $params = $request->except('_token');
        // dd($params);
        $storeData = $this->productRepository->create($params);
        // dd($storeData);
        if ($storeData) {
            Session::flash('message', 'Product created successfully');
            return redirect()->route('admin.product.index');
        } else {
            return redirect()->route('admin.product.create')->withInput($request->all());
        }
    }

    public function show(Request $request, $id)
    {
        $data = $this->productRepository->listById($id);
        $images = $this->productRepository->listImagesById($id);
        // dd($images);
        return view('admin.product.detail', compact('data', 'images'));
    }

    public function viewDetail(Request $request)
    {
        $id = $request->id;
        $data =  Product::where('id',$id)->first();
        return $data;
    }

    public function searchByName(Request $request)
    {
        # ajax search by name...
        $term = !empty($request->term)?$request->term:'';
        $idnotin = !empty($request->idnotin)?$request->idnotin:array();

        $data = DB::table('products')->select('*')->where('name', 'LIKE', '%'.$term.'%')->where('status', 1);
        
        if(!empty($idnotin)){
            $data = $data->whereNotIn('id', $idnotin);
        }
        
        $data = $data->orderBy('name','asc')->get();
        return $data;
    }

    

    public function edit(Request $request, $id)
    {
        $categories = $this->productRepository->categoryList(1);
        $sub_categories = $this->productRepository->subCategoryList(1);
        $data = $this->productRepository->listById($id);
        $images = $this->productRepository->listImagesById($id);
        $supplier = DB::table('suppliers')->select('id','name')->where('status',1)->get();
        $units = $this->unitRepository->activeUnits();
        // dd($data);

        return view('admin.product.edit', compact('id', 'data', 'categories', 'sub_categories', 'images','supplier','units'));
    }

    public function update(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "cat_id" => "required|exists:categories,id",
            "sub_cat_id" => "required|exists:sub_categories,id",
            "name" => "required|string|max:50|unique:products,name,".$request->product_id,
            // "hsn_code" => "required|max:50",
            // "pcs" => "required",
            // "short_desc" => "required",
            // "desc" => "required",
            // "igst" => "required",
            // "cgst" => "required",
            // "sgst" => "required",            
            // "image" => "required_if_null:image",
            // "product_images" => "nullable|array"
        ],[
            "cat_id.required" => "Please choose category",
            "cat_id.exists" => "Unknown category",
            "sub_cat_id.required" => "Please choose sub category",
            "sub_cat_id.exists" => "Unknown sub category",
            "name.required" => "Please mention product name",
            "name.max" => "Please maintain product name within 150 character",
            "name.unique" => "Already exists product name",
            // "short_desc.required" => "Please add short description of product",
            // "desc.required" => "Please add some description of product",
            // "image.required" => "Please add an image of product"
        ]);
        // dd($request->product_id);
        $params = $request->except('_token');
        // dd($params);
        $storeData = $this->productRepository->update($request->product_id, $params);

        if ($storeData) {
            Session::flash('message', 'Product updated successfully');
            return redirect()->route('admin.product.index');
        } else {
            // dd($request->all());
            return redirect()->route('admin.product.update', $request->product_id)->withInput($request->all());
        }
    }

    public function status(Request $request, $id)
    {
        $storeData = $this->productRepository->toggle($id);

        if ($storeData) {
            Session::flash('message', 'Status changed successfully');
            return redirect()->route('admin.product.index');
        } else {
            return redirect()->route('admin.product.create')->withInput($request->all());
        }
    }

    public function destroy(Request $request, $id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('admin.product.index');
    }

    public function destroySingleImage(Request $request, $id)
    {
        $this->productRepository->deleteSingleImage($id);
        return redirect()->back();

        // return redirect()->route('admin.product.index');
    }  

    public function bulkSuspend(Request $request)
    {
        if(!empty($request->suspend_check)){
            $count_data = count($request->suspend_check);
            $data = $this->productRepository->bulkSuspend($request->suspend_check);

            Session::flash('message', $count_data.' products suspended successfully');
            return redirect()->route('admin.product.index');
        }else{
            return redirect()->route('admin.product.index');
        }
    }

    public function thresholdRequest(Request $request)
    {
        $data = DB::table('product_threshold_request AS ptr')->select('ptr.*','u.name AS user_name','s.store_name','p.name AS pro_name')->leftJoin('products AS p','p.id','ptr.product_id')->leftJoin('stores AS s','s.id','ptr.store_id')->leftJoin('users AS u','u.id','ptr.user_id')->orderBy('ptr.id','desc')->paginate(20);

        $total = DB::table('product_threshold_request')->count();

        return view('admin.threshold.index', compact('data','total'));
    }

    public function viewThresholdRequest($id)
    {
        $data = DB::table('product_threshold_request AS ptr')->select('ptr.*','u.name AS user_name','s.store_name','p.name AS pro_name')->leftJoin('products AS p','p.id','ptr.product_id')->leftJoin('stores AS s','s.id','ptr.store_id')->leftJoin('users AS u','u.id','ptr.user_id')->where('ptr.id',$id)->first();
        return view('admin.threshold.add', compact('id','data'));
    }

    public function setThreshold(Request $request)
    {
        $request->validate([
            'interval' => 'required',
            'is_approved' => 'required'
        ],[
            'is_approved.required' => "Please choose an option"
        ]);

        $interval = $request->interval;
        $is_approved = $request->is_approved;

        $started_at = date('Y-m-d H:i:s');
        if($is_approved == 1){
            $expired_at = date('Y-m-d H:i:s', strtotime('+'.$interval.' days'));
            $successMsg = 'Request approved successfully. This product is now open for this store for '.$interval.' days. ';
        }else if($is_approved == 2){
            /* For deny it's expired immediately */
            $expired_at = date('Y-m-d H:i:s');
            $successMsg = 'Request denied successfully.';
        }
        
        DB::table('product_threshold_request')->where('id',$request->id)->update([
            'started_at' => $started_at,
            'expired_at' => $expired_at,
            'is_approved' => $request->is_approved,
            'updated_at' => $started_at
        ]);

        Session::flash('message', $successMsg); 
        return redirect()->route('admin.product.thresholdRequest');

    }


    public function viewRequestedPriceReceiveOrder($id)
    {
        # code...
        $data = DB::table('product_threshold_request AS ptr')->select('ptr.*','u.name AS user_name','s.store_name','p.name AS pro_name')->leftJoin('products AS p','p.id','ptr.product_id')->leftJoin('stores AS s','s.id','ptr.store_id')->leftJoin('users AS u','u.id','ptr.user_id')->where('ptr.id',$id)->first();
        return view('admin.threshold.receive-customer', compact('data', 'id'));
    }

    public function saveRequestedPriceReceiveOrder(Request $request)
    {
        # code...
        // dd($request->all());

        $request->validate([
            'id' => 'required','integer',
            'customer_approval' => 'required',
            'customer_approve_note' => 'required'
        ],[
            'customer_approval.required' => "Please select an option",
            'customer_approve_note.required' => "Please add some note on this"
        ]);

        $params = $request->except('_token');
        $id = $params['id'];
        $customer_approval = $params['customer_approval'];
        $product_threshold_request = DB::table('product_threshold_request')->find($id);
        $user_id = $product_threshold_request->user_id;
        $store_id = $product_threshold_request->store_id;
        $product_id = $product_threshold_request->product_id;
        $price = $product_threshold_request->price;
        $qty = $product_threshold_request->qty;

        
        /* By default customer_approval is 1 or approved */
        /* Generate new order and order products with received if customer_approval is 1 */
        $order_no = "AGNI".mt_rand();
        $order_id = DB::table('orders')->insertGetId([
            'order_no' => $order_no,
            'user_id' => $user_id,
            'store_id' => $store_id,
            'amount' => $price,
            'final_amount' => $price,
            'status' => 1,
            'comment' => $params['customer_approve_note']
        ]);
        $productData = Product::find($product_id);        
        DB::table('order_products')->insert([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'product_name' => $productData->name,
            'product_image' => $productData->image,
            'price' => $price,
            'qty' => $qty
        ]);

        DB::table('product_threshold_request')->where('id',$id)->update([
            'customer_approve_note' => $params['customer_approve_note'],
            'customer_approval' => $customer_approval,
            'order_no' => $order_no
        ]);

        $successMsg = "Order placed successfully";
        Session::flash('message', $successMsg);         
        return redirect()->route('admin.order.index', ['status'=>1]);
        

    }
    
}
