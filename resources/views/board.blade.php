<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Production Board</title>
    <!-- Include Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="css/production-board.css">
    <!-- <script src="https://code.jquery.com/jquery-latest.min.js"></script> -->

</head>
<body>

<div x-data="productionBoard" x-init="init()" id="dynamic">
    <!-- Jobs will be rendered here -->
    <template x-for="(job, index) in displayedJobs" :key="index">
        <div :class="job.Appearance">
            <div class="job">
                <span class="job-id" x-text="job.ID"></span> <span x-text="job.Title"></span>
                <div class="fabhr" x-text="job.HoursDifferenceText"></div>
            </div>
            <div>
                <div class="description">
                    <span class="orange">
                        <span x-text="job.StatusName"></span> at <span x-text="formatDate(job.lastUpdated)"></span>
                    </span>
                    <br>
                    <span x-text="job.Description"></span>
                </div>
            </div>
            <div class="quotebar" style="position:relative;">
                <div class="progress" :style="job.progressStyle"></div>
                <div class="target_profit" style="border-right:6px solid #000; width:70%; position: absolute; top:0; left:0; z-index:5; height:100%; background-color:#666;"></div>
            </div>
        </div>
    </template>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('productionBoard', () => ({
    data: [],  // Initialize to avoid undefined
    perPage: 4,
    position: 0,
    displayedJobs: [],
    TargetProfitMargin: 0.2,
    intervalId: null,

    init() {
        this.fetchData().then(() => {
            // Ensure turnPage runs only after data is fetched
            this.turnPage();
            this.intervalId = setInterval(() => this.turnPage(), 12000);
        });
    },

    async fetchData() {
        try {
            const response = await fetch('/api/jobs/active');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const rawData = await response.json();
            console.log('Fetched Data:', rawData);  // Ensure data is correct

            this.data = Array.isArray(rawData) ? rawData : [];
        } catch (error) {
            console.error('Error fetching data:', error);
            this.data = [];  // Set fallback data if fetch fails
        }
    },

    turnPage() {
        console.log('Turning page, Data Length:', this.data.length);  // Debugging
        if (!Array.isArray(this.data)) {
            console.warn('Data is not an array.');
            this.data = [];  // Ensure it's an array
        }

        if (this.position >= this.data.length) {
            this.position = 0;
        }

        const BreakEvenRatio = 1 + (this.TargetProfitMargin / (1 - this.TargetProfitMargin));
        this.displayedJobs = [];

        for (let i = 0; i < this.perPage; i++) {
            const cursor = this.position + i;
            if (cursor >= this.data.length) break;

            const val = this.data[cursor];

            const Appearance = val.Status > 22 ? 'container' : 'container-inactive';
            const Progress = val.ActualHours / (val.EstimatedHours * BreakEvenRatio);
            let HoursDifference = val.EstimatedHours - val.ActualHours;
            let HoursDifferenceText = '';

            if (val.EstimatedHours === 0) {
                HoursDifferenceText = `Time and Material`;
            } else {
                HoursDifferenceText = HoursDifference < 0 ?
                    `${Math.abs(HoursDifference)} hr. over target` :
                    `${HoursDifference} hr. remain`;
            }

            const progressStyle = `
                position: absolute;
                top: 0;
                left: 0;
                z-index: 10;
                width: ${Progress * 100}%;
                background-color: rgb(${this.WarningColor(Progress).join(',')});
            `;

            this.displayedJobs.push({
                ...val,
                Appearance,
                HoursDifferenceText,
                progressStyle,
            });
        }

        this.position += this.perPage;
    },

    formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        if (isNaN(date)) return 'Invalid date';

        const options = { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit', 
            hour12: true 
        };
        return date.toLocaleDateString(undefined, options);
    },

    WarningColor(ratio) {
        if (ratio < 0.7) {
            return [parseInt((ratio / 0.7) * 256), 256, 0];
        } else if (ratio < 1) {
            return [256, parseInt((1 - ((ratio - 0.7) / 0.3)) * 256), 0];
        } else {
            return [138, 7, 7];
        }
    },
}));
});
</script>

</body>
</html>