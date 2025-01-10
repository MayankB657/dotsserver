<div class="p-4 w-full">
  <div class="graphs-container ">
    @foreach ($graphResults as $graph)
    <div id="graph-data-{{ $graph['id'] }}">
      @include('analitics.filter', ['graph' => json_encode($graph), 'allactivityGroups' => json_encode($allactivityGroups)])
      @if(empty($graph['activityGroups']) || empty($graph['activityType']) || empty($graph['type']))
      <div class=" h-full suggestion bg-c-graph-gray rounded mt-6">
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
      <div class="graph-area rounded mt-6 relative showGraph" id="graph-{{ $graph['id'] }}">
        <div class="graph-hidden-area">
          @if($graph['default'] != 1)
          <div class="pr-3 pt-4 flex gap-3 justify-end">
            <i class="ri-close-circle-fill ri-lg close-graph" data-graph-id="{{ $graph['id'] }}"></i>
          </div>
          @else
          <div class="pr-6 pt-7 flex gap-3 justify-end"></div>
          @endif
          <div class="graph-show">
            <div id="user-login-over-time-graph-{{ $graph['id'] }}">
              <div class="text-c-black font-medium text-xl text-center py-3">
                <h3>{{ $graph['name']?? 'Default Name' }} Graph</h3>
              </div>
              <div class="pt-2">
                <div style="height: 370px;" id="chartContainer-{{ $graph['id'] }}">
                  <canvas id="chartId-{{ $graph['id'] }}" width="500" height="250"></canvas>
                </div>
              </div>
              <div class="text-c-black font-normal text-lg text-center py-3"></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.1.1/helpers.esm.min.js"></script>

<script>
  var graphResults = @json($graphResults);
  graphResults.forEach(function(graph) {
    var labels = graph.getLabels;
    var data = graph.getData;

    // var chartType = graph.type;
    var getLabelName = graph.name + " Counts";
    var chartType = (graph.type === 'area') ? 'line' : graph.type;

    if (labels != '' && data != '' && chartType != '') {
      var backgroundColors = ['yellow', 'aqua', 'pink', 'lightgreen', 'lightblue', 'gold'];
      var borderColors = ['red', 'blue', 'fuchsia', 'green', 'navy', 'black'];

      var chartCanvas = document.getElementById("chartId-" + graph.id).getContext("2d");
      new Chart(chartCanvas, {
        type: chartType,
        data: {
          labels: labels,
          datasets: [{
            label: getLabelName,
            data: data,
            backgroundColor: backgroundColors.slice(0, data.length),
            borderColor: borderColors.slice(0, data.length),
            borderWidth: 2,
            fill: graph.fill, // Whether to fill under the line
            tension: 0.4
          }]
        },
        options: {
          responsive: false,
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });
    }
  });
</script>