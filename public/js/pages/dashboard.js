$(function () {
    'use strict'

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
        labels: ['Gel 1', 'Gel 2', 'Gel 3', 'Gel 4', 'Gel 5'],
        datasets: [{
            label: 'Validasi',
            backgroundColor: 'rgba(60,141,188,0.3)',
            borderColor: 'rgba(60,141,188,1)',
            borderWidth: 1,
            data: [28, 48, 40, 19, 86, 27, 90]
        }]
    }

    var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false
        },
        plugins: {
            labels: {
                render: 'value'
            }
        }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
        type: 'bar',
        data: areaChartData,
        options: areaChartOptions
    })

    //-------------
    // - PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = {
        labels: [
            'Chrome',
            'IE',
            'FireFox',
            'Safari',
            'Opera',
            'Navigator'
        ],
        datasets: [{
            data: [700, 500, 400, 600, 300, 100],
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
        }]
    }
    var pieOptions = {
        legend: {
            display: true,
            position: 'bottom'
        },
        plugins: {
            labels: {
                render: 'value',
                position: 'outside'
            }
        }
    }
    // Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    // eslint-disable-next-line no-unused-vars
    var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions
    })

    //-----------------
    // - END PIE CHART -
    //-----------------

})
