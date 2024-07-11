<?php require 'includes/main-include.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alpine.js Example</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>
    <div x-data="fetchDataComponent">
        <button @click="fetchData">Fetch Data</button>
        <div x-show="loading">Loading...</div>
        <div x-show="!loading">
            <template x-for="item in data" :key="item.ID">
                <div>
                    <span x-text="item.ID"></span> - <span x-text="item.Title"></span>
                </div>
            </template>
        </div>
    </div>

    <script>
        function fetchDataComponent() {
            return {
                data: [],
                loading: false,
                async fetchData() {
                    this.loading = true;
                    try {
                        const response = await fetch('processing.php?data=active_jobs');
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        this.data = await response.json();
                    } catch (error) {
                        console.error('Error fetching data:', error);
                    } finally {
                        this.loading = false;
                    }
                }
            };
        }
    </script>
</body>
</html>
