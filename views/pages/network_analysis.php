<?php
$title = 'Network Analysis';
include '../partials/header.php';

$labels = ['Route One', 'Router Two', 'Router Three', 'Router Four'];
$all_data = [
    [['x' => 2, 'y' => -100], ['x' => 4.5, 'y' => -24], ['x' => 7, 'y' => -100]],
    [['x' => 1, 'y' => -100], ['x' => 5, 'y' => -44], ['x' => 9, 'y' => -100]],
    [['x' => 4, 'y' => -100], ['x' => 8, 'y' => -49], ['x' => 12, 'y' => -100]],
    [['x' => 3, 'y' => -100], ['x' => 7, 'y' => -71], ['x' => 11, 'y' => -100]]
];

$json_data = '[
  {
    "BSSID":"9c:a2:f4:c1:e8:6b",
    "SSID":"cloudone-5G",
    "capabilities":"[WPA2-PSK-CCMP][RSN-PSK-CCMP][ESS][WPS]",
    "channelWidth":0,
    "frequency":2462,
    "level":-36
  },
  {
    "BSSID":"4c:ed:fb:b4:6f:dc",
    "SSID":"ASUS",
    "capabilities":"[WPA2-PSK-CCMP][RSN-PSK-CCMP][ESS][WPS]",
    "channelWidth":1,
    "frequency":2422,
    "level":-40
  },
  {
    "BSSID":"d8:0d:17:47:53:d2",
    "SSID":"TP-Link_53D2",
    "capabilities":"[WPA2-PSK-CCMP][RSN-PSK-CCMP][ESS][WPS]",
    "channelWidth":1,
    "frequency":2457,
    "level":-50
  },
  {
    "BSSID":"9c:a2:f4:c1:e8:6a",
    "SSID":"cloudone-5G",
    "capabilities":"[WPA2-PSK-CCMP][RSN-PSK-CCMP][ESS][WPS]",
    "channelWidth":2,
    "frequency":5805,
    "level":-54
  },
  {
    "BSSID":"00:31:92:85:a6:73",
    "SSID":"PCR",
    "capabilities":"[WPA2-PSK-CCMP][RSN-PSK-CCMP][ESS][WPS]",
    "channelWidth":1,
    "frequency":2452,
    "level":-68
  },
  {
    "BSSID":"bc:0f:9a:20:9f:fc",
    "SSID":"NOC-POWER-MANAGEMENT",
    "capabilities":"[WPA-PSK-CCMP][ESS]",
    "channelWidth":1,
    "frequency":2472,
    "level":-76
  },
  {
    "BSSID":"34:60:f9:70:fb:02",
    "SSID":"cloudone-2.4G",
    "capabilities":"[WPA2-PSK-CCMP][RSN-PSK-CCMP][ESS][WPS]",
    "channelWidth":0,
    "frequency":2437,
    "level":-77
  },
  {
    "BSSID":"68:ff:7b:aa:66:f1",
    "SSID":"Support_2.4G",
    "capabilities":"[WPA2-PSK-CCMP][RSN-PSK-CCMP][ESS][WPS]",
    "channelWidth":1,
    "frequency":2462,
    "level":-81
  },
  {
    "BSSID":"68:ff:7b:aa:66:f1",
    "SSID":"Support_test_2.4G",
    "capabilities":"[WPA2-PSK-CCMP][RSN-PSK-CCMP][ESS][WPS]",
    "channelWidth":0,
    "frequency":2462,
    "level":-65
  }
]';

// Decode JSON data
$data = json_decode($json_data, true);

// Array to store channel widths in MHz
$channelWidths = array();
$channelName = array();
$channels = array();
$all_channels = array();
$frequencies = array();
$lavels = array();

// Loop through the data and determine the channel width in MHz
foreach ($data as $item) {
    if ($item['frequency'] >= 2400 && $item['frequency'] <= 2500) {
        // Calculate channel number for 2.4 GHz band
        $channel = floor(($item['frequency'] - 2407) / 5) + 1;
        $frequency = 2.4;
        // Add channel to the array
        $channels[] = $channel;
        $all_channels[] = $channel;
        $frequencies[] = $frequency;
    } else {
        // Calculate channel number for 5.0 GHz band
        $channel = floor(($item['frequency'] - 5000) / 5);
        $frequency = 5.0;
        // Add channel to the array
        $all_channels[] = $channel;
        $frequencies[] = $frequency;
    }

    $channelWidth = 20; // Default value

    switch ($item['channelWidth']) {
        case 0:
            $channelWidth = 20;
            break;
        case 1:
            $channelWidth = 40;
            break;
        case 2:
            $channelWidth = 80;
            break;
        case 3:
            $channelWidth = 160;
            break;
    }

    $lavels[] = $item['level'];
    $channelName[] = $item['SSID'];
    $channelWidths[] = $channelWidth;
}

