@extends('layouts.dashboardLayout')
@section('title', 'All Strategies')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-primary fw-bold">All Strategy Updates</h3>

    @forelse($latestStrategies as $strategy)
        <div class="card mb-4 shadow-sm strategy-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="card-title text-dark mb-0">{{ $strategy->title }}</h5>
                    <small class="text-muted fst-italic">{{ $strategy->created_at->format('d M Y, H:i') }}</small>
                </div>

                @if($strategy->image_url)
                    <div class="text-center mb-3">
                        <img src="{{ asset($strategy->image_url) }}" alt="Strategy Image" class="img-fluid rounded strategy-image">
                    </div>
                @endif

                <p class="card-text text-secondary">{{ $strategy->description }}</p>
            </div>
        </div>
        
        <hr>
    @empty
        <div class="alert alert-info text-center" role="alert">
            No strategies found. Check back later!
        </div>
    @endforelse
</div>

<style>
.container{
    padding: 15px;
}
    .strategy-card {
        border-left: 5px solid #17a2b8; /* A subtle border to the left, changed color */
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .strategy-image {
        max-height: 250px;
        object-fit: cover;
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,.08); /* Subtle shadow for images */
    }
    .card-title {
        color: rgb(74 222 128 / var(--tw-text-opacity, 1));;
    }
    
    .card-text {
        line-height: 1.6; /* Improve readability of description */
    }
    .list-unstyled li {
        padding-left: 0.5rem; /* Indent list items slightly */
    }
    .predictions_heading {
    font-size: 26px;
    margin-bottom: 15px;
}
.card  {
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    padding: 10px;
    border-radius: 10px;
    margin:  10px 0;
}

</style>
@endsection