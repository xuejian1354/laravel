@section('content')

<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>{{ App\Model\Device::where('attr', '!=', 3)->count() }}</h3>
        <p><b>设 备</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-android-bookmark"></i>
      </div>
      <a href="{{ config('cullivebefore.mainrouter') }}/devstats" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
      <div class="inner">
        <h3>{{ App\Model\Area::query()->count() }}</h3>
        <p><b>场 景</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-images"></i>
      </div>
      <a href="{{ config('cullivebefore.mainrouter') }}/areactrl" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
      <div class="inner">
        <h3>{{ App\User::query()->count() }}</h3>
        <p><b>用 户</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-person-stalker"></i>
      </div>
      <a href="{{ config('cullivebefore.mainrouter') }}/curinfo/user" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3>{{ App\Http\Controllers\CulliveBefore\ComputeController::getDeviceUpdateRate() }}<sup style="font-size: 20px">%</sup></h3>

        <p><b>更 新</b></p>
      </div>
      <div class="icon">
        <i class="ion ion-pie-graph"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
</div>

<div class='row'>
  <div class="col-md-6">
    <!-- interactive chart -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <i class="fa fa-bar-chart-o"></i>
        <h3 class="box-title">统计信息</h3>
        <!--div class="box-tools pull-right">
          <div class="btn-group" id="realtime" data-toggle="btn-toggle">
            <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
            <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
          </div>
        </div-->
      </div>
      <div class="box-body">
        <div id="interactive" style="height: 300px; padding: 0px; position: relative;"><canvas class="flot-base" width="908" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 908px; height: 300px;"></canvas><div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);"><div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 21px; text-align: center;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 106px; text-align: center;">10</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 195px; text-align: center;">20</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 283px; text-align: center;">30</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 372px; text-align: center;">40</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 460px; text-align: center;">50</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 549px; text-align: center;">60</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 637px; text-align: center;">70</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 726px; text-align: center;">80</div><div class="flot-tick-label tickLabel" style="position: absolute; max-width: 82px; top: 282px; left: 814px; text-align: center;">90</div></div><div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;"><div class="flot-tick-label tickLabel" style="position: absolute; top: 269px; left: 13px; text-align: right;">0</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 215px; left: 7px; text-align: right;">20</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 161px; left: 7px; text-align: right;">40</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 108px; left: 7px; text-align: right;">60</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 54px; left: 7px; text-align: right;">80</div><div class="flot-tick-label tickLabel" style="position: absolute; top: 1px; left: 1px; text-align: right;">100</div></div></div><canvas class="flot-overlay" width="908" height="300" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 908px; height: 300px;"></canvas></div>
      </div>
      <!-- /.box-body-->
    </div>
    <!-- /.box -->
  </div>

  <div class="col-md-6">
    <!-- The time line -->
    <ul class="timeline">
      @foreach($record->data as $redata)
        @if(($day = date('j M. Y', strtotime($redata->updated_at))) != (isset($exday)?$exday:'') )
          <!-- timeline time label -->
          <li class="time-label">
            <span class="bg-red">{{ $exday=$day, $day }}</span>
          </li>
      <!-- /.timeline-label -->
        @endif
      
      <!-- timeline item -->
      <li>
        <i class="{{ $redata->rel_action->img }}"></i>
        <div class="timeline-item">
          <span class="time"><i class="fa fa-clock-o"></i>{{ date('H:i:s', strtotime($redata->updated_at)) }}</span>
          <h3 class="timeline-header no-border">{{ $redata->content }}</h3>
		  @if(isset($redata->data))
          <div class="timeline-body">{{ $redata->data }}</div>
          @endif
        </div>
      </li>
      <!-- END timeline item -->
	  @endforeach
      <li>
        <i class="fa fa-clock-o bg-gray"></i>
        @if($record->hasmore)
        <div class="timeline-item">
          <a href="#" class="btn btn-primary btn-xs pull-right">more</a>
        </div>
        @endif
      </li>
    </ul>
    <!-- END time line -->
  </div>
</div><!-- /.row -->
@endsection

@section('conscript')
<script src="{{ asset('/adminlte/plugins/flot/jquery.flot.min.js') }}"></script>
<script>
  $(function () {
    /*
     * Flot Interactive Chart
     * -----------------------
     */
    // We use an inline data source in the example, usually data would
    // be fetched from a server
    var data = [], totalPoints = 100;

    function getRandomData() {

      if (data.length > 0)
        data = data.slice(1);

      // Do a random walk
      while (data.length < totalPoints) {

        var prev = data.length > 0 ? data[data.length - 1] : 50,
            y = prev + Math.random() * 10 - 5;

        if (y < 0) {
          y = 0;
        } else if (y > 100) {
          y = 100;
        }

        data.push(y);
      }

      // Zip the generated y values with the x values
      var res = [];
      for (var i = 0; i < data.length; ++i) {
        res.push([i, data[i]]);
      }

      return res;
    }

    var interactive_plot = $.plot("#interactive", [getRandomData()], {
      grid: {
        borderColor: "#f3f3f3",
        borderWidth: 1,
        tickColor: "#f3f3f3"
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color: "#3c8dbc"
      },
      lines: {
        fill: true, //Converts the line chart to area chart
        color: "#3c8dbc"
      },
      yaxis: {
        min: 0,
        max: 100,
        show: true
      },
      xaxis: {
        show: true
      }
    });

    var updateInterval = 500; //Fetch data ever x milliseconds
    var realtime = "on"; //If == to on then fetch data every x seconds. else stop fetching
    function update() {

      interactive_plot.setData([getRandomData()]);

      // Since the axes don't change, we don't need to call plot.setupGrid()
      interactive_plot.draw();
      if (realtime === "on")
        setTimeout(update, updateInterval);
    }

    //INITIALIZE REALTIME DATA FETCHING
    if (realtime === "on") {
      update();
    }
    //REALTIME TOGGLE
    $("#realtime .btn").click(function () {
      if ($(this).data("toggle") === "on") {
        realtime = "on";
      }
      else {
        realtime = "off";
      }
      update();
    });
    /*
     * END INTERACTIVE CHART
     */


    /*
     * LINE CHART
     * ----------
     */
    //LINE randomly generated data

    var sin = [], cos = [];
    for (var i = 0; i < 14; i += 0.5) {
      sin.push([i, Math.sin(i)]);
      cos.push([i, Math.cos(i)]);
    }
    var line_data1 = {
      data: sin,
      color: "#3c8dbc"
    };
    var line_data2 = {
      data: cos,
      color: "#00c0ef"
    };
    $.plot("#line-chart", [line_data1, line_data2], {
      grid: {
        hoverable: true,
        borderColor: "#f3f3f3",
        borderWidth: 1,
        tickColor: "#f3f3f3"
      },
      series: {
        shadowSize: 0,
        lines: {
          show: true
        },
        points: {
          show: true
        }
      },
      lines: {
        fill: false,
        color: ["#3c8dbc", "#f56954"]
      },
      yaxis: {
        show: true,
      },
      xaxis: {
        show: true
      }
    });
    //Initialize tooltip on hover
    $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
      position: "absolute",
      display: "none",
      opacity: 0.8
    }).appendTo("body");
    $("#line-chart").bind("plothover", function (event, pos, item) {

      if (item) {
        var x = item.datapoint[0].toFixed(2),
            y = item.datapoint[1].toFixed(2);

        $("#line-chart-tooltip").html(item.series.label + " of " + x + " = " + y)
            .css({top: item.pageY + 5, left: item.pageX + 5})
            .fadeIn(200);
      } else {
        $("#line-chart-tooltip").hide();
      }

    });
    /* END LINE CHART */

    /*
     * FULL WIDTH STATIC AREA CHART
     * -----------------
     */
    var areaData = [[2, 88.0], [3, 93.3], [4, 102.0], [5, 108.5], [6, 115.7], [7, 115.6],
      [8, 124.6], [9, 130.3], [10, 134.3], [11, 141.4], [12, 146.5], [13, 151.7], [14, 159.9],
      [15, 165.4], [16, 167.8], [17, 168.7], [18, 169.5], [19, 168.0]];
    $.plot("#area-chart", [areaData], {
      grid: {
        borderWidth: 0
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color: "#00c0ef"
      },
      lines: {
        fill: true //Converts the line chart to area chart
      },
      yaxis: {
        show: false
      },
      xaxis: {
        show: false
      }
    });

    /* END AREA CHART */

    /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
      data: [["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9]],
      color: "#3c8dbc"
    };
    $.plot("#bar-chart", [bar_data], {
      grid: {
        borderWidth: 1,
        borderColor: "#f3f3f3",
        tickColor: "#f3f3f3"
      },
      series: {
        bars: {
          show: true,
          barWidth: 0.5,
          align: "center"
        }
      },
      xaxis: {
        mode: "categories",
        tickLength: 0
      }
    });
    /* END BAR CHART */

    /*
     * DONUT CHART
     * -----------
     */

    var donutData = [
      {label: "Series2", data: 30, color: "#3c8dbc"},
      {label: "Series3", data: 20, color: "#0073b7"},
      {label: "Series4", data: 50, color: "#00c0ef"}
    ];
    $.plot("#donut-chart", donutData, {
      series: {
        pie: {
          show: true,
          radius: 1,
          innerRadius: 0.5,
          label: {
            show: true,
            radius: 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: false
      }
    });
    /*
     * END DONUT CHART
     */

  });

  /*
   * Custom Label formatter
   * ----------------------
   */
  function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
        + label
        + "<br>"
        + Math.round(series.percent) + "%</div>";
  }
</script>
@endsection

@extends(config('cullivebefore.mainrouter').'.admin.dashboard')