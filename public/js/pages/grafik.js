$(function () {
    Chart.register(ChartDataLabels);

    const Chart1 = new Chart(document.getElementById('chart1'), {
        type: 'pie',
        data: {
            labels: [
                'Sudah',
                'Belum'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [],
                backgroundColor: [
                    'rgb(39, 227, 73, 0.5)',
                    'rgb(227, 42, 39, 0.5)'
                ],
                borderColor: [
                    'rgb(39, 227, 73, 0.7)',
                    'rgb(227, 42, 39, 0.7)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(1) + "%";
                        return `${value} (${percentage})`;
                    },
                    labels: {
                        title: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        }
    });

    const Chart2 = new Chart(document.getElementById('chart2'), {
        type: 'pie',
        data: {
            labels: [
                'Belum',
                'Lunas',
                'Setengah',
            ],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(227, 42, 39, 0.5)',
                    'rgb(39, 227, 73, 0.5)',
                    'rgb(227, 227, 39, 0.5)'
                ],
                borderColor: [
                    'rgb(227, 42, 39, 0.7)',
                    'rgb(39, 227, 73, 0.7)',
                    'rgb(227, 227, 39, 0.7)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: true,
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(1) + "%";
                        return `${value} (${percentage})`;
                    },
                    labels: {
                        title: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        }
    });

    const Chart3 = new Chart(document.getElementById('chart3'), {
        type: 'pie',
        data: {
            labels: [
                'Gel 1',
                'Gel 2',
                'Gel 3',
                'Gel 4',
                'Gel 5'
            ],
            datasets: [{
                data: [],
                backgroundColor: [
                    'rgb(52, 235, 180, 0.5)',
                    'rgb(195, 235, 52, 0.5)',
                    'rgb(227, 227, 39, 0.5)',
                    'rgb(180, 52, 235, 0.5)',
                    'rgb(235, 52, 79, 0.5)'
                ],
                borderColor: [
                    'rgb(52, 235, 180, 0.7)',
                    'rgb(195, 235, 52, 0.7)',
                    'rgb(227, 227, 39, 0.7)',
                    'rgb(180, 52, 235, 0.7)',
                    'rgb(235, 52, 79, 0.7)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        var index = ctx.dataIndex + 1
                        return `Gel ${index} : ${value}`
                    },
                    labels: {
                        title: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        }
    });

    const Chart4 = new Chart(document.getElementById('chart4'), {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Maba',
                data: [],
                backgroundColor: [],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    labels: {
                        title: {
                            font: {
                                weight: 'bold'
                            }
                        },
                    }
                }
            },
        }
    });

    const Chart5 = new Chart(document.getElementById('chart5'), {
        type: 'bar',
        data: {
            labels: [
                'Gel1',
                'Gel2',
                'Gel3',
                'Gel4',
            ],
            datasets: [{
                label: 'Maba',
                data: [],
                backgroundColor: [],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    labels: {
                        title: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        }
    });

    const Chart6 = new Chart(document.getElementById('chart6'), {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Maba',
                data: [],
                backgroundColor: [],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    labels: {
                        title: {
                            font: {
                                weight: 'bold'
                            }
                        },
                    }
                }
            }
        }
    });

    const Chart7 = new Chart(document.getElementById('chart7'), {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Maba',
                data: [],
                backgroundColor: [],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                },
                datalabels: {
                    labels: {
                        title: {
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        }
    });

    $.ajax({
        type: "GET",
        url: "/rekap",
        success: function (response) {

            var pendaftaran = response.data.pendaftaran
            $('.total_pendaftar').html(_.sum(pendaftaran));
            Chart1.data.datasets[0].data = pendaftaran

            var ukt = response.data.ukt
            $('.total_lolos').html(_.sum(ukt));
            Chart2.data.datasets[0].data = ukt

            var gelombang = response.data.gel
            Chart3.data.datasets[0].data = gelombang

            var jalur = response.data.jalur
            var namajalur = response.data.namajalur
            Chart4.data.labels = namajalur
            Chart4.data.datasets[0].data = jalur
            Chart4.data.datasets[0].backgroundColor = poolColors(jalur.length)

            var prodi = response.data.prodi
            var namaprodi = response.data.namaprodi
            Chart5.data.labels = namaprodi
            Chart5.data.datasets[0].data = prodi
            Chart5.data.datasets[0].backgroundColor = poolColors(prodi.length)

            var prodi1 = response.data.prodi1
            var namaprodi1 = response.data.namaprodi1
            Chart6.data.labels = namaprodi1
            Chart6.data.datasets[0].data = prodi1
            Chart6.data.datasets[0].backgroundColor = poolColors(prodi1.length)

            var prodi2 = response.data.prodi2
            var namaprodi2 = response.data.namaprodi2
            Chart7.data.labels = namaprodi2
            Chart7.data.datasets[0].data = prodi2
            Chart7.data.datasets[0].backgroundColor = poolColors(prodi2.length)

            Chart1.update();
            Chart2.update();
            Chart3.update();
            Chart4.update();
            Chart5.update();
            Chart6.update();
            Chart7.update();
        }
    });

    function dynamicColors() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgba(" + r + "," + g + "," + b + ", 0.5)";
    }

    function poolColors(a) {
        var pool = [];
        for(i = 0; i < a; i++) {
            pool.push(dynamicColors());
        }
        return pool;
    }

});
