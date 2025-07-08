@extends('layouts.dashboardLayout')
@section('title', 'All Market Baskets')

@section('content')
<div class="container py-5">
    <!--<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">-->
    <!--    <h2 class="fw-bold text-dark mb-3 mb-md-0 d-flex align-items-center">-->
    <!--        <i class="bi bi-graph-up me-3 fs-3 text-primary"></i> Market Baskets-->
    <!--    </h2>-->

    <!--    <form method="GET" action="{{ route('dashboard.all-baskets') }}" class="d-flex flex-wrap gap-3 align-items-center justify-content-center justify-content-md-end w-100 w-md-auto">-->
    <!--        <div class="input-group input-group-sm flex-nowrap me-md-2" style="max-width: 180px;">-->
    <!--            <label for="sort_by" class="input-group-text bg-light border-end-0 text-muted fw-semibold">Sort:</label>-->
    <!--            <select name="sort_by" id="sort_by" class="form-select border-start-0 rounded-end shadow-sm" onchange="this.form.submit()">-->
    <!--                <option value="updated_at" {{ ($sortBy ?? 'updated_at') === 'updated_at' ? 'selected' : '' }}>Date</option>-->
    <!--                <option value="type" {{ ($sortBy ?? '') === 'type' ? 'selected' : '' }}>Type</option>-->
    <!--            </select>-->
    <!--        </div>-->

    <!--        <div class="input-group input-group-sm flex-nowrap me-md-2" style="max-width: 180px;">-->
    <!--            <label for="sort_order" class="input-group-text bg-light border-end-0 text-muted fw-semibold">Order:</label>-->
    <!--            <select name="sort_order" id="sort_order" class="form-select border-start-0 rounded-end shadow-sm" onchange="this.form.submit()">-->
    <!--                <option value="desc" {{ ($sortOrder ?? 'desc') === 'desc' ? 'selected' : '' }}>Descending</option>-->
    <!--                <option value="asc" {{ ($sortOrder ?? '') === 'asc' ? 'selected' : '' }}>Ascending</option>-->
    <!--            </select>-->
    <!--        </div>-->

    <!--        <div class="input-group input-group-sm flex-nowrap" style="max-width: 200px;">-->
    <!--            <label for="filter_type" class="input-group-text bg-light border-end-0 text-muted fw-semibold">Filter:</label>-->
    <!--            <select name="filter_type" id="filter_type" class="form-select border-start-0 rounded-end shadow-sm" onchange="this.form.submit()">-->
    <!--                <option value="all" {{ ($filterType ?? 'all') === 'all' ? 'selected' : '' }}>All Types</option>-->
    <!--                <option value="Intraday" {{ ($filterType ?? '') === 'Intraday' ? 'selected' : '' }}>Intraday</option>-->
    <!--                <option value="Short Term" {{ ($filterType ?? '') === 'Short Term' ? 'selected' : '' }}>Short Term</option>-->
    <!--                <option value="Long Term" {{ ($filterType ?? '') === 'Long Term' ? 'selected' : '' }}>Long Term</option>-->
    <!--            </select>-->
    <!--        </div>-->
    <!--    </form>-->
    <!--</div>-->
@php
    $activeType = request()->get('filter_type', '');
    $tabTypes = ['Intraday', 'Short Term', 'Long Term'];
@endphp

