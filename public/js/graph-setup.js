// for bar chart - failed login data
const ctx1 = document.getElementById('failed-login-attempt-chart');

new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['0', '1', '2', '3', '4'],
        datasets: [
            {
                label: 'Total Users',
                data: [65, 59, 80, 81, 56, 55, 40], // Data points for the first line
                borderColor: 'rgba(255, 99, 132, 1)', // Line color
                backgroundColor: '#fdcf01', // Fill color under the line
                fill: false, // Whether to fill under the line
                tension: 0.3
            },
            {
                label: 'New Users',
                data: [28, 48, 40, 19, 86, 27, 90], // Data points for the second line
                borderColor: 'rgba(54, 162, 235, 1)', // Line color
                backgroundColor: '#B9B4B9', // Fill color under the line
                fill: false, // Whether to fill under the line
                tension: 0.3
            },
            {
                label: 'Logins',
                data: [18, 35, 60, 30, 70, 50, 80], // Data points for the third line
                borderColor: 'rgba(75, 192, 192, 1)', // Line color
                backgroundColor: '#DAA50f', // Fill color under the line
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

// for bar chart - user login data
const ctx2 = document.querySelector('.user-login-chart');

new Chart(ctx2, {
    type: 'bar',
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
                data: [30, 70, 50, 80, 18, 35, 60], // Data points for the third line
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

const ctx3 = document.getElementById('successful-logout-chart');

new Chart(ctx3, {
    type: 'bar',
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
                data: [30, 70, 50, 80, 18, 35, 60], // Data points for the third line
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