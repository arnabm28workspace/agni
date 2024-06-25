<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link href="https://cdn-uicons.flaticon.com/uicons-bold-rounded/css/uicons-bold-rounded.css" rel="stylesheet"> --}}
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">

    <title>{{ config('app.name') }} | Admin @yield('page')</title>
</head>
<body>
    <div id="app-preloader">
        <div class="preloader-spinner">
            <svg class="preloader-spinner-icon" viewBox="0 0 24 24">
                <path d="M 22.49772,12.000001 A 10.49772,10.497721 0 0 1 12,22.497722 10.49772,10.497721 0 0 1 1.5022797,12.000001 10.49772,10.497721 0 0 1 12,1.5022797 10.49772,10.497721 0 0 1 22.49772,12.000001 Z" fill="none" stroke-linecap="round" />
            </svg>
        </div>
    </div>
    @php        
        $accessCustomer = $accessCategory = $accessSubcategory = $accessProduct = $accessExpense = $accessSupplier = $accessStaff = $accessPO = $accessSales = $accessAccounting = $accessReport = false;
        $designationName = "Partner";

        // echo Auth::user()->type; die;

        if(Auth::user()->type == 1){
            
            $accessCustomer = true;
            $accessCategory = true;
            $accessSubcategory = true;
            $accessProduct = true;
            $accessExpense = true;
            $accessSupplier = true;
            $accessStaff = true;
            $accessPO = true;
            $accessSales = true;
            $accessAccounting = true;
            $accessReport = true;

            $designationName = "Partner";
        } else {
            $designationName = getSingleAttributeTable('designation',Auth::user()->designation,'name');
            // echo $getSingleAttributeTable; 
            $accessCustomer = userAccesses(Auth::user()->designation,1);
            $accessCategory = userAccesses(Auth::user()->designation,2);
            $accessSubcategory = userAccesses(Auth::user()->designation,3);
            $accessProduct = userAccesses(Auth::user()->designation,4);
            $accessExpense = userAccesses(Auth::user()->designation,5);
            $accessSupplier = userAccesses(Auth::user()->designation,6);
            $accessStaff = userAccesses(Auth::user()->designation,7);
            $accessPO = userAccesses(Auth::user()->designation,8);
            $accessSales = userAccesses(Auth::user()->designation,9);
            $accessAccounting = userAccesses(Auth::user()->designation,10);
            $accessReport = userAccesses(Auth::user()->designation,11);
        }

        
    @endphp

    <div class="side__bar shadow-sm">
        <div class="admin__logo">
            <div class="logo">
                <img src="{{ asset('admin/images/workmaxlogo 1.png') }}" alt="">
            </div>            
        </div>
        <button type="button" class="responsiveNav_Btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
        <nav class="main__nav">
            <ul>
                <li>
                    <a href="{{ route('admin.home') }}"><i class="fi fi-br-home"></i> <span>Dashboard</span></a>
                </li>   
                @if ($accessCategory || $accessSubcategory || $accessProduct || $accessCustomer || $accessExpense || $accessStaff || $accessSupplier)
                <li class="@if(request()->is('admin/category*') || request()->is('admin/subcategory*') || request()->is('admin/store*') || request()->is('admin/product*')  || request()->is('admin/expense*') || request()->is('admin/user*') || request()->is('admin/designation*') || request()->is('admin/staff*') ) { {{'active'}} }  @endif">
                    <a href="#"><i class="fi fi-br-database"></i> <span>Master</span></a>
                    <ul>
                        @if ($accessCustomer)
                        <li><a href="{{ route('admin.store.index') }}"><i class="fi fi-br-users-alt"></i> <span>Customer Management</span></a></li> 
                        @endif
                        @if ($accessProduct || $accessCategory || $accessSubcategory)
                        <li class="{{ ( request()->is('admin/product/list*') ) ? 'active' : '' }}">
                            <a href="#" class="parent"><i class="fi fi-br-box"></i> <span>Product Management</span></a>
                            <ul>
                                @if ($accessProduct)
                                <li class="{{ ( request()->is('admin/product*') ) ? 'active' : '' }}"><a href="{{ route('admin.product.index') }}">Product</a></li>
                                @endif
                                @if ($accessCategory)
                                <li class="{{ ( request()->is('admin/category*') ) ? 'active' : '' }}"><a href="{{ route('admin.category.index') }}">Category</a></li>  
                                @endif
                                @if ($accessSubcategory)
                                <li class="{{ ( request()->is('admin/subcategory*') ) ? 'active' : '' }}"><a href="{{ route('admin.subcategory.index') }}">Sub Category</a></li>    
                                @endif
                                
                            </ul>
                        </li>
                        @endif
                        
                        @if ($accessExpense)
                        <li class="">
                            <a href="#" class="parent"><i class="fi fi-br-box"></i> <span>Expense</span></a>
                            <ul>
                                <li class=""><a href="{{ route('admin.expense.index', 1) }}">Recurring</a></li>
                                <li class=""><a href="{{ route('admin.expense.index', 2) }}">Non Recurring</a></li>
                            </ul>
                        </li> 
                        @endif
                        @if ($accessSupplier)
                        <li class="{{ ( request()->is('admin/user/list/supplier*') ) ? 'active' : '' }}"><a href="{{ route('admin.user.index', 'supplier') }}"><i class="fi fi-br-users-alt"></i> <span>Supplier Management</span></a></li>
                        @endif
                        
                        @if ($accessStaff)
                        <li class="">
                            <a href="#" class="parent"><i class="fi fi-br-users-alt"></i> <span>Staff Management</span></a>
                            <ul>
                                <li class=""><a href="{{ route('admin.designation.index') }}"> Designation</a></li>
                                <li class=""><a href="{{ route('admin.staff.index') }}">Staff</a></li>                                
                            </ul>
                        </li>   
                        @endif
                        
                    </ul>                    
                </li>   
                @endif             
                             
                @if ($accessPO)
                <li class="@if(request()->is('admin/purchaseorder*') || request()->is('admin/grn*')) { {{'active'}} }  @endif">
                    <a href="#"><i class="fi fi-br-cube"></i> <span>Purchase Order</span></a>
                    <ul>
                        <li class="@if(request()->is('admin/purchaseorder*')) { {{'active'}} }  @endif"><a href="{{ route('admin.purchaseorder.index') }}">PO</a></li>
                        <li class="@if(request()->is('admin/grn/list')) { {{'active'}} }  @endif"><a href="{{ route('admin.grn.list') }}">GRN</a></li>
                        <li class="@if(request()->is('admin/grn/searchbarcodes')) { {{'active'}} }  @endif"><a href="{{ route('admin.grn.searchbarcodes') }}">Search Stock Barcodes</a></li>
                    </ul>
                </li> 
                @endif                               
                @if ($accessSales)
                <li class="@if(request()->is('admin/order*')) { {{'active'}} }  @endif">
                    <a href="#"><i class="fi fi-br-cube"></i> <span>Sales</span></a>
                    <ul>
                        <li class="@if (Request::get('status') == 1) active @endif"><a href="{{ route('admin.order.index') }}?status=1">Received Orders</a></li>
                        <li class="@if (Request::get('status') == 2) active @endif"><a href="{{ route('admin.order.index') }}?status=2">Pending Orders</a></li>
                        <li class="@if (Request::get('status') == 3) active @endif"><a href="{{ route('admin.order.index') }}?status=3">Cancelled Orders</a></li>
                        <li class="@if (Request::get('status') == 4) active @endif"><a href="{{ route('admin.order.index') }}?status=4">Completed Orders</a></li>
                        <li class="@if (request()->is('admin/packingslip*')) active @endif"><a href="{{ route('admin.packingslip.index') }}">Packing Slips</a> </li>
                        <li class="@if (request()->is('admin/invoice*')) active @endif"><a href="{{ route('admin.invoice.index') }}">Invoices</a> </li>
                        <li class=""><a href="{{ route('admin.product.thresholdRequest') }}">Price Requests</a></li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->type == 1)
                <li class="@if(request()->is('admin/service-slip*') ) { {{'active'}} }  @endif">
                    <a href="{{ route('admin.service-slip.index') }}">Service Slip</a>
                </li>
                    
                @endif
                @if ($accessAccounting)
                <li class="@if(request()->is('admin/ledger*') || request()->is('admin/ledger*') || request()->is('admin/ledger*')) { {{'active'}} }  @endif">
                    <a href="#"><i class="fi fi-br-cube"></i> <span>Accounting</span></a>
                    <ul>
                        <li class="{{ ( request()->is('admin/accounting/add_opening_balance') ) ? 'active' : '' }}">
                            <a href="{{ route('admin.accounting.add-opening-balance') }}">Add Opening Balance Customer</a>
                        </li>
                        <li class="{{ ( request()->is('admin/accounting/add_opening_balance/partner') ) ? 'active' : '' }}">
                            <a href="{{ route('admin.accounting.add-opening-balance', 'partner') }}">Add Opening Balance Partner</a>
                        </li>
                        <li class="{{ ( request()->is('admin/accounting/add_expenses') ) ? 'active' : '' }}">
                            <a href="{{ route('admin.accounting.add_expenses') }}">Add Expenses</a>
                        </li>
                        @if (Auth::user()->type == 1)
                        <li class="{{ ( request()->is('admin/accounting/add_payment_receipt') ) ? 'active' : '' }}">
                            <a href="{{ route('admin.accounting.add_payment_receipt') }}">Add Payment Receipt</a>
                        </li>
                        @endif
                        
                        <li class="{{ ( request()->is('admin/accounting/listopeningbalance') ) ? 'active' : '' }}"><a href="{{ route('admin.accounting.listopeningbalance') }}">List Customer Opening Balance</a></li>
                        <li class="{{ ( request()->is('admin/paymentcollection*') ) ? 'active' : '' }}"><a href="{{ route('admin.paymentcollection.index') }}">List Payment Collection</a></li>    
                        <li class="{{ ( request()->is('admin/revenue/withdrawls') ) ? 'active' : '' }}"><a href="{{ route('admin.revenue.withdrawls') }}">List Partner Withdrawls</a></li> 
                    </ul>
                </li> 
                @endif
                @if ($accessReport)
                <li class="@if(request()->is('admin/store-wise-report*') || request()->is('admin/staff-wise-report*') || request()->is('admin/payment-collection-report*')) { {{'active'}} }  @endif">
                    <a href="#"><i class="fi fi-br-cube"></i> <span>Report</span></a>
                    <ul>  
                        <li class="{{ ( request()->is('admin/attendance/view') ) ? 'active' : '' }}"><a href="{{ route('admin.attendance.view') }}">Salesman Locations</a></li>
                        <li class=""><a href="{{ route('admin.travel-report') }}">Travel Report</a></li>
                        <li class="@if(request()->is('admin/store-notes')) {{'active'}} @endif"><a href="{{ route('admin.store-notes') }}">Sales Notes</a></li>
                        <li class="{{ ( request()->is('admin/choose-ledger-user') ) ? 'active' : '' }}"><a href="{{ route('admin.choose-ledger-user') }}">Ledger</a></li>
                        @if (Auth::user()->type == 1)
                        <li class="@if(request()->is('admin/revenue/index')) { {{'active'}} }  @endif">
                            <a href="{{ route('admin.revenue.index') }}">Profit & Loss</a>
                        </li>  
                        <li class="@if(request()->is('admin.revenue.withdrawls')) { {{'active'}} }  @endif">
                            <a href="{{ route('admin.revenue.withdrawls',['auth_type'=>1]) }}">My Withdrawls</a>
                        </li>   
                        @endif
                        
                    </ul>
                </li>   
                @endif        
                             
            </ul>
        </nav>
        <div class="col-auto ms-auto">
            <div class="dropdown profileDropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }} <br/>
                    <small>{{$designationName}}</small> 
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">

                    <li><a class="dropdown-item" href="{{route('admin.admin.profile')}}">Profile</a></li>
                    @if (Auth::user()->type == 1)
                    {{-- <li><a class="dropdown-item" href="{{route('admin.sub-admin.index')}}">Manage Sub Admin</a></li> --}}
                    <li>
                        <a href="{{ route('admin.appsettings.view') }}" class="dropdown-item">Settings</a>
                    </li>
                    @endif
                    
                    <li> <a class="dropdown-item" href="{{ route('logout') }}" id="logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();"> Log Out </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                </ul>
            </div>
        </div>        
    </div>
    <main class="admin">        
        <section class="admin__title">
            <h1>@yield('page')</h1>
        </section>
        @yield('content')
        <footer>
            <div class="row">
                <div class="col-12 text-end">{{ config('app.name') }} 2021-{{date('Y')}}</div>
            </div>
        </footer>
    </main>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
    <script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset('admin/js/custom.js') }}"></script>

    @yield('script')
    <script>
        $(document).on("click", "#logout", function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            $.confirm({
                    title: 'Confirm!',
                    content: 'Simple confirm!',
                    buttons: {
                        confirm: function () {
                            $.alert('Confirmed!');
                        },
                        cancel: function () {
                            $.alert('Canceled!');
                        },
                        somethingElse: {
                            text: 'Something else',
                            btnClass: 'btn-blue',
                            keys: ['enter', 'shift'],
                            action: function(){
                                $.alert('Something else?');
                            }
                        }
                    }
                });
        });
    </script>
</body>
</html>