$channelCounts = array_count_values($channels);

$channelCounts = array(); // Initialize an empty array to store channel counts

// Iterate through the channels array
foreach ($channels as $channel) {
    // If the channel exists in the counts array, increment its count, otherwise set it to 1
    if (isset($channelCounts[$channel])) {
        $channelCounts[$channel]++;
    } else {
        $channelCounts[$channel] = 1;
    }
}


// Store channel and count as associative array
$sortedChannelCounts = array();
foreach ($channelCounts as $channel => $count) {
    $sortedChannelCounts[] = array($channel, $count);
}
?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="content-body"><!-- stats -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs network_ul">
            <li class="nav-item">
                <a class="nav-link active" id="best_channels_tab" data-toggle="tab" aria-controls="tab1"
                    href="#best_channels" aria-expanded="true">Best Channels</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="access_points_tab" data-toggle="tab" aria-controls="tab2" href="#access_points"
                    aria-expanded="false">Access Points</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="channel_graph_tab" data-toggle="tab" aria-controls="tab3" href="#channel_graph"
                    aria-expanded="false">Channel Graph</a>
            </li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="best_channels" aria-expanded="true"
                aria-labelledby="best_channels_tab">
                <div class="progress-box">
                    <div class="best_channel_flexbox">
                        <div class="header-row">
                            <div class="header-cell" style="width: 5rem;">Channel</div>
                            <div class="header-cell" style="text-align: center; width: 50rem;">Strength</div>
                            <div class="header-cell" style="text-align: center; width: 5rem;">Status</div>
                        </div>
                        <?php
                        $bestChannels = [];
                        $channels = [];
                        // Generate rows based on the associative array
                        for ($i = 1; $i <= 14; $i++) {
                            $progressValue = 0;
                            foreach ($sortedChannelCounts as $data) {
                                if ($data[0] == $i) {
                                    $progressValue = $data[1];
                                    break;
                                }
                            }

                            // Determine the progress percentage and status
                            $progressPercentage = $progressValue * 10;
                            if ($progressValue == 0) {
                                $progressPercentage = 100;
                                $channels[] = $i;
                                if ($i == 1 || $i == 6 || $i == 11) {
                                    $bestChannels[] = $i; // Collect best channels
                                }
                                if ($i >= 12 && count($bestChannels) < 3) {
                                    // Take one or more data from $channels which is not in $bestChannels
                                    foreach ($channels as $channel) {
                                        if (!in_array($channel, $bestChannels)) {
                                            $bestChannels[] = $channel;
                                            // Optionally, break the loop if only one additional channel is needed
                                            if (count($bestChannels) == 3) {
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="cell" style="width: 5rem;"><?php echo $i; ?></div>
                                <div class="cell" style="text-align: center; width: 50rem; margin-top: 0.3rem;">
                                    <div class="progress-line">
                                        <div class="progress">
                                            <div class="progress-bar"
                                                style="width: <?php echo $progressPercentage; ?>%; background-color: <?php echo ($progressValue == 0) ? '#38761d' : (($progressValue <= 2) ? '#e29c45' : 'red'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell" style="text-align: center; width: 5rem;">
                                    <?php echo ($progressValue == 0) ? 'Best' : (($progressValue <= 2) ? 'Bad' : 'Critical'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="footer-row">
                            <div class="footer-cell" colspan="3">
                                Best Channels are: <?php echo implode(', ', $bestChannels); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="access_points" aria-labelledby="access_points_tab">
                <div class="access-point-progress-box">
                    <?php
                    for ($i = 0; $i < count($channelName); $i++) {
                        $details = "Channel: " . $all_channels[$i] . "(" . $channelWidths[$i] . "MHz)";
                        $frequency = $frequencies[$i] == 5 ? "5.0GHz" : $frequencies[$i] . "GHz";

                        if ($lavels[$i] >= -60 && $lavels[$i] <= -30) {
                            $lavel = '<img src="../../assets/images/signal/WifiFull.png" alt="Full Signal" style="width: 35%;">';
                        } elseif ($lavels[$i] >= -70 && $lavels[$i] > -60) {
                            $lavel = '<img src="../../assets/images/signal/Wifi75.png" alt="75% Signal" style="width: 35%;">';
                        } elseif ($lavels[$i] >= -80 && $lavels[$i] > -70) {
                            $lavel = '<img src="../../assets/images/signal/Wifi50.png" alt="50% Signal" style="width: 35%;">';
                        } elseif ($lavels[$i] >= -90 && $lavels[$i] > -80) {
                            $lavel = '<img src="../../assets/images/signal/Wifi25.png" alt="25% Signal" style="width: 35%;">';
                        } else {
                            $lavel = '<img src="../../assets/images/signal/WifiIcon0.png" alt="No Signal" style="width: 35%;">';
                        }

                        ?>
                        <div class="access-point-row">
                            <div class="access-point-cell" style="width: 20rem;"><?php echo $channelName[$i]; ?></div>
                            <div class="access-point-cell" style="width: 15rem;"><?php echo $details; ?></div>
                            <div class="access-point-cell" style="width: 5rem;"><?php echo $lavel; ?></div>
                            <div class="access-point-cell"
                                style="width: 5rem; background-color: #d0e1f9; border-radius: 4px; text-align: center;">
                                <?php echo $frequency; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="tab-pane" id="channel_graph" aria-labelledby="channel_graph_tab">
                <div class="chartBox">
                    <canvas id="myChart" style="height: 10px; width: 10px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/popper.min.js"></script>
<script src="../../assets/js/bootstrap.min.js"></script>

<!-- simplebar js -->
<script src="../../assets/plugins/simplebar/js/simplebar.js"></script>
<!-- sidebar-menu js -->
<script src="../../assets/js/sidebar-menu.js"></script>
<!-- Custom scripts -->
<script src="../../assets/js/app-script.js"></script>
<script src="../../alertify/lib/alertify.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.7/js/tether.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.2/perfect-scrollbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/unison/2.2.7/unison.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/screenfull.js/5.1.0/screenfull.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/pace.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    //added by monir for graphical chart:15-05-2024 
    function fetchDataAndLabels() {
        // Embed PHP data into JavaScript variables
        const labels = <?php echo json_encode($labels); ?>;
        const data = <?php echo json_encode($all_data); ?>;

        // Register Chart.js plugin to add labels
        // Chart.register({
        //     id: 'pointLabel',
        //     beforeDatasetsDraw: function (chart) {
        //         var ctx = chart.ctx;
        //         chart.data.datasets.forEach(function (dataset, datasetIndex) {
        //             var meta = chart.getDatasetMeta(datasetIndex);
        //             if (!meta.hidden) {
        //                 meta.data.forEach(function (element, index) {
        //                     if (index === Math.floor(dataset.data.length / 2)) {
        //                         var xPos = element.tooltipPosition().x;
        //                         var yPos = element.tooltipPosition().y;
        //                         ctx.fillStyle = dataset.borderColor;
        //                         ctx.textAlign = 'center';
        //                         ctx.textBaseline = 'bottom';
        //                         ctx.font = '12px Arial';
        //                         ctx.fillStyle = 'black';
        //                         ctx.fillText(dataset.label, xPos, yPos);
        //                     }
        //                 });
        //             }
        //         });
        //     }
        // });

        const datasets = labels.map((label, index) => {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);

            // Construct borderColor and backgroundColor
            const borderColor = `rgba(${r}, ${g}, ${b}, 1)`;
            const backgroundColor = `rgba(${r}, ${g}, ${b}, 0.2)`;
            return {
                label: label,
                data: data[index],
                borderColor: borderColor,
                backgroundColor: backgroundColor,
                fill: "start",
            };
        });

        // Check if myChart exists and is an instance of Chart
        if (window.myChart instanceof Chart) {
            // Destroy existing chart instance
            window.myChart.destroy();
        }

        // Create new chart instance
        window.myChart = new Chart(
            document.getElementById('myChart'),
            {
                type: 'line',
                data: {
                    datasets: datasets
                },
                options: {
                    scales: {
                        x: {
                            type: 'linear',
                            position: 'bottom',
                            min: 0,
                            max: 14,
                            ticks: {
                                stepSize: 1
                            }
                        },
                        y: {
                            min: -100,
                            max: -20,
                            ticks: {
                                callback: function (value) {
                                    return value !== -100 ? value : ''; // Display empty string at the intersect point
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false // Hide legend
                        }
                    },
                    elements: {
                        line: {
                            borderWidth: 2, // Adjust line width
                            tension: 0.4
                        },
                        point: {
                            radius: 0 // Remove points
                        }
                    }
                }
            }
        );


        // Show the modal after rendering the chart
        $("#network_analysis_modal").modal("show");
    }
    fetchDataAndLabels();
</script>
<?php
include '../partials/footer.php';
?>