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
                                <a href="{{ route('admin.staffWiseReport') }}" class="btn btn-outline-danger btn-sm">Clear</a>
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
            <h5>Store Wise Sales</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Staff</th>
                        <th>Order Count</th>
                        <th>Sales Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_sales_data as $productKey => $product)
                    <tr>
                        <td>1</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->order_count}}</td>
                        <td>Rs. {{$product->total_sales_value}}</td>
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
$order_counts = array();
foreach($user_sales_data as $s){
    array_push($stores1,$s->name);
    array_push($sales_values1,$s->total_sales_value);
    array_push($order_counts,$s->order_count);
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
var xValues = [];
var yValues1 = [];
xValues = <?php echo json_encode($stores1); ?>;
console.log("stores1>>",xValues);
yValues1 = <?php echo json_encode($order_counts); ?>;
console.log("stores1>>",yValues1);


new Chart("myChart1", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [{
      //backgroundColor: "rgba(0,0,0,1.0)",
      borderColor: "rgba(0,0,0,0.1)",
      data: yValues1
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Store Wise Orders"
    }
  }
});
</script>
@endsection