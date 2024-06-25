@extends('admin.layouts.app')
@section('page', 'Home')
@section('content')
<section>
    <div class="row">
        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            {{$errors->first()}}
        </div>
        @endif
        <div class="col-sm-6 col-lg-3">
            <div class="card home__card bg-gradient-secondary">
                <div class="card-body">
                    <h4>Staff <i class="fi fi-br-user"></i></h4>
                    <h2>{{$data->users}}</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card home__card bg-gradient-secondary">
                <div class="card-body">
                    <h4>Store <i class="fi fi-br-user"></i></h4>
                    <h2>{{count($data->stores)}}</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card home__card bg-gradient-secondary">
                <div class="card-body">
                    <h4>Supplier <i class="fi fi-br-user"></i></h4>
                    <h2>{{$data->suppliers}}</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card home__card bg-gradient-secondary">
                <div class="card-body">
                    <h4>Category <i class="fi fi-br-chart-histogram"></i></h4>
                    <h2>{{$data->category}}</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card home__card bg-gradient-secondary">
                <div class="card-body">
                    <h4>Subcategory <i class="fi fi-br-chart-histogram"></i></h4>
                    <h2>{{$data->subcategory}}</h2>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card home__card bg-gradient-secondary">
                <div class="card-body">
                    <h4>Product <i class="fi fi-br-cube"></i></h4>
                    <h2>{{$data->products->count()}}</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="row">
        <div class="col-xl-6">
            <h5>Store Wise Sales</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Store</th>
                        <th>Sales Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->store_sales_data as $productKey => $product)
                    <tr>
                        <td>1</td>
                        <td>{{$product->store_name}}</td>
                        <td>Rs. {{$product->total_sales_value}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-xl-6">
            <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
        </div>
    </div>
</section>
<section>
    <div class="row">
        <div class="col-xl-6">
            <canvas id="myChart1" style="width:100%;max-width:600px"></canvas>
        </div>
        <div class="col-xl-6">
            <h5>Staff Wise Sales</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Store</th>
                        <th>Sales Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->user_sales_data as $productKey => $product)
                    <tr>
                        <td>1</td>
                        <td>{{$product->name}}</td>
                        <td>Rs. {{$product->total_sales_value}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</section>
<section>
    <div class="row">
        <div class="col-xl-12">
            <h5>Products List</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center"><i class="fi fi-br-picture"></i></th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Cost Price</th>
                        <th>Sell Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->products as $productKey => $product)
                        @php if($productKey == 5) break;  @endphp
                        <tr>
                            <td class="text-center column-thumb">
                                <img src="{{asset($product->image)}}">
                            </td>
                            <td>
                                <p class="m-0">{{$product->name}}</p>
                                <div class="row__action">
                                    <a href="{{ route('admin.product.edit', $product->id) }}">Edit</a>
                                    <a href="{{ route('admin.product.view', $product->id) }}">View</a>
                                </div>
                            </td>
                            <td>{{$product->category ? $product->category->name : ''}}</td>
                            <td>Rs. {{$product->cost_price}}</td>
                            <td>Rs. {{$product->sell_price}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-xl-12">
            <h5>Purchase orders</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>supplier</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->orders as $order)
                        
                        <tr>
                            <td><a href="{{ route('admin.purchaseorder.view', $order->unique_id) }}">#{{$order->unique_id}}</a></td>
                            <td>{{date('j M Y g:i A', strtotime($order->created_at))}}</td>
                            <td>Rs. {{$order->amount}}</td>
                            <td><span class="badge bg-info">{{ $order->supplier->name }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@php
$stores1 = array();
$sales_values1 = array();
foreach($data->store_sales_data as $s){
    array_push($stores1,$s->store_name);
    array_push($sales_values1,$s->total_sales_value);
}


$users1 = array();
$sales_values2 = array();
foreach($data->user_sales_data as $s){
    array_push($users1,$s->name);
    array_push($sales_values2,$s->total_sales_value);
}

@endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
var xValues = [];
var yValues = [];
xValues = <?php echo json_encode($stores1); ?>;
console.log("stores1>>",xValues);
yValues = <?php echo json_encode($sales_values1); ?>;
console.log("stores1>>",yValues);
var barColors = ["red", "green","blue","orange","brown"];


new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Store Wise Sales"
    }
  }
});
</script>
<script>
var xValues1 = [];
var yValues1 = [];
xValues1 = <?php echo json_encode($users1); ?>;
console.log("users1>>",xValues1);
yValues1 = <?php echo json_encode($sales_values2); ?>;
console.log("users1>>",yValues1);
var barColors = ["red", "green","blue","orange","brown"];


new Chart("myChart1", {
  type: "bar",
  data: {
    labels: xValues1,
    datasets: [{
      backgroundColor: barColors,
      data: yValues1
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Staff Wise Sales"
    }
  }
});
</script>
@endsection
