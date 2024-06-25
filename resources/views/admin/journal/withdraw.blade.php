@extends('admin.layouts.app')
@section('page', 'Withdrawn')
@section('content')
<section> 
    <ul class="breadcrumb_menu">
        <li>Report</li>
        <li><a href="{{ route('admin.revenue.index') }}">Profit & Loss</a></li>
        <li>Withdrawn </li>
    </ul>   
    @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif  
    <div class="col-auto" id="withdrawn_div">
        <span class="text-danger" id="warning_withdraw_span"></span>
        <form action="{{ route('admin.revenue.withdraw_partner_amount') }}" method="POST">
        @csrf
        
        <div class="row">            
            <input type="hidden" name="entry_date" id="entry_date" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="admin_id" id="" value="{{ Auth::user()->id }}">
            <div class="col-sm-2">                        
                <div class="form-group mb-3">
                    <label for="" id="lable_user">Withdrawl Amount <span class="text-danger">*</span> </label>
                    <input type="text" name="amount" class="form-control" id="amount" value="@if(!empty(old('amount'))){{old('amount')}} @else {{ $withdrawable_amount_each }} @endif">
                    @error('amount') <p class="small text-danger">{{ $message }}</p> @enderror
                </div>
            </div> 
            <div class="col-sm-2">                        
                <div class="form-group mb-3">
                    <label for="" id="lable_user">Withdrawlable Amount </label>
                    <input type="text" name="withdrawable_amount" class="form-control" id="" value="{{ $withdrawable_amount_each }}" readonly>
                </div>
            </div> 
            <div class="col-sm-2">                        
                <div class="form-group mb-3">
                    <label for="" id="lable_user">Reserved Amount </label>
                    <input type="text" name="reserved_amount" class="form-control" id="" value="{{ $reserved_amount }}" readonly>
                </div>
            </div> 
            <div class="col-sm-2">                        
                <div class="form-group mb-3">
                    <label for="" id="lable_user">Profit in Hand </label>
                    <input type="text" name="profit_in_hand" class="form-control" id="" value="{{ $profit_in_hand }}" readonly>
                </div>
            </div> 
            <div class="col-sm-2">                        
                <div class="form-group mb-3">
                    <label for="" id="lable_user">Net Profit </label>
                    <input type="text" name="net_profit" class="form-control" id="" value="{{ $net_profit }}" readonly>                    
                </div>
            </div> 
            <div class="col-sm-2">                        
                <div class="form-group mb-3">
                    <label for="" id="lable_user">Net Profit Margin </label>
                    <input type="text" name="net_profit_margin" class="form-control" id="" value="{{ $net_profit_margin }}" readonly>
                </div>
            </div>                    
        </div>
        
        <div class="row">
            <div class="col-sm-6">                        
                <div class="form-group mb-3">
                    <a href="{{ route('admin.revenue.index') }}" class="btn btn-sm btn-danger">Back</a>
                    @if ($profit_in_hand == 0 && $net_profit == 0 && $net_profit_margin == 0)
                    <button type="submit" id="withdraw_submit" class="btn btn-sm btn-success" disabled>Withdraw</button>
                    @else
                    <button type="submit" id="withdraw_submit" class="btn btn-sm btn-success">Withdraw</button>
                    @endif
                    
                </div>
            </div>
        </div>
        </form>
    </div>    
</section>
<script>
    
</script>
@endsection
