@extends('admin.layouts.app')
@section('page', 'View Archived Cartons')
@section('content')
<section>
    <ul class="breadcrumb_menu">
        <li>Purchase Order</li>
        @if ($data[0]->status == 1)
        <li><a href="{{ route('admin.purchaseorder.index') }}?type=po">PO</a></li>
        @elseif ($data[0]->status == 2)
        <li><a href="{{ route('admin.purchaseorder.index') }}?type=grn">GRN</a></li>
        @endif        
        <li>View Archived Cartons</li>
    </ul>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                                        
                    @if($errors->any())            
                        {!! implode('', $errors->all('<p class="small text-danger">:message</p>')) !!}
                    @endif
                    @if (Session::has('message'))
                         <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Carton</th>                                
                                <th>Weight</th>
                                <th>Pieces</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @forelse ($data as $item)                            
                            <tr>
                                <td>{{$i}}</td>
                                <td>
                                    <label class="label-control">
                                        {{$item->pro_name}}  
                                    </label>
                                </td>
                                <td>
                                    <span title="{{$item->barcode_no}}">
                                        {!! $item->code_html !!}
                                        <strong>{{$item->barcode_no}}</strong>
                                    </span>                                   
                                </td>                                
                                
                                <td>
                                    <span id="scannedweight{{$item->barcode_no}}">{{$item->po_weight_val / 1000}} kg</span>
                                </td>
                                <td>
                                    {{$item->pcs}} pieces
                                </td>
                                
                                  
                                
                                
                                
                                
                            </tr> 
                            
                            @empty
                            <tr></tr>
                            @endforelse                           
                        <tbody>
                    </table> 
                    
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('div.alert').delay(3000).slideUp(300);
                        
    })

    

    function downloadImage(name){
        var url = "https://bwipjs-api.metafloor.com/?bcid=code128&text="+name;

        fetch(url)
            .then(resp => resp.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                // the filename you want
                a.download = name;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            })
            .catch(() => alert('An error sorry'));
    }
</script>
@endsection
