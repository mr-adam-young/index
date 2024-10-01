@extends('layouts.app')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

<div class="container">
    <h1 class="mb-4">Job Status: {{ $job->Title }}</h1>

    <div class="row">
        <!-- Job Overview -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4>Job Overview</h4>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $job->ID }}</p>
                    <p><strong>Title:</strong> {{ $job->Title }}</p>
                    <p><strong>Status:</strong> {{ $job->Status }}</p>
                    <p><strong>Invoice Number:</strong> {{ $job->Invoice }}</p>
                    <p><strong>Last Updated:</strong> {{ $job->lastUpdated }}</p>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h4>Customer Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $job->CustomerName }}</p>
                    <p><strong>Email:</strong> {{ $job->CustomerEmail }}</p>
                    <p><strong>Phone:</strong> {{ $job->CustomerPhone }}</p>
                    <p><strong>Address:</strong> {{ $job->Street }}, {{ $job->City }}, {{ $job->State }}, {{ $job->ZipCode }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Specifications -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>Specifications</h4>
                </div>
                <div class="card-body">
                    <p><strong>Material:</strong> {{ $job->Material }}</p>
                    <p><strong>Color:</strong> {{ $job->Color }}</p>
                    <p><strong>Finish Type:</strong> {{ $job->FinishType }}</p>
                    <p><strong>Length:</strong> {{ $job->Length }} ft</p>
                    <p><strong>Height:</strong> {{ $job->HeightInches }} inches</p>
                </div>
            </div>
        </div>

        <!-- Job Costs and Time -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4>Costs & Time</h4>
                </div>
                <div class="card-body">
                    <p><strong>Estimated Material Cost:</strong> ${{ $job->EstMaterialCost }}</p>
                    <p><strong>Estimated Hours:</strong> {{ $job->EstimatedHours }} hours</p>
                    <p><strong>Actual Hours:</strong> {{ $job->ActualHours }} hours</p>
                    <p><strong>Profit Margin:</strong> {{ $job->ProfitMargin }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4>Additional Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> {{ $job->Description }}</p>
                    <p><strong>Drawing:</strong> {{ $job->Drawing }}</p>
                    <p><strong>Design ID:</strong> {{ $job->Design }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

</div></div></div>
</div>

@endsection