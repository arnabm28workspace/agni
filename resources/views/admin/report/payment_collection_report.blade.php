@extends('admin.layouts.app')
@section('page', 'Home')

@section('content')

@php
$start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'2022-01-01';
$end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'2022-12-31';
@endphp
<section>
    <div class="row">

            
            <div class="col-sm-6">
                <div class="search__filter">
                    <div class="row align-items-center justify-content-between">
                    <div class="col">
                        
                    </div>
                    <div class="col-auto">
                        <form action="" method="GET">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Start Date"
                                    value="{{$start_date}}"
                                    autocomplete="off">
                                </div>
                                <div class="col-auto">
                                    <input type="date" name="end_date" id="end_date" class="form-control" placeholder="End Date"
                                    value="{{$end_date}}"
                                    autocomplete="off">
                                </div>
                                <div class="col-auto">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Search</button>
                                </div>
                                <div class="col-auto">
                                <a href="{{ route('admin.paymentCollectionReport') }}" class="btn btn-outline-danger btn-sm">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                
            </div>
        <div class="col-xl-6">
            <h5>Store Wise Payment Collection</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Store</th>
                        <th>Collection Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($store_payments_data as $productKey => $product)
                    <tr>
                        <td>1</td>
                        <td>{{$product->store_name}}</td>
                        <td>Rs. {{$product->total_collection_amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h5>Staff Wise Payment Collection</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Staff</th>
                        <th>Collection Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_payments_data as $productKey => $product)
                    <tr>
                        <td>1</td>
                        <td>{{$product->name}}</td>
                        <td>Rs. {{$product->total_collection_amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-xl-6">
            <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
            <canvas id="myChart1" style="width:100%;max-width:600px"></canvas>
        </div>
    </div>
    
</section>
@php
$stores1 = array();
$sales_values1 = array();
foreach($store_payments_data as $s){
    array_push($stores1,$s->store_name);
    array_push($sales_values1,$s->total_collection_amount);
}

$users1 = array();
$sales_values2 = array();
foreach($user_payments_data as $s){
    array_push($users1,$s->name);
    array_push($sales_values2,$s->total_collection_amount);
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
      text: "Store Wise Payment Collection"
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
console.log("stores1>>",yValues1);
var barColors = ["red", "green","blue","orange"];


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
      text: "Staff Wise Payment Collection"
    }
  }
});
</script>
@endsection