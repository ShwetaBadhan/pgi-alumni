<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
 
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Title -->
  <title>Dashboard</title>
  {{-- <link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16"> --}}

   <!-- Favicon -->
    @if (isset($settings) && $settings->favicon)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->favicon) }}" sizes="16x16">
    @else
        <link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">
    @endif
    

  <!-- remix icon font css  -->
  <link rel="stylesheet" href="{{ url ('css/remixicon.css')}}">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="{{ url ('css/lib/bootstrap.min.css')}}">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="{{ url ('css/lib/apexcharts.css')}}">
  <!-- Data Table css -->
  <link rel="stylesheet" href="{{ url ('css/lib/dataTables.min.css')}}">
  <!-- Date picker css -->
  <link rel="stylesheet" href="{{ url ('css/lib/flatpickr.min.css')}}">
  <!-- Calendar css -->
  <link rel="stylesheet" href="{{ url ('css/lib/full-calendar.css')}}">
  <!-- calendar -->
  <link rel="stylesheet" href="{{ url ('css/lib/calendar.css')}}">
  <!-- main css -->
  <link rel="stylesheet" href="{{ url ('css/style.css')}}">
  
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

<style>
    /* SweetAlert ko chhota aur clean dikhane ke liye */
    .swal2-popup {
        font-size: 1rem !important;
        width: 22em !important;
        padding: 1.25rem !important;
    }
    
    .swal2-title {
        font-size: 1.5rem !important;
        font-weight: 600 !important;
        margin: 0 0 0.4em !important;
    }
    
    .swal2-html-container {
        font-size: 1rem !important;
        margin: 0 !important;
    }
{{--     
    .swal2-icon {
        width: 3em !important;
        height: 3em !important;
        margin: 1.5em auto 1.25em !important;
    } --}}
    
    .swal2-icon .swal2-icon-content {
        font-size: 2.5em !important;
    }
    
</style>
</head>

<body>




  <!-- Theme Customization Structure Start -->
<div class="body-overlay"></div>

<main class="dashboard-main">
@include('backend.components.header')
@include('backend.components.sidebar')

@yield('content')

@include('backend.components.copyright')

</main>


  <!-- jQuery library js -->
  <script src="{{ url ('js/lib/jquery-3.7.1.min.js')}}"></script>
  <!-- Bootstrap js -->
  <script src="{{ url ('js/lib/bootstrap.bundle.min.js')}}"></script>
  <!-- Apex Chart js -->
  <script src="{{ url ('js/lib/apexcharts.min.js')}}"></script>
  <!-- Iconify Font js -->
  <script src="{{ url ('js/lib/iconify-icon.min.js')}}"></script>
  <!-- Data Table js -->
  <script src="{{ url ('js/lib/dataTables.min.js')}}"></script>
  
  <!-- jQuery UI js -->
  <script src="{{ url ('js/lib/jquery-ui.min.js')}}"></script>
  
  <!-- main js -->
  <script src="{{ url ('js/app.js')}}"></script>
     <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

       <script>
    let table = new DataTable('#dataTable');

    // ✅ Data Table start
    $('.data-table').each(function () {
        const $table = $(this);
        const tableInstance = new DataTable(this);

        // Handle search input (inside same wrapper)
        $table.closest('.dataTable-wrapper').find('.dt-search .dt-input').on('keyup', function () {
            tableInstance.search(this.value).draw();
        });

        // Handle page length change (inside same wrapper)
        $table.closest('.dataTable-wrapper').find('.dt-length .dt-input').on('change', function () {
            const value = $(this).val();
            tableInstance.page.len(value).draw();
        });
    });
    // ✅ Data Table end

    // Sidebar js start
    $('.my-sidebar-btn').on('click', function () {
        $('.my-sidebar').addClass('active');
        $('.overlay').addClass('active');
    });
    $('.close-my-sidebar, .overlay').on('click', function () {
        $('.my-sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });


    $('.edit-sidebar-btn').on('click', function () {
        $('.edit-sidebar').addClass('active');
        $('.overlay').addClass('active');
    });
    $('.close-edit-sidebar, .overlay').on('click', function () {
        $('.edit-sidebar').removeClass('active');
        $('.overlay').removeClass('active');
    });
    // Sidebar js end

</script>

<script>
  // ============================ Revenue Statistics Chart start ===============================
  var options = {
    series: [{
      name: 'Total Fee',
      data: [25, 35, 50, 60, 26, 20, 40, 20, 50, 16, 10, 40]
    }, {
      name: 'Collected Fee',
      data: [15, 16, 24, 30, 20, 15, 20, 10, 25, 10, 6, 20]
    }],
    chart: {
      type: 'bar',
      height: 250,
      stacked: true,
      toolbar: {
        show: false
      },
      zoom: {
        enabled: true
      }
    },
    colors: ["#25A194", "#FF7A2C"],
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "50%",
        shape: "pyramid",
      },
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr',
        'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
      ],
    },
    yaxis: {
      labels: {
        formatter: function (value) {
          return "$" + value + "k";
        },
        style: {
          fontSize: "14px"
        }
      },
    },
    legend: {
      show: false,
    },
    fill: {
      opacity: 1
    }
  };

  var chart = new ApexCharts(document.querySelector("#revenueStatistic"), options);
  chart.render()
  // ============================ Revenue Statistics Chart End ===============================

  // ===================== Income Vs Expense Start =============================== 
  function createChartThree(chartId, color1, color2) {
    var options = {
      series: [{
        name: 'Income',
        data: [48, 35, 55, 32, 48, 30, 15, 50, 57]
      }, {
        name: 'Expense',
        data: [12, 20, 15, 26, 22, 60, 40, 32, 25]
      }],
      legend: {
        show: false
      },
      chart: {
        type: 'area',
        width: '100%',
        height: 260,
        toolbar: {
          show: false
        },
        padding: {
          left: 0,
          right: 0,
          top: 0,
          bottom: 0
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'stepline',
        width: 2,
        colors: [color1, color2],
        lineCap: 'round'
      },
      grid: {
        show: true,
        borderColor: '#D1D5DB',
        strokeDashArray: 1,
        position: 'back',
        xaxis: {
          lines: {
            show: false
          }
        },
        yaxis: {
          lines: {
            show: true
          }
        },
        row: {
          colors: undefined,
          opacity: 0.2
        },
        column: {
          colors: undefined,
          opacity: 0.2
        },
        padding: {
          top: -20,
          right: 0,
          bottom: -10,
          left: 0
        },
      },
      colors: [color1, color2],
      markers: {
        colors: [color1, color2],
        strokeWidth: 1,
        size: 0,
        hover: {
          size: 10
        }
      },
      xaxis: {
        labels: {
          show: false
        },
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        tooltip: {
          enabled: false
        },
        labels: {
          formatter: function (value) {
            return value;
          },
          style: {
            fontSize: "14px"
          }
        }
      },
      yaxis: {
        labels: {
          formatter: function (value) {
            return "$" + value + "k";
          },
          style: {
            fontSize: "14px"
          }
        },
      },
      tooltip: {
        x: {
          format: 'dd/MM/yy HH:mm'
        }
      },
      fill: {
        type: "gradient",
        gradient: {
          shade: "light",
          type: "vertical",
          opacityFrom: 0.4,
          opacityTo: 0.05,
          stops: [0, 100]
        }
      }
    };

    var chart = new ApexCharts(document.querySelector(`#${chartId}`), options);
    chart.render();
  }

  createChartThree('incomeExpense', '#16a34a', '#FF9F29');
  // ===================== Income Vs Expense End =============================== 

  // ================================ New Admissions Chart Start ================================ 
  var options = {
    series: [40, 87, 87, 30],
    colors: ['#0A51CE', '#25A194', '#FF7A2C', '#009F5E'],
    labels: ['Health', 'Business', 'Lifestyle', 'Entertainment'],
    legend: {
      show: false
    },
    chart: {
      type: 'donut',
      height: 270,
      sparkline: {
        enabled: true // Remove whitespace
      },
      margin: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
      },
      padding: {
        top: 0,
        right: 0,
        bottom: 0,
        left: 0
      }
    },
    stroke: {
      width: 2,
    },
    dataLabels: {
      enabled: false
    },
    responsive: [{
      breakpoint: 480,
      options: {
        chart: {
          width: 200
        },
        legend: {
          position: 'bottom'
        }
      }
    }],
  };

  var chart = new ApexCharts(document.querySelector("#newAdmissions"), options);
  chart.render();
  // ================================ New Admissions Chart End ================================ 

  // ================================ Animated Radial Progress Bar Start ================================ 
  $('svg.radial-progress').each(function (index, value) {
    $(this).find($('circle.complete')).removeAttr('style');
  });

  // Activate progress animation on scroll
  $(window).scroll(function () {
    $('svg.radial-progress').each(function (index, value) {
      // Trigger when the element is fully in the viewport
      if (
        $(window).scrollTop() >= $(this).offset().top - $(window).height() &&
        $(window).scrollTop() <= $(this).offset().top + $(this).height()
      ) {
        // Get percentage of progress
        const percent = $(value).data('percentage');
        // Get radius of the svg's circle.complete
        const radius = $(this).find($('circle.complete')).attr('r');
        // Get circumference (2πr)
        const circumference = 2 * Math.PI * radius;
        // Get stroke-dashoffset value based on the percentage of the circumference
        const strokeDashOffset = circumference - ((percent * circumference) / 100);
        // Transition progress for 1.25 seconds
        $(this).find($('circle.complete')).animate({ 'stroke-dashoffset': strokeDashOffset }, 1250);
      }
    });
  }).trigger('scroll');
  // ================================ Animated Radial Progress Bar End ================================

  // ============================= Calendar Js Start =================================
  let display = document.querySelector(".display");
  let days = document.querySelector(".days");
  let previous = document.querySelector(".left");
  let next = document.querySelector(".right");

  let date = new Date();

  let year = date.getFullYear();
  let month = date.getMonth();

  function displayCalendar() {
    const firstDay = new Date(year, month, 1);

    const lastDay = new Date(year, month + 1, 0);

    const firstDayIndex = firstDay.getDay(); //4

    const numberOfDays = lastDay.getDate(); //31

    let formattedDate = date.toLocaleString("en-US", {
      month: "long",
      year: "numeric"
    });

    display.innerHTML = `${formattedDate}`;

    for (let x = 1; x <= firstDayIndex; x++) {
      const div = document.createElement("div");
      div.innerHTML += "";

      days.appendChild(div);
    }

    for (let i = 1; i <= numberOfDays; i++) {
      let div = document.createElement("div");
      let currentDate = new Date(year, month, i);

      div.dataset.date = currentDate.toDateString();

      div.innerHTML += i;
      days.appendChild(div);
      if (
        currentDate.getFullYear() === new Date().getFullYear() &&
        currentDate.getMonth() === new Date().getMonth() &&
        currentDate.getDate() === new Date().getDate()
      ) {
        div.classList.add("current-date");
      }
    }
  }

  // Call the function to display the calendar
  displayCalendar();

  previous.addEventListener("click", () => {
    days.innerHTML = "";

    if (month < 0) {
      month = 11;
      year = year - 1;
    }
    month = month - 1;
    date.setMonth(month);
    displayCalendar();
  });

  next.addEventListener("click", () => {
    days.innerHTML = "";

    if (month > 11) {
      month = 0;
      year = year + 1;
    }

    month = month + 1;
    date.setMonth(month);

    displayCalendar();
  });
  // ============================= Calendar Js End =================================

</script>
@stack('scripts')
</body>

</html>