<?php

require 'includes/graphs/common.inc.php';

$i            = 0;
$scale_min    = 0;
$nototal      = 1;
$unit_text    = 'Connections';
$rrd_filename = rrd_name($device['hostname'], array('app', 'postgres-connections', $app['app_id']));
$array        = array(
    'connections'
);

$colours      = 'merged';
$rrd_list     = array();

$config['graph_colours']['merged'] = array_merge($config['graph_colours']['greens'], $config['graph_colours']['blues']);

if (rrdtool_check_rrd_exists($rrd_filename)) {
    foreach ($array as $ds) {
        $rrd_list[$i]['filename'] = $rrd_filename;
        $rrd_list[$i]['descr']    = strtoupper($ds);
        $rrd_list[$i]['ds']       = $ds;
        $i++;
    }
}
else {
    echo "file missing: $rrd_filename";
}
require 'includes/graphs/generic_multi_simplex_seperated.inc.php';
