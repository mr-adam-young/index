@extends('layouts.app')

@section('content')

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

<section class="content">

<section class="major">

<h1>
        Creating New Job
</h1>

    <form action="{{ route('jobs.store') }}" method="post">
    @csrf

    <ul>
        <li><label>Job Title <input type="text" name="Title" maxlength="50" value="{{ $job->Title }}"/></label></li>
        <li><label>Job Number <input type="text" name="ID" maxlength="50" value="{{ $job->ID }}" /></label></li>
    </ul>
    <h3>Customer Contact Information</h3>
    <ul>
        <li><label>Name <input type="text" name="CustomerName" maxlength="50" value="{{ $job->CustomerName }}" /></label></li>
        <li><label>Email <input type="email" name="CustomerEmail" maxlength="50" value="{{ $job->CustomerEmail }}" /></label></li>
        <li><label>Phone Number <input type="text" name="CustomerPhone" maxlength="50" value="{{ $job->CustomerPhone }}" /></label></li>
    </ul>
    <ul>
        <li><label>Street <input type="text" name="Street" maxlength="50" value="{{ $job->Street }}" /></label></li>
        <li><label>City <input type="text" name="City" maxlength="50" value="{{ $job->City }}" /></label></li>
        <li><label>State <input type="text" name="State" maxlength="2" value="{{ $job->State }}" /></label></li>
        <li><label>ZipCode <input type="text" name="ZipCode" maxlength="50" value="{{ $job->ZipCode }}" /></label></li>
    </ul>

    <h3>Project Details</h3>

    <ul>
        <li><label>Total Length (ft.) <input type="number" name="Length" maxlength="5" value="{{ $job->Length }}" /></label></li>
        <li><label>Material <input type="text" name="Material" maxlength="20" value="{{ $job->Material }}" /></label></li>
        <li><label>Color <input type="text" name="Color" maxlength="20" value="{{ $job->Color }}" /></label></li>
        <li><label>Finish Type <input type="text" name="FinishType" maxlength="30" value="{{ $job->FinishType }}" /></label></li>
    </ul>

    <h3>Structure</h3>

    <ul>
        <li><label>Posts (in.) <input type="number" name="PostSize" maxlength="5" value="{{ $job->PostSize }}" step="0.01" /></label></li>
        <li><label>Pickets (in.) <input type="number" name="PicketSize" maxlength="5" value="{{ $job->PicketSize }}" step="0.01" /></label></li>
        <li><label>Horizontals (in.) <input type="number" name="ChannelSize" maxlength="5" value="{{ $job->ChannelSize }}" step="0.01" /></label></li>
        <li><label>Estimated Material Cost
            <input type="text" name="EstMaterialCost" value="{{ $job->EstMaterialCost }}"> 
            </label></li>
    </ul>
    <ul>
        <li><label for="Description">Project Description <textarea name="Description">{{ $job->Description }}</textarea></label></li>
        <li><label for="EstMaterialDesc">Parts List <textarea name="EstMaterialDesc">{{ $job->EstMaterialDesc }}</textarea></label></li>
    </ul>

    <button type="submit">Apply</button>

</form>

</section>

<script>
$(document).ready(function(){

    $(".invoice_submit").click(function(){
        var localTarget = $(this);
        $.post("{{ route('invoices.store') }}", {
            job_id: $("#job_id").val(),
            cost: $("#cost").val(),
            description: $("#description").val(),
            vendor: $("#vendor").val(),
            _token: '{{ csrf_token() }}'
        }, function(data) { 
            $("#invoice_table").append("<tr id='" + data.id + "'><td>" + data.cost + "</td><td>" + data.description + "</td><td>" + data.vendor + "</td><td><button type='button' class='remove_invoice'>Remove</button></td></tr>");
            $("#cost").val("");
            $("#description").val("");
            $("#vendor").val("");
        }); 
    });

    $("body").on("click", ".remove_invoice", function(){
        var localTarget = $(this);
        $.ajax({
            url: '{{ url("invoices") }}/' + $(this).closest('tr').attr('id'),
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(result) {
                localTarget.closest('tr').remove();
            }
        });
    });

    $(".estimate_submit").click(function(){
        var localTarget = $(this);
        $.post("{{ route('laborEstimates.store') }}", {
            job_id: $("#estimate_job_id").val(),
            hours: $("#estimate_hours").val(),
            labor_type_id: $("#estimate_labor_type").val(),
            _token: '{{ csrf_token() }}'
        }, function(data) { 
            $("#estimate_table").append("<tr id='" + data.id + "'><td>" + data.labor_type + "</td><td>" + data.hours + "</td><td><button type='button' class='remove_estimate'>Remove</button></td></tr>");
            $("#estimate_hours").val("");
        }); 
    });

    $("body").on("click", ".remove_estimate", function(){
        var localTarget = $(this);
        $.ajax({
            url: '{{ url("laborEstimates") }}/' + $(this).closest('tr').attr('id'),
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(result) {
                localTarget.closest('tr').remove();
            }
        });
    });

    $(".costing_estimates_submit").click(function(){
        var localTarget = $(this);
        $.post("{{ route('costingEstimates.store') }}", {
            job_id: $("#costing_estimates_job_id").val(),
            cost: $("#costing_estimates_cost").val(),
            description: $("#costing_estimates_description").val(),
            vendor: $("#costing_estimates_vendor").val(),
            _token: '{{ csrf_token() }}'
        }, function(data) { 
            $("#costing_estimates_table").append("<tr id='" + data.id + "'><td>" + data.cost + "</td><td>" + data.description + "</td><td>" + data.vendor + "</td><td><button type='button' class='costing_estimates_remove'>Remove</button></td></tr>");
            $("#costing_estimates_cost").val("");
            $("#costing_estimates_description").val("");
            $("#costing_estimates_vendor").val("");
        }); 
    });

    $("body").on("click", ".costing_estimates_remove", function(){
        var localTarget = $(this);
        $.ajax({
            url: '{{ url("costingEstimates") }}/' + $(this).closest('tr').attr('id'),
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(result) {
                localTarget.closest('tr').remove();
            }
        });
    });
});
</script>

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