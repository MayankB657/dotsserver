@extends('layouts.backendsettings')
@section('title', 'Activity Reports')
@section('content')

<link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'common.css') }}">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Activity Reports</title>

<style>
  .custom-safety-btn.active {
    border-color: yellow;
    background-color: #f7f7f7;
    color: #333;
  }

  .custom-safety-btn {
    border-color: transparent;
    background-color: #ffffff;
    color: #333;
  }
</style>


<main class="flex w-full h-full cm">

  <!-- main content -->
  <div class="flex-grow border h-full main">
    <div class="flex w-full h-full flex-col content">
      <div class="px-2 lg:px-5 py-6">
        <div class="flex items-center gap-4">
          <i class="ri-settings-3-fill ri-xl"></i>
          <span class="text-lg text-color-nav-black">Activity Reports </span>
        </div>
      </div>

      <!-- top taskbar -->
      <div class="taskbar flex items-center justify-between px-6 py-4">
        <div class="flex items-center gap-2 sm:gap-4 w-full md:w-1/2">
          <div class="flex items-center gap-1 sm:gap-2">
            <span class="text-c-light-black text-sm sm:text-base"> Reports and Analytics </span>
            <i class="ri-arrow-right-line ri-sm sm:ri-lg" style="color: #4D4D4D;"></i>
            <span class="font-semibold text-c-black text-sm sm:text-base"> Activity Reports </span>
          </div>
        </div>
        <div class="flex-grow md:w-1/2 btn-container">
          <div class="flex items-center justify-end gap-2 md:gap-6">

            <button id="remove-btn-graph"
              class="remove-btn-graph flex items-center justify-center gap-2 bg-c-black text-c-yellow px-3 sm:px-4 py-1 sm:py-1.5 rounded-md w-22">
              <i class="ri-close-circle-fill"></i><span class="text-xs sm:text-sm">Reset Graph</span>
            </button>

            <button id="add-btn-graph"
              class="flex items-center justify-center gap-2 bg-c-black text-c-yellow px-3 sm:px-4 py-1 sm:py-1.5 rounded-md w-22">
              <i class="ri-add-circle-fill"></i><span class="text-xs sm:text-sm">Add Graph</span>
            </button>

          </div>
        </div>

      </div>

      <!--content -->
      <div class="overflow-y-scroll scroll relative h-full">
        <div class="graph-modal graph-effect-1" id="modal">
          <div style="height: 400px;">
            <canvas id="successful-logout-chart"></canvas>
          </div>
        </div>

        <div id="graph-container" class="graph-container">
          <!-- show graph  -->
        </div>

        <div class="md-overlay">
          <button class="nav-btn left" id="prev-slide"><i class="ri-arrow-left-wide-line"></i></button>
          <button class="nav-btn right" id="next-slide"><i class="ri-arrow-right-wide-line"></i></button>
          <div class="nav-track" id="nav-track">
            <span id="slide-indicator"></span>
          </div>
        </div>
      </div>
</main>
@endsection

