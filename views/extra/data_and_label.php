<?php
// Example data and labels from PHP
$labels = ['Route One', 'Router Two', 'Router Three', 'Router Four'];
$data = [
    [['x' => 2, 'y' => -100], ['x' => 4.5, 'y' => -24], ['x' => 7, 'y' => -100]],
    [['x' => 1, 'y' => -100], ['x' => 5, 'y' => -44], ['x' => 9, 'y' => -100]],
    [['x' => 4, 'y' => -100], ['x' => 8, 'y' => -49], ['x' => 12, 'y' => -100]],
    [['x' => 3, 'y' => -100], ['x' => 7, 'y' => -71], ['x' => 11, 'y' => -100]]
];

// Return data as JSON
echo json_encode(['labels' => $labels, 'data' => $data]);
