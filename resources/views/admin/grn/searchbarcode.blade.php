@extends('admin.layouts.app')
@section('page', 'Search Stock Barcodes')
@section('content')
<section>   
    <ul class="breadcrumb_menu">
        <li>Purchase Order</li>
        <li>Search Stock Barcodes</li>
    </ul> 
    <div class="search__filter">
        <div class="row align-items-center justify-content-between">
            <div class="col">
                @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
            </div>
            <div class="col-auto">
                
            </div>
            <div class="col-6">
                <form action="" id="searchForm">
                <div class="row">
                    <div class="col">
                        <input type="search" name="search_product_name" value="{{$search_product_name}}" placeholder="Search product by name ..." class="form-control select-md"  id="searchProText" onkeyup="getProductByName(this.value);" > 
                        <input type="hidden" name="search_product_id" id="searchProId" value="{{$search_product_id}}">
                        <div class="respDrop" id="respDrop"></div>
                    </div>
                    <div class="col-auto">
                        <input type="search" name="search_barcode" value="{{$search_barcode}}" placeholder="Search barcode no ..." class="form-control select-md"  id="search_barcode">
                    </div>
                    
                    <div class="col-auto">
                        <input type="submit" title="Search" class="btn btn-outline-success select-md" >
                        <a href="{{ route('admin.grn.searchbarcodes') }}" class="btn btn-outline-danger select-md">Reset</a>
                    </div>
                   
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="filter">
        <div class="row align-items-center justify-content-between">                
            <div class="col"></div>
            <div class="col-auto">                    
                <p></p>
            </div>
        </div>
    </div>
    
    <div class="row">
        @forelse ($data as $item)
        <div class="col-sm-3">
            <div class="barcode_image" style="margin: 0 auto 4px">
                <span title="{{$item->barcode_no}}">
                    {!! $item->code_html !!}
                    <span style="width: 100%; display: block; text-align: center; color: #000000;">{{$item->barcode_no}}</span>
                </span>   
                <button onclick="downloadImage('{{$item->barcode_no}}')" class="btn btn-outline-success select-md">Download Barcode</button>  
                
            </div>
        </div>
        @empty
        <div class="col-12">
            <p>No barcode found</p>
        </div>
        @endforelse
        
    </div>
        
   
</section>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        var searchProId = $('#searchProId').val();
        if(searchProId == ''){
            $('#search_barcode').prop('readonly', true);
        } else {
            $('#search_barcode').prop('readonly', false);
        }
        
    })
    $('input[name=search_product_name]').on('search', function () {
        
        $('#searchProId').val('');
        $('#searchForm').submit();
    });
    $('input[name=search_barcode]').on('search', function () {
        
        $('#searchForm').submit();
    });

    function getProductByName(name) {  
        if(name.length > 0) {
            $.ajax({
                url: "{{ route('admin.product.searchByName') }}",
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    term: name
                },
                success: function(result) {
                    // console.log(result);
                    var content = '';
                    if (result.length > 0) {
                        content += `<div class="dropdown-menu show w-100 product-dropdown select-md" aria-labelledby="dropdownMenuButton">`;

                        $.each(result, (key, value) => {
                            content += `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchProduct(${value.id})">${value.name}</a>`;
                        })
                        content += `</div>`;
                        // $($this).parent().after(content);
                    } else {
                        content += `<div class="dropdown-menu show w-100 product-dropdown select-md" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">No product found</li></div>`;
                    }
                    $('#respDrop').html(content);
                }
            });
        }   else {
            $('.product-dropdown').hide()
        }   
        
    }

    function fetchProduct(id) {
        $('.product-dropdown').hide()
        $.ajax({
            url: "{{ route('admin.product.viewDetail') }}",
            method: 'post',
            data: {
                '_token': '{{ csrf_token() }}',
                id: id
            },
            success: function(result) {
                console.log(result);
                var name = result.name;
                $('#searchProId').val(id);
                $('#searchProText').val(name);
                $('#searchForm').submit();
            }
        });                
    }

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