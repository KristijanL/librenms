<?php
$name = 'postgres';
$app_id = $app['app_id'];
if (!empty($agent_data['app'][$name])) {
    $rawdata = $agent_data['app'][$name];
}else{
//	var_dump(get_defined_vars());
	echo "Postgres Missing";
	return;
}
#Format Data
$lines = explode("\n",$rawdata);
$postgres = array();
foreach ($lines as $line) {
	list($var,$value) = explode('=',$line);
	$postgres[$var] = $value;
}
#Postgres Connections
$rrd_name =  array('app', $name, 'connections',$app_id);
$rrd_def = array(
	'DS:connections:DERIVE:600:0:125000000000'
	);
$fields = array (
	'connections' => $postgres['pg.CONNECTIONS']
	);
$tags = compact('name', 'app_id', 'rrd_name', 'rrd_def');
data_update($device, 'app', $tags, $fields);
unset($lines , $postgres, $rrd_name, $rrd_def, $fields, $tags);
