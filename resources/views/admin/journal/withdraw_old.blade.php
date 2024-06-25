@extends('admin.layouts.app')
@section('page', 'Withdraw')
@section('content')
<section> 
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif  
    <div class="col-auto" id="withdrawn_div">
        <h3>Withdrawn</h3>
        <span class="text-danger" id="warning_withdraw_span"></span>
        <form action="{{ route('admin.revenue.withdraw_partner_amount') }}" method="POST">
        @csrf
        {{-- <input type="hidden" name="net_amount" id="net_amount"> --}}
        <div class="row">
            <div class="col-sm-6">                        
                <div class="form-group mb-3">
                    <label for="" id="lable_user">Partners <span class="text-danger">*</span></label>
                    <select name="admin_id" class="form-control" id="admin_id" onchange="getWithdrawlAmount(this.value);">
                        <option value="">Select a Partner</option>
                        @foreach ($partners as $p)
                        <option value="{{$p->id}}">{{$p->name}}</option>
                        @endforeach                        
                    </select>
                    @error('admin_id') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>
            <input type="hidden" name="entry_date" id="entry_date" value="">
            <div class="col-sm-6">                        
                <div class="form-group mb-3">
                    <label for="" id="lable_user">Withdrawl Amount <span class="text-danger">*</span> </label>
                    <input type="text" name="amount" class="form-control" id="amount" value="" readonly>
                    @error('amount') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div>                    
        </div>
        <div class="row">
            <div class="col-sm-6">                        
                <div class="form-group mb-3">
                    <a href="{{ route('admin.revenue.index', ['month_val'=>$month_val,'year_val'=>$year_val]) }}" class="btn btn-sm btn-danger">Back</a>
                    <button type="submit" id="withdraw_submit" class="btn btn-sm btn-success">Withdraw</button>
                </div>
            </div>
        </div>
        </form>
    </div>    
</section>
<script>
    function getWithdrawlAmount(e)
    {
        // alert(e);
        var year_val = "{{ $year_val }}";
        var month_val = "{{ $month_val }}";
        var net_amount = "{{ $net_amount }}";
        $.ajax({
            url: "{{ route('admin.revenue.getWithdrawlAmount') }}",
            dataType: 'json',
            type: 'POST',
            data: {
                'admin_id': e,
                'year_val': year_val,
                'month_val': month_val,
                "net_amount": net_amount,
                "_token": "{{ csrf_token() }}"
            },
            success: function( data){
                console.log(entry_date);
                if(data.amount == ''){
                    $('#warning_withdraw_span').text(data.message)
                    $('#withdraw_submit').prop('disabled', true);
                }else{
                    $('#warning_withdraw_span').text('')
                    $('#withdraw_submit').prop('disabled', false);
                }
                $('#entry_date').val(data.entry_date);
                $('#amount').val(data.amount);                
            }            
        });
    }
</script>
@endsection
