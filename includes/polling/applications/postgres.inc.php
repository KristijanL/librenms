<?php
$name = 'postgres';
$app_id = $app['app_id'];
if (!empty($agent_data['app'][$name])) {
    $rawdata = $agent_data['app'][$name];
}else{

    $options = '-O qv';
   $oid     = 'nsExtendOutputFull.19.112.111.115.116.103.114.101.115.45.99.111.110.110.101.99.116.105.111.110';
// .1.3.6.1.4.1.8072.1.3.2.3.1.1.19.112.111.115.116.103.114.101.115.45.99.111.110.110.101.99.116.105.111.110';
    $rawdata  = snmp_get($device, $oid, $options);

//	echo "Postgres Missing";
//	return;

//$arr = get_defined_vars();
//var_dump( get_defined_vars() );
//file_put_contents("/tmp/TEST",$arr);

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

// var_dump( get_defined_vars() );

unset($lines , $postgres, $rrd_name, $rrd_def, $fields, $tags);
