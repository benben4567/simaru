$(function () {
    'use strict'

    var counterUp = window.counterUp["default"]; // import counterUp from "counterup2"

    var $counters = $(".counter");

    /* Start counting, do this on DOM ready or with Waypoints. */
    $counters.each(function (ignore, counter) {
        counterUp(counter, {
            duration: 1000,
            delay: 16
        });
    });

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    // This will get the first returned node in the jQuery collection.
    var area = new Chart(areaChartCanvas, {
        type: 'bar',
        data: {
            labels: ['Gel 1', 'Gel 2', 'Gel 3', 'Gel 4', 'Gel 5'],
            datasets: [{
                label: 'Validasi',
                backgroundColor: 'rgba(60,141,188,0.3)',
                borderColor: 'rgba(60,141,188,1)',
                borderWidth: 1,
                data: []
            }]
        },
        options: {
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
    })

    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')

    var pie = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#eb34db', '#eb9c34', '#3465eb', '#34eb46', '#9f34eb', '#b8b8b8', '#ffe600', '#a66503', '#02e0c6', '#001dbf', '#14e383', '#d40606']
            }]
        },
        options: {
            legend: {
                display: false,
                position: 'bottom'
            },
            plugins: {
                labels: [
                    {
                        render: 'value',
                        position: 'outside'
                    }
                ]
            }
        }
    })

    //-----------------
    // - END PIE CHART -
    //-----------------

    setTimeout(() => {
        $.ajax({
            type: "GET",
            url: "/chart",
            success: function (response) {
                var data = response.data;

                area.data.datasets[0].data = data.area;
                area.update();

                pie.data.datasets[0].data = data.pie_value;
                pie.data.labels = data.pie_label;
                pie.update();
            }
        });
    }, 500)
})
