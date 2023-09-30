@props([
    'labels',
    'datasets'
])

<canvas
        wire:key="{{ time() }}"
        x-data="{
        chart: null,

        datasets: JSON.parse('{{ json_encode($datasets) }}'),

        getColor() {
            return '#10B981';
        },

        toggleDataset(label) {
            showDataset = localStorage.getItem(label) === null ? true : localStorage.getItem(label) === 'true';

            if (showDataset) {
                this.chart.data.datasets.push(
                    {
                        label: label,
                        data: this.datasets[label],
                        borderWidth: 3,
                        borderColor: this.getColor(),
                        borderDash: false,
                        backgroundColor: 'transparent',
                        pointBackgroundColor: 'transparent',
                        pointBorderColor: 'transparent',
                        yAxisID: label.toLowerCase()
                    },
                );

                this.chart.options.scales.yAxes.push({
                    id: label.toLowerCase(),
                    position: 'left',
                    gridLines: {
                        display: true,
                    },
                    ticks: {
                        fontSize: 12,
                        fontColor: this.getColor(),
                        backgroundColor: '#000'
                    }
                });
            }
            else {
                datasetIndex = this.chart.data.datasets.findIndex(dataset => dataset.label === label);
                scaleIndex = this.chart.options.scales.yAxes.findIndex(scale => scale.id === label.toLowerCase());

                if (datasetIndex > -1) {
                    this.chart.data.datasets.splice(datasetIndex, 1);
                }

                if (scaleIndex > -1) {
                    this.chart.options.scales.yAxes.splice(scaleIndex, 1);
                }
            }

            this.chart.update();
        }
    }"
        x-init="() => {
        chart = new Chart($el, {
            type: 'line',
            data: {
                labels: JSON.parse('{{ json_encode($labels) }}'),
                datasets: [],
            },
            options: {
                legend: {
                    display: false,
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    displayColors: false,
                    titleFontSize: 16,
                    bodyFontSize: 16,
                    yPadding: 12,
                    xPadding: 12,
                    titleMarginBottom: 12,
                    bodySpacing: 12
                },
                scales: {
                    xAxes: [
                        {
                            ticks: {
                                fontSize: 10,
                                fontColor: true ? '#718096' : '#777777',
                                maxTicksLimit: 8
                            },
                            gridLines: {
                                display: false,
                            },
                        },
                    ],
                    yAxes: [
                        // Disable the default y axis.
                        {
                            id: 'y-axis-0',
                            gridLines: {
                                drawBorder: false,
                                drawOnChartArea: false,
                                display: false,
                                drawTicks: false
                            },
                            ticks: {
                                display: false
                            }
                        },
                    ],
                },
            },
        });

        Object.keys(datasets).forEach(label => toggleDataset(label));
    }"
        x-on:toggle-chart.window="toggleDataset($event.detail)"
        class="mt-4 pb-4 cursor-pointer"
        height="130"
>
</canvas>

@once
    @push('scripts')
        {{--        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>--}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    @endpush
@endonce
