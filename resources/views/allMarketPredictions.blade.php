@extends('layouts.dashboardLayout')
@section('title', 'All Market Predictions')
@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-primary fw-bold predictions_heading">All Market Predictions</h3>

    @forelse($predictions as $prediction)
        <div class="card mb-4 shadow-sm prediction-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="card-title text-dark mb-0">{{ $prediction->title }}</h5>
                    <small class="text-muted fst-italic">{{ $prediction->created_at->format('d M Y, H:i') }}</small>
                </div>

                @if($prediction->image_url)
                    <div class="text-center mb-3 mt-3">
                        <img src="{{ asset($prediction->image_url) }}" alt="Prediction Image" class="img-fluid rounded prediction-image">
                    </div>
                @endif

                <p class="card-text text-secondary">{{ $prediction->description }}</p>

                <ul class="list-unstyled small mt-3 border-top pt-3">
                    @if($prediction->range)
                        <li class="mb-1"><strong>Range:</strong> <span class="text-info">{{ $prediction->range }}</span></li>
                    @endif
                    @if($prediction->market_sentiment)
                        <li class="mb-1"><strong>Sentiment:</strong> <span class="text-success">{{ $prediction->market_sentiment }}</span></li>
                    @endif
                    @if($prediction->global_cues)
                        <li class="mb-1"><strong>Global Cues:</strong> <span class="text-muted">{{ $prediction->global_cues }}</span></li>
                    @endif
                    @if($prediction->volatility_alert)
                        <li class="mb-1"><strong>Volatility:</strong> <span class="text-danger fw-bold">{{ $prediction->volatility_alert }}</span></li>
                    @endif
                    @if($prediction->support_levels)
                        <li class="mb-1"><strong>Support:</strong> <span class="text-primary">{{ $prediction->support_levels }}</span></li>
                    @endif
                    @if($prediction->resistance_levels)
                        <li class="mb-1"><strong>Resistance:</strong> <span class="text-danger">{{ $prediction->resistance_levels }}</span></li>
                    @endif
                </ul>
            </div>
            
        </div>
        <hr>
    @empty
        <div class="alert alert-info text-center" role="alert">
            No predictions found. Check back later!
        </div>
    @endforelse
</div>

<style>
.container{
    padding: 15px;
}
    .prediction-card {
        transition: transform 0.2s ease-in-out;
    }

    .prediction-image {
            max-height: 300px;
    object-fit: cover;
    width: 100%;
    border-radius: 8px;
    margin: 10px 0;
    border: 1px solid #ccc;
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