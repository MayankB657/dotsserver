
<script defer>

        const ctx = document.getElementById('usage-ratio-donut');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    'Users',
                    'Group',
                    'Others'
                ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [{{ $chartData->sizeUse }}, 50, 100],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    title: "File Usage Ratio",
                }
            }
        });

        // for line chart - user data
        const ctx2 = document.getElementById('user-data-chart');
        
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [
                {
                    label: 'Total Users',
                    data: [65, 59, 80, 81, 56, 55, 40], // Data points for the first line
                    borderColor: 'rgba(255, 99, 132, 1)', // Line color
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Fill color under the line
                    fill: false, // Whether to fill under the line
                    tension: 0.3
                },
                {
                    label: 'New Users',
                    data: [28, 48, 40, 19, 86, 27, 90], // Data points for the second line
                    borderColor: 'rgba(54, 162, 235, 1)', // Line color
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Fill color under the line
                    fill: false, // Whether to fill under the line
                    tension: 0.3
                },
                {
                    label: 'Logins',
                    data: [18, 35, 60, 30, 70, 50, 80], // Data points for the third line
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color under the line
                    fill: false, // Whether to fill under the line
                    tension: 0.3
                }
            ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                x: {
                    beginAtZero: true // Ensures the x-axis starts at zero
                },
                y: {
                    beginAtZero: true // Ensures the y-axis starts at zero
                }
            }
            }
        });
    
        // for line chart - space usage
        const ctx3 = document.getElementById('space-usage-chart');
        
        new Chart(ctx3, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [
                {
                    label: 'Total',
                    data: [65, 59, 80, 81, 56, 55, 40], // Data points for the first line
                    borderColor: 'rgba(255, 99, 132, 1)', // Line color
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Fill color under the line
                    fill: true, // Whether to fill under the line
                    tension: 0.4
                },
                {
                    label: 'Actual',
                    data: [28, 48, 40, 19, 86, 27, 90], // Data points for the second line
                    borderColor: 'rgba(54, 162, 235, 1)', // Line color
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Fill color under the line
                    fill: true, // Whether to fill under the line
                    tension: 0.4
                },
                {
                    label: 'User',
                    data: [18, 35, 60, 30, 70, 50, 80], // Data points for the third line
                    borderColor: 'rgba(75, 192, 192, 1)', // Line color
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Fill color under the line
                    fill: true, // Whether to fill under the line
                    tension: 0.4
                },
                {
                    label: 'Group',
                    data: [30, 70, 50, 80, 18, 35, 60 ], // Data points for the third line
                    borderColor: 'rgba(75, 145, 142, 1)', // Line color
                    backgroundColor: 'rgba(75, 145, 142, 0.2)', // Fill color under the line
                    fill: true, // Whether to fill under the line
                    tension: 0.4
                }
            ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                x: {
                    beginAtZero: true // Ensures the x-axis starts at zero
                },
                y: {
                    beginAtZero: true // Ensures the y-axis starts at zero
                }
            }
            }
        });
    </script>