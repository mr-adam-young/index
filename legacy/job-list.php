<!-- Main content -->
<section class="content">
    <h1>{{ $title }}</h1>

    @foreach ($list as $job)
        @php
            $warnings = '';
            $material = '';
            $length = '';
            
            // Material
            if (!empty($job['Material'])) {
                $material = "<span class='" . strtolower($job['Material']) . "'>{$job['Material']}</span>";
            } else {
                $warnings .= "<span class='tag'>Unknown material</span>";
            }

            // Length
            if (!empty($job['Length'])) {
                $length = "<span>{$job['Length']} feet.</span>";
            }

            // Time remaining
            if ($job['EstimatedHours'] == 0) {
                $time_remaining = "<span class='tag'>Time and Material</span>";
            } else {
                $percentage = round(($job['ActualHours'] / $job['EstimatedHours']) * 100, 1);
                $time_remaining = "<span>{$job['ActualHours']} / {$job['EstimatedHours']} hours ({$percentage}%)</span>";
            }
        @endphp

        <a class="job_block" id="{{ $job['ID'] }}" href="?job={{ $job['ID'] }}">
            <div class="nameplate">
                <span>
                    <span class="job-id">{{ $job['ID'] }}</span>
                    <span>{{ $job['Title'] }}</span>
                    {!! $material !!}
                </span>
                <span>
                    {!! $time_remaining !!}
                </span>
            </div>
            <div class="job_description" style="clear:both;">
                <span class="tag-dark">{{ $job['StatusName'] }}</span>
                {!! $length !!}
                <span>{!! $warnings !!}</span>
            </div>
        </a>
    @endforeach
</section>