<!-- 💡 Title + Filters -->
<div class="market-container">
    <div class="market-header">
        <h2 class="market-title">
            <span class="icon">📈</span> Market Baskets
        </h2>

        <!--<form method="GET" action="{{ route('dashboard.all-baskets') }}" class="filter-form">-->
        <!--    <div class="filter-group">-->
                <!--<label for="sort_by">Sort By</label>-->
        <!--        <select name="sort_by" id="sort_by" onchange="this.form.submit()">-->
        <!--            <option value="updated_at" {{ ($sortBy ?? 'updated_at') === 'updated_at' ? 'selected' : '' }}>Date</option>-->
        <!--            <option value="type" {{ ($sortBy ?? '') === 'type' ? 'selected' : '' }}>Type</option>-->
        <!--        </select>-->
        <!--    </div>-->

        <!--    <div class="filter-group">-->
                <!--<label for="sort_order">Order</label>-->
        <!--        <select name="sort_order" id="sort_order" onchange="this.form.submit()">-->
        <!--            <option value="desc" {{ ($sortOrder ?? 'desc') === 'desc' ? 'selected' : '' }}>Descending</option>-->
        <!--            <option value="asc" {{ ($sortOrder ?? '') === 'asc' ? 'selected' : '' }}>Ascending</option>-->
        <!--        </select>-->
        <!--    </div>-->
        <!--</form>-->
        <form method="GET" action="{{ route('dashboard.all-baskets') }}" class="filter-form">
    <!-- Search -->
    <div class="filter-group">
        <!--<label for="search_stock">Search Stock</label>-->
        <input type="text" name="search_stock" id="search_stock"
               value="{{ request('search_stock') }}"
               placeholder="Enter stock name..."required
               class="search-input" />
    </div>

    <!-- Sort By -->
    <div class="filter-group">
        <!--<label for="sort_by">Sort By</label>-->
        <select name="sort_by" id="sort_by" onchange="this.form.submit()">
            <option value="updated_at" {{ ($sortBy ?? 'updated_at') === 'updated_at' ? 'selected' : '' }}>Date</option>
            <option value="type" {{ ($sortBy ?? '') === 'type' ? 'selected' : '' }}>Type</option>
        </select>
    </div>

    <!-- Sort Order -->
    <div class="filter-group">
        <!--<label for="sort_order">Order</label>-->
        <select name="sort_order" id="sort_order" onchange="this.form.submit()">
            <option value="desc" {{ ($sortOrder ?? 'desc') === 'desc' ? 'selected' : '' }}>Descending</option>
            <option value="asc" {{ ($sortOrder ?? '') === 'asc' ? 'selected' : '' }}>Ascending</option>
        </select>
    </div>
</form>

    </div>
</div>

<!-- 🔘 Tabs -->
<div class="tabs-wrapper">
        <a href="{{ route('dashboard.all-baskets')}}"
           class="tab-button">
            All
        </a>
    @foreach($tabTypes as $type)
        <a href="{{ route('dashboard.all-baskets', array_merge(request()->except('page'), ['filter_type' => $type])) }}"
           class="tab-button {{ $activeType === $type ? 'active' : '' }}">
            {{ $type }}
        </a>
    @endforeach
</div>

<style>

/*for searching */
.search-input {
    padding: 6px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    transition: border-color 0.2s ease;
    height: 38px;
}

.search-input:focus {
    outline: none;
    border-color: #0d6efd;
}

/* Filter Form Styles */
.filter-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 200px;
}

.filter-group label {
    font-weight: 600;
    color: #555;
    font-size: 14px;
}

/* Input and Select Unified Styling */
.filter-input,
.filter-group select {
    height: 38px; /* SAME height */
    padding: 6px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    transition: border-color 0.2s ease;
}

.filter-input:focus,
.filter-group select:focus {
    outline: none;
    border-color: #0d6efd;
}



    /* Container & Header */
.market-container {
    background: #fff;
    /*border: 1px solid #ddd;*/
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
}

.market-header {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

@media (min-width: 768px) {
    .market-header {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
  
}
@media (max-width: 668px){
  #basket-card{
        justify-content: center;
    }
}

/* Title */
.market-title {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

.market-title .icon {
    font-size: 28px;
    color: #0d6efd;
}

/* Filter Form */
.filter-form {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 200px;
}

.filter-group label {
    font-weight: 600;
    color: #555;
    font-size: 14px;
}

.filter-group select {
    padding: 6px 12px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fff;
    transition: border-color 0.2s ease;
}

.filter-group select:focus {
    outline: none;
    border-color: #0d6efd;
}

/* Tabs */
.tabs-wrapper {
    background: #fff;
    /*border: 1px solid #ddd;*/
    /*border-radius: 12px;*/
    padding: 16px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 8px;
}

.tab-button {
    padding: 10px 20px;
    min-width: 130px;
    text-align: center;
    font-weight: 600;
    font-size: 14px;
    border-radius: 5px;
    border: 0.5px solid #0d6efd;
    background-color: white;
    color: #0d6efd;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
}

.tab-button:hover {
    background-color: #0d6efd;
    color: white;
    transform: translateY(-1px);
}

.tab-button.active {
    background-color: #0d6efd;
    color: white;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
}

/*basket header*/
/* Header Container */
.custom-card-header {
    background: linear-gradient(to right, #005550, #007a73);
    color: #fff;
    padding: 16px 24px;
    border-radius: 12px 12px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}

/* Title with Icon */
.header-title {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

.text-icon {
    font-size: 20px;
}

/* Basket Badge */
.basket-badge {
    background-color: #ffffff;
    color: #005550;
    padding: 6px 14px;
    border-radius: 9999px;
    font-weight: 600;
    font-size: 14px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

/* Optional Colors for Icons */
.text-yellow { color: #ffc107; }   /* Intraday */
.text-orange { color: #fd7e14; }   /* Short Term */
.text-cyan   { color: #17a2b8; }   /* Long Term */


/*section styles */

/*.tabs-wrapper {*/
/*    display: flex;*/
/*    gap: 0.75rem;*/
/*    margin-top: 1.5rem;*/
/*    flex-wrap: wrap;*/
/*}*/

/*.tab-button {*/
/*    padding: 0.4rem 1rem;*/
/*    border-radius: 0.375rem;*/
/*    background-color: #f8f9fa;*/
/*    color: #333;*/
/*    text-decoration: none;*/
/*    font-weight: 500;*/
/*    border: 1px solid #dee2e6;*/
/*    transition: background-color 0.2s, color 0.2s;*/
/*}*/

/*.tab-button:hover {*/
/*    background-color: #e9ecef;*/
/*    color: #000;*/
/*}*/

/*.tab-button.active {*/
/*    background-color: #0d6efd;*/
/*    color: #fff;*/
/*    border-color: #0d6efd;*/
/*    font-weight: 600;*/
/*}*/
.tab-button.active,
.tabs-wrapper .tab-button:first-child {
    background-color: #0d6efd;
    color: #fff;
    border-color: #0d6efd;
    font-weight: 600;
}

</style>

    @php
        $hasBasketData = false;
        foreach ($baskets as $group) {
            if ($group->isNotEmpty()) {
                $hasBasketData = true;
                break;
            }
        }
    @endphp

    @if ($hasBasketData)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($baskets as $type => $basketGroup)
                @if ($basketGroup->isNotEmpty())
                    <div class="col">
                        <div class="card h-100 shadow-lg border-0 rounded-3 overflow-hidden animate__animated animate__fadeInUp">
                         
                                          <div class="col d-flex justify-content-center mb-4">
                <div class="card basket-card shadow-lg border-0 animate__animated animate__fadeInUp">
                    
                    <div class="custom-card-header">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            @if($type === 'Intraday')
                                <i class="bi bi-lightning-charge-fill text-primary me-2 fs-5"></i>
                            @elseif($type === 'Short Term')
                                <i class="bi bi-hourglass-split text-warning me-2 fs-5"></i>
                            @elseif($type === 'Long Term')
                                <i class="bi bi-infinity text-info me-2 fs-5"></i>
                            @endif
                            {{ $type }} Basket
                        </h5>
                        <span class="basket-badge">{{ $basketGroup->count() }} Baskets</span>
                    </div>
            
                   <div class="card-body p-4 bg-white">
                <div id="basket-card" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 " style="display:flex; gap:40px; flex-wrap: wrap; ">
                
                    <div class="col">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($basketGroup as $basket)
                <div class="col d-flex" style="">
                    <div class="card border-0 shadow-sm rounded-4 w-100 h-100" style="min-width: 300px; max-width: 500px;min-height:400px; transition: all 0.3s ease; margin: 20px; 10px;">
                        <div class="card-body d-flex flex-column justify-content-between p-4 bg-white" style="height: 100%;">
                            <div class="mb-3">
                                <!-- Header Info -->
                                <div class="d-flex justify-content-between align-items-center mb-2 " style="background-color:#00655F; color:white;padding-left:15px;">
                                    <small class="text-muted fw-medium">
                                        Updated: {{ $basket->updated_at->format('d M Y, h:i A') }}
                                    </small>
                                    <!--<span class="badge bg-secondary-subtle  fw-semibold px-3 py-1">-->
                                    <!--   | ID: {{ $basket->id }}-->
                                    <!--</span>-->
                                </div>
            
                                <hr class="mt-0 mb-3 border-light">
                                
                                <!-- Stock List -->
                                <div class="stock-list" style="padding:10px;">
                                    @forelse ($basket->stocks as $stock)
                                    <div class="py-3  border-bottom border-light"style=" margin-bottom:10px;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong class="text-primary fs-6">{{ $stock->symbol }}</strong>
                                                <span class="badge bg-success-subtle text-success fw-semibold px-2 py-1">
                                                    ₹{{ number_format($stock->target_price, 2) }}
                                                </span>
                                            </div>
                                            <div class="d-flex  justify-content-between text-muted small"style="font-size:12px;">
                                                <span>
                                                    Buy: <span class="fw-semibold text-dark">₹{{ number_format($stock->buy_price, 2) }}</span>
                                                </span>
                                                <span class="fw-semibold text-danger">
                                                    SL: ₹{{ number_format($stock->stop_loss, 2) }}
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @empty
                                                                    <div class="alert alert-info text-center mt-3 mb-0 rounded shadow-sm">
                                                                        No stocks in this basket.
                                                                    </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                            
                                                            <!-- Optional Footer (Add button/info here if needed) -->
                                                            <!-- <div class="text-end mt-auto">
                                                                <a href="#" class="btn btn-outline-primary btn-sm">View Details</a>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </div>
                                              
                                            </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                                </div>
                                            </div>
                                            
                                        </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-warning text-center shadow-sm rounded-lg py-4 border-warning-subtle" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> No market basket data found for the current filters.
                            </div>
                        </div>
                    </div>
                @endif
            </div>

<style>
    /* Custom styles for a cleaner look */
    body {
        background-color: #f8f9fa; /* Light background for the whole page */
    }

    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 0.75rem; /* Equivalent to rounded-xl */
        box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }
   

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        background-color: #f0f8ff; /* A very light blue */
    }

    /* Gradient for card header */
    .bg-gradient-light-blue {
        background: linear-gradient(to right, #e0f2fe, #f0f8ff); /* Light blue gradient */
    }

    /* Input group aesthetics */
    .input-group-text {
        background-color: #e9ecef; /* Light gray for input group labels */
        border-right: none;
    }
    .form-select {
        border-left: none;
    }

    /* Specific stock item styling */
    .stock-item:last-of-type {
        border-bottom: none !important;
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }

    /* Custom badge colors for better visual distinction */
    .badge.bg-primary-light {
        background-color: #cfe2ff !important; /* Bootstrap primary-subtle */
        color: #0d6efd !important;
    }
    .badge.bg-success-light {
        background-color: #d1e7dd !important; /* Bootstrap success-subtle */
        color: #198754 !important;
    }

    /* Hover effect for individual basket items */
    .hover-border-primary:hover {
        border-color: var(--bs-primary) !important; /* Use Bootstrap's primary color */
    }

    /* Basic animation for card entry */
    @keyframes fadeInUpx {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate__fadeInUp {
        animation-name: fadeInUpx;
        animation-duration: 0.7s;
        animation-fill-mode: both;
    }

    /* Ensure icons are aligned well */
    .fs-5 {
        font-size: 1.125rem !important; /* Matching text-lg from previous */
    }
</style>
@endsection