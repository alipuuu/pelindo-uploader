@extends('layout.v_template')
@section('title', 'Dashboard')
@section('content')
    <section class="content">
     <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>{{$users}}</h3>
              <p>TOTAL USERS</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="/userr" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-teal">
            <div class="inner">
              <h3>{{$server}}</h3>
              <p>TOTAL SERVERS</p>
            </div>
            <div class="icon">
              <i class="fa fa-database"></i>
            </div>
            <a href="/server" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
              <h3>{{$upload}}</h3>
              <p>TOTAL UPLOADS</p>
            </div>
            <div class="icon">
              <i class="fa fa-upload"></i>
            </div>
            <a href="/upload" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner text-center">
              <br>
              <br>
              <h3 id="date-time" style="font-size: 30px"></h3>
            </div>
            <div class="icon">
              <i class=""></i>
            </div>
            <a style="color  :yellow" href="" class="small-box-footer">pastikan tiap hari upload!!!! <i class="fa "></i></a>
          </div>
        </div>
    <section class="content">

      <div class="row">
        <div class="col-md-6">
          <!-- bar chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              {{-- <h3 class="box-title">Total Upload for {{date('d')}} , {{date('D')}}</h3> --}}
              <h3 class="box-title">Total Upload per Tanggal</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <canvas id="barCharttanggal"></canvas>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <!-- line chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              {{-- <h3 class="box-title">Total Upload for {{date('M')}}</h3> --}}
              <h3 class="box-title">Total Upload per Bulan</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
                <canvas id="lineChartbulan"></canvas>
            </div>
          </div>
        </div>
             <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe class="col-md-12" height="500px" id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3958.366203715323!2d112.73093525112151!3d-7.198992494777195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7f8c47b6d765d%3A0xc61b079f5afde6be!2sPT.%20Pelabuhan%20Indonesia%20(Persero)%20Regional%203!5e0!3m2!1sid!2sid!4v1656656874036!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                    <style>.mapouter{position:relative;text-align:center;height:100%;width:100%;}</style>
                    <style>.gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}</style>
                </div>
            </div>
        </div>
    </div>
      </div>
   <script>

    // tanggal
        var tanggal =  document.getElementById('barCharttanggal');
        var barCharttanggal = new Chart( tanggal,{
            type: 'line',
            data : {
                labels: <?php echo $tanggal; ?>,
                datasets :[{
                    label: 'per tanggal',
                    data: <?php echo $uploadtanggal; ?>,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

    //     bulan
        var bulan = document.getElementById('lineChartbulan');
        var lineChartbulan = new Chart( bulan, {
            type: 'line',
            data: {
                labels: <?php echo $bulan; ?>,
                datasets :[{
                    label: 'per bulan',
                    data: <?php echo $uploadbulan; ?>,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

   </script>
   <script>
window.addEventListener("load", () => {
  clock();
  function clock() {
    const today = new Date();

    // get time components
    const hours = today.getHours();
    const minutes = today.getMinutes();
    const seconds = today.getSeconds();

    //add '0' to hour, minute & second when they are less 10
    const hour = hours < 10 ? "0" + hours : hours;
    const minute = minutes < 10 ? "0" + minutes : minutes;
    const second = seconds < 10 ? "0" + seconds : seconds;

    //make clock a 12-hour time clock
    const hourTime = hour > 12 ? hour - 12 : hour;

    // if (hour === 0) {
    //   hour = 12;
    // }
    //assigning 'am' or 'pm' to indicate time of the day
    const ampm = hour < 12 ? "AM" : "PM";

    // get date components
    const month = today.getMonth();
    const year = today.getFullYear();
    const day = today.getDate();

    //declaring a list of all months in  a year
    const monthList = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December"
    ];

    //get current date and time
    const date = day + " " + monthList[month] + " " + year;
    const time = hourTime + ":" + minute + ":" + second + ampm;

    //combine current date and time
    const dateTime = date + " - " + time;

    //print current date and time to the DOM
    document.getElementById("date-time").innerHTML = dateTime;
    setTimeout(clock, 1000);
  }
});
    </script>

   @endsection