@section('scripts')
<script>
  $(document).ready(function() {

    fetchGraphData();

    //fetch and populate graph
    function fetchAndPopulate(url, data, currentSelectBox, rowID) {
      const nextSelectBoxClass = currentSelectBox.data('next');
      const nextSelectBox = $(`.${nextSelectBoxClass}[data-row="${rowID}"]`);
      if (!nextSelectBox.length) return;
      $.ajax({
        url: url,
        method: 'GET',
        data: data,
        success: function(response) {
          updateGraph(rowID);
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        }
      });
    }

    //fetch graph data
    function fetchGraphData() {
      const url = @json(route('graph.view'));
      $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
          if (response.addGraphDesign === true) {
            $('#graph-container').html(response.html);
            $('.graphs-container').removeClass('grid grid-cols-1 lg:grid-cols-2 gap-2');
          } else {
            $('#graph-container').html(response.html);
            $('.graphs-container').addClass('grid grid-cols-1 lg:grid-cols-2 gap-2');
          }
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        },
      });
    }

    //remove-btn-graph
    $(document).on('click', '#remove-btn-graph', function() {
      removeGraph();
    });

    //remove all graph except default one
    function removeGraph() {
      const url = @json(route('remove.graph'));
      $.ajax({
        url: url,
        method: 'GET',
        success: function(response) {
          if (response.status == true) {
            fetchGraphData();
            // $('#remove-btn-graph').addClass('hidden');
          }
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        },
      });
    }

    //add-btn-graph
    $(document).on('click', '#add-btn-graph', function() {
      // $('.btn-container .remove-btn-graph').removeClass('hidden');
      addGraph();
    });

    //add graph
    function addGraph() {
      let activityGroupId = null,
        activityTypeId = null,
        graphType = null,
        dateType = null,
        flag = null,
        startDate = null,
        endDate = null;

      const url = @json(route('add.graph'));

      $.ajax({
        url: url,
        method: 'GET',
        data: {
          activityGroupId,
          activityTypeId,
          graphType,
          flag,
          startDate,
          endDate,
          dateType,
        },
        success: function(response) {
          if (response.status == true) {
            fetchGraphData();
          }
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        },
      });
    }

    //dynamic select or filters 
    $(document).on('change', '.dynamic-select', function() {
      const currentSelectBox = $(this);
      const selectedValue = currentSelectBox.val();
      const fetchUrl = currentSelectBox.data('fetch-url');
      const rowId = currentSelectBox.data('row');

      if (selectedValue) {
        const requestData = {
          id: selectedValue
        };
        if (fetchUrl) {
          fetchAndPopulate(fetchUrl, requestData, currentSelectBox, rowId);
        } else {
          updateGraph(rowId);
        }
        // fetchGraphData();
      } else {
        const nextSelectBoxClass = currentSelectBox.data('next');
        $(`.${nextSelectBoxClass}[data-row="${rowId}"]`).empty();
        $(`.${nextSelectBoxClass}[data-row="${rowId}"]`).nextAll('select').empty();
      }
    });

    //custom datetype dropdown
    $(document).on('change', '.dateTypeDropdown', function() {
      const rowId = $(this).data('row');
      const dateType = $(this).val();
      if (dateType === 'Custom Date') {
        $(`.customDateInputs[data-row="${rowId}"]`).removeClass('hidden');
        updateGraph(rowId);
        fetchGraphData();
      } else {
        $(`.customDateInputs[data-row="${rowId}"]`).addClass('hidden');
      }
    });

    //datetype dropdown
    $(document).on('change', '.dateTypeDropdown', function() {
      const rowId = $(this).data('row');
      console.log(rowId);
      updateGraph(rowId);
    });

    //custom date type dropdown
    $(document).on('change', '.startdate, .enddate', function() {
      const rowId = $(this).data('row');
      const startDate = $(`.startdate[data-row="${rowId}"]`).val();
      const endDate = $(`.enddate[data-row="${rowId}"]`).val();
      console.log(startDate);
      console.log(endDate);
      if (startDate && endDate) {
        updateGraph(rowId);
      }
    });

    //update graph
    function updateGraph(filterRow) {
      let activityGroupId = null,
        activityTypeId = null,
        graphType = null,
        dateType = null,
        flag = null,
        startDate = null,
        endDate = null;
      graphId = filterRow;

      if (filterRow) {
        activityGroupId = $(`.actGroupDropdown[data-row="${filterRow}"]`).val();
        activityTypeId = $(`.actTypeDropdown[data-row="${filterRow}"]`).val();
        graphType = $(`.graphTypeDropdown[data-row="${filterRow}"]`).val();
        dateType = $(`.dateTypeDropdown[data-row="${filterRow}"]`).val();
        flag = $(`.flag[data-row="${filterRow}"]`).val();
        startDate = $(`.startdate[data-row="${filterRow}"]`).val();
        endDate = $(`.enddate[data-row="${filterRow}"]`).val();
      }

      const url = @json(route('update.graph'));

      $.ajax({
        url: url,
        method: 'GET',
        data: {
          activityGroupId,
          activityTypeId,
          graphType,
          flag,
          startDate,
          endDate,
          dateType,
          graphId
        },
        success: function(response) {
          fetchGraphData();
        },
        error: function(xhr) {
          console.error(xhr.responseText);
        },
      });
    }

    //close graph 
    $(document).on('click', '#graph-container .close-graph', function(e) {
      e.stopPropagation();
      var graphId = this.getAttribute('data-graph-id');

      fetch(`delete-graph/${graphId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            fetchGraphData();
            // $(`#graph-container #graph-data-${graphId}`).remove();
          } else {
            console.error(data.message || 'Failed to delete graph');
          }
        })
        .catch(error => console.error('Error:', error));
    });

  });
</script>
@endsection