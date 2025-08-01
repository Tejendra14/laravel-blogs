@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    
    <!-- Stats Cards -->
    <div class="row mt-4">
        @foreach($stats as $key => $stat)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ $stat['color'] }} shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                                {{ str_replace('_', ' ', ucfirst($key)) }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stat['count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-{{ $stat['icon'] }} fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection