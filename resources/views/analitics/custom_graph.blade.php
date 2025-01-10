<div class="p-4 w-full">
    <div class="graphs-container">
        @foreach ($graphResults as $graph)
        <div id="graph-data-{{ $graph['id'] }}">
            @include('analitics.custom_filter', ['graph' => json_encode($graph), 'allactivityGroups' => json_encode($allactivityGroups)])
            @if(empty($graph['activityGroups']) || empty($graph['activityType']) || empty($graph['type']))
            <div class="h-full suggestion rounded mt-6 bg-c-graph-gray">
                @if($graph['default'] != 1)
                <div class="pr-3 pt-4 flex gap-3 justify-end">
                    <i class="ri-close-circle-fill ri-lg close-graph" data-graph-id="{{ $graph['id'] }}"></i>
                </div>
                @else
                <div class="pr-6 pt-7 flex gap-3 justify-end"></div>
                @endif
                <div class="h-full flex items-center justify-center text-center">
                    <h1 class="text-4xl text-c-black">Select Graph From Filter</h1>
                </div>

            </div>
            @else
            <div class="graph-area rounded mt-6 relative" id="graph-{{ $graph['id'] }}">
                <div class="graph-hidden-area">
                    @if($graph['default'] != 1)
                    <div class="pr-3 pt-4 flex gap-3 justify-end">
                        <!-- <i class="ri-eye-off-fill ri-lg" id="md-trigger"></i> -->
                        <!-- <i class="ri-eye-fill ri-lg hidden" id="md-close"></i> -->
                        <i class="ri-close-circle-fill ri-lg close-graph" data-graph-id="{{ $graph['id'] }}"></i>
                    </div>
                    @endif

                    <div class="graph-show">
                        <div id="user-login-over-time-graph-{{ $graph['id'] }}" class="">
                            <div class="text-c-black font-medium text-xl text-center py-3">
                                <h3>{{ $graph['label']?? 'Default Name' }} Graph</h3>
                            </div>
                            <div class="pt-2">
                                <div style="height: 370px;" id="chartContainer-{{ $graph['id'] }}">
                                    <canvas id="chartId-{{ $graph['id'] }}" class="user-login-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/helpers.esm.min.js">
</script>

<script defer>
    document.getElementById("md-trigger").addEventListener("click", function(e) {
        document.getElementById("modal").classList.toggle("graph-show");
        document.getElementById('md-close').classList.remove('hidden')
        document.getElementById('md-trigger').classList.add('hidden')
        e.preventDefault();
    });

    document.getElementById('md-close').addEventListener("click", function(e) {
        document.getElementById("modal").classList.toggle("graph-show");
        document.getElementById('md-close').classList.add('hidden')
        document.getElementById('md-trigger').classList.remove('hidden')
        e.preventDefault();
    })



    let currentSlide = 1;
    const totalSlides = 10;

    // Function to update the slide indicator and navigation logic
    function updateSlideIndicator(slide) {
        document.getElementById('slide-indicator').textContent = `${slide}/${totalSlides}`;
    }

    updateSlideIndicator(currentSlide);

    document.getElementById('prev-slide').addEventListener('click', function(e) {
        e.stopPropagation();
        if (currentSlide > 1) {
            currentSlide--;
            updateSlideIndicator(currentSlide);
        }
    });

    document.getElementById('next-slide').addEventListener('click', function(e) {
        e.stopPropagation();
        if (currentSlide < totalSlides) {
            currentSlide++;
            updateSlideIndicator(currentSlide);
        }
    });

    // Event listener to close modal when clicking outside
    document.querySelector('.md-overlay').addEventListener('click', function(e) {
        document.getElementById('modal').classList.remove('graph-show');
        document.getElementById('md-trigger').classList.remove('hidden')
        document.getElementById('md-close').classList.add('hidden')
    });

    document.getElementById('modal').addEventListener('click', function(e) {
        e.stopPropagation();
    });
</script>


<script>
    var graphResults = @json($graphResults);
    console.log(graphResults);
    graphResults.forEach(function(graph) {
        var labels = graph.getLabels; //users name
        var data = graph.getData; //counts
        var chartType = (graph.type === 'area') ? 'line' : graph.type;
        // var chartType = graph.type; //graph type
        var getLabelName = graph.label + " Counts"; // label name

        // var labelsOne = graph.getLabelsOne;
        var dataOne = graph.getDataOne;
        var chartTypeOne = (graph.typeOne === 'area') ? 'line' : graph.typeOne;
        // var chartTypeOne = graph.typeOne;
        var getLabelNameOne = graph.labelOne + " Counts";

        // if (labels != '' && data != '' && chartType != '') {

        console.log("Chart Type for Dataset 1: ", chartType);
        console.log("Fill for Dataset 1: ", graph.fill);
        console.log("Chart Type for Dataset 2: ", chartTypeOne);
        console.log("Fill for Dataset 2: ", graph.fillOne);
        // const ctx2 = document.querySelector('.user-login-chart');
        var ctx2 = document.getElementById("chartId-" + graph.id);

        new Chart(ctx2, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                        type: chartType,
                        label: getLabelName,
                        data: data,
                        borderColor: 'rgba(255, 99, 132, 1)', // Line color
                        backgroundColor: 'rgba(255, 99, 132, 0.2)', // Fill color under the line
                        fill: graph.fill, // Whether to fill under the line
                        tension: 0.4
                    },
                    {
                        type: chartTypeOne,
                        label: getLabelNameOne,
                        data: dataOne,
                        borderColor: 'rgba(54, 162, 235, 1)', // Line color
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Fill color under the line
                        fill: graph.fillOne, // Whether to fill under the line
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
        // } 
    });
</script>