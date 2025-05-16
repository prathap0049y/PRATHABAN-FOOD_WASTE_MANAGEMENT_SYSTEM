<?php
ob_start();
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'food_donation');
include("connect.php");
if ($_SESSION['name'] == '') {
  header("location:signin.php");
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="admin.css">

  <!----===== Iconscout CSS ===== -->
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

  <title>Admin Dashboard Panel</title>

  <?php
  $connection = mysqli_connect("localhost:3306", "root", "");
  $db = mysqli_select_db($connection, 'food_donation');
  ?>

  <style>
    .chart-container {
      width: 60%;
      margin: auto;
      background: white;
      padding: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }
  </style>

</head>

<body>
  <nav>
    <div class="logo-name">
      <div class="logo-image">
        <!--<img src="images/logo.png" alt="">-->
      </div>

      <span class="logo_name">ADMIN</span>
    </div>

    <div class="menu-items">
      <ul class="nav-links">
        <li><a href="admin.php">
            <i class="uil uil-estate"></i>
            <span class="link-name">Dashboard</span>
          </a></li>
        <!-- <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li> -->
        <li><a href="analytics.php">
            <i class="uil uil-chart"></i>
            <span class="link-name">Analytics</span>
          </a></li>
        <li><a href="donate.php">
            <i class="uil uil-heart"></i>
            <span class="link-name">Donates</span>
          </a></li>
        <li><a href="request.php">
            <i class="uil uil-clipboard-notes"></i>
            <span class="link-name">Request</span>
          </a></li>
        <li><a href="feedback.php">
            <i class="uil uil-comments"></i>
            <span class="link-name">Feedbacks</span>
          </a></li>
        <li><a href="adminprofile.php">
            <i class="uil uil-user"></i>
            <span class="link-name">Profile</span>
          </a></li>
        <li><a href="registered_users.php">
            <i class="uil uil-users-alt"></i>
            <span class="link-name">Registered Users</span>
          </a></li>
        <li><a href="organization_details.php">
            <i class="uil uil-building"></i>
            <span class="link-name">Organizations</span>
          </a></li>
        <li><a href="delivery_persons_details.php">
            <i class="uil uil-truck"></i>
            <span class="link-name">Delivery Persons</span>
          </a></li>
        <!-- <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li> -->
      </ul>

      <ul class="logout-mode">
        <li><a href="logout.php">
            <i class="uil uil-signout"></i>
            <span class="link-name">Logout</span>
          </a></li>

        <li class="mode">
          <a href="#">
            <i class="uil uil-moon"></i>
            <span class="link-name">Dark Mode</span>
          </a>

          <div class="mode-toggle">
            <span class="switch"></span>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <section class="dashboard">

    <div class="top">
      <i class="uil uil-bars sidebar-toggle"></i>
      <!-- <p>Food Donate</p> -->
      <p class="logo">Food <b style="color: #06C167; ">Donate</b></p>
      <p class="user"></p>
      <!-- <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div> -->

      <!--<img src="images/profile.jpg" alt="">-->
    </div>

    <div class="dash-content">
      <div class="overview">
        <div class="title">
          <i class="uil uil-chart"></i>
          <span class="text">Analytics</span>
        </div>

        <div class="boxes">
          <div class="box box1">
            <i class="uil uil-user"></i>
            <!-- <i class="fa-solid fa-user"></i> -->
            <span class="text">Total users</span>
            <?php
            $query = "SELECT count(*) as count FROM  login";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            echo "<span class=\"number\">" . $row['count'] . "</span>";
            ?>
            <!-- <span class="number">50,120</span> -->
          </div>
          <div class="box box2">
            <i class="uil uil-comments"></i>
            <span class="text">Feedbacks</span>
            <?php
            $query = "SELECT count(*) as count FROM  user_feedback";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            echo "<span class=\"number\">" . $row['count'] . "</span>";
            ?>
            <!-- <span class="number">20,120</span> -->
          </div>
          <div class="box box3">
            <i class="uil uil-heart"></i>
            <span class="text">Total doantes</span>
            <?php
            $query = "SELECT count(*) as count FROM food_donations";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            echo "<span class=\"number\">" . $row['count'] . "</span>";
            ?>
            <!-- <span class="number">10,120</span> -->
          </div>
        </div>
        <br>
        <br>

        <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
        <br>
        <canvas id="donateChart" style="width:100%;max-width:600px"></canvas>

        <script>
          <?php
          $query = "SELECT count(*) as count FROM  login where gender=\"male\"";
          $q2 = "SELECT count(*) as count FROM  login where gender=\"female\"";
          $result = mysqli_query($connection, $query);
          $res2 = mysqli_query($connection, $q2);
          $row = mysqli_fetch_assoc($result);
          $ro2 = mysqli_fetch_assoc($res2);
          $female = $ro2['count'];
          $male = $row['count'];
          $q3 = "SELECT count(*) as count FROM food_donations where location=\"chengalpattu\"";
          $res3 = mysqli_query($connection, $q3);
          $ro3 = mysqli_fetch_assoc($res3);
          $chengalpattu = $ro3['count'];


          ?>
          var xValues = ["Male", "Female"];
          var xplace = ["chengalpattu"];
          var yplace = [<?php echo json_encode($chengalpattu, JSON_HEX_TAG); ?>];
          var yValues = [<?php echo json_encode($male, JSON_HEX_TAG); ?>, <?php echo json_encode($female, JSON_HEX_TAG); ?>, 30];
          var barColors = ["#FF5733", "#33FF57"];
          var bar = ["#FF5733", "#33FF57"]

          new Chart("myChart", {
            type: "bar",
            data: {
              labels: xValues,
              datasets: [{
                backgroundColor: barColors,
                data: yValues
              }]
            },
            options: {
              legend: {
                display: false
              },
              title: {
                display: true,
                text: "User details"
              },
              animation: {
                duration: 3000,
                easing: 'easeOutElastic'
              }
            }
          });

          new Chart("donateChart", {
            type: "bar",
            data: {
              labels: xplace,
              datasets: [{
                backgroundColor: bar,
                data: yplace
              }]
            },
            options: {
              legend: {
                display: false
              },
              title: {
                display: true,
                text: "Food donation details"
              },
              animation: {
                duration: 3000,
                easing: 'easeOutElastic'
              }
            }
          });

          (function(H) {
            H.seriesTypes.pie.prototype.animate = function(init) {
              const series = this,
                chart = series.chart,
                points = series.points,
                {
                  animation
                } = series.options,
                {
                  startAngleRad
                } = series;

              function fanAnimate(point, startAngleRad) {
                const graphic = point.graphic,
                  args = point.shapeArgs;
                if (graphic && args) {
                  graphic.attr({
                      start: startAngleRad,
                      end: startAngleRad,
                      opacity: 1
                    })
                    .animate({
                        start: args.start,
                        end: args.end
                      }, {
                        duration: animation.duration / points.length
                      },
                      function() {
                        if (points[point.index + 1]) {
                          fanAnimate(points[point.index + 1], args.end);
                        }
                        if (point.index === series.points.length - 1) {
                          series.dataLabelsGroup.animate({
                              opacity: 1
                            },
                            void 0,
                            function() {
                              points.forEach(point => {
                                point.opacity = 1;
                              });
                              series.update({
                                enableMouseTracking: true
                              }, false);
                              chart.update({
                                plotOptions: {
                                  pie: {
                                    innerSize: '40%',
                                    borderRadius: 8
                                  }
                                }
                              });
                            }
                          );
                        }
                      }
                    );
                }
              }

              if (init) {
                points.forEach(point => {
                  point.opacity = 0;
                });
              } else {
                fanAnimate(points[0], startAngleRad);
              }
            };
          }(Highcharts));

          document.addEventListener("DOMContentLoaded", function() {
            <?php
            $query = "SELECT category, type, COUNT(*) as count FROM food_donations GROUP BY category, type";
            $result = mysqli_query($connection, $query);
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
              $data[] = [
                'name' => $row['category'] . ' - ' . $row['type'],
                'y' => (int)$row['count']
              ];
            }
            ?>
            var donationData = <?php echo json_encode($data, JSON_HEX_TAG); ?>;

            Highcharts.chart('container', {
              chart: {
                type: 'pie',
                animation: {
                  duration: 2000
                }
              },
              title: {
                text: 'Food Donation Categories and Types'
              },
              subtitle: {
                text: 'Distribution of food donation categories and types'
              },
              tooltip: {
                pointFormat: '<span style="color:{point.color}">\u25cf</span> {point.name}: <b>{point.percentage:.1f}%</b>'
              },
              accessibility: {
                point: {
                  valueSuffix: '%'
                }
              },
              plotOptions: {
                pie: {
                  allowPointSelect: true,
                  borderWidth: 2,
                  cursor: 'pointer',
                  dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b><br>{point.percentage}%',
                    distance: 20
                  },
                  states: {
                    hover: {
                      brightness: 0.2
                    }
                  } // Hover effect
                }
              },
              series: [{
                enableMouseTracking: false,
                animation: {
                  duration: 2000
                },
                colorByPoint: true,
                data: donationData
              }]
            });
          });
        </script>

      </div>
    </div>

    <!--chart -->
    <!--<h2>Fully Animated Pie Chart</h2> -->

    <div class="chart-container">
      <div id="container" style="width: 100%; height: 400px;"></div>
    </div>

  </section>
  <script src="admin.js"></script>
</body>

</html>