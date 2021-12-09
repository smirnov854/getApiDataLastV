<?php
	require('libs/db_vehicle_sample.class.php');

	$config['dbHost'] = 'localhost';
	$config['dbUser'] = 'cf08116_diski';
	$config['dbPassword'] = 'Diski123';
	$config['dbName'] = 'cf08116_diski';

	$mysql_link_id = mysqli_connect($config['dbHost'], $config['dbUser'], $config['dbPassword']) or die("Could not connect: " . mysqli_error());

	mysqli_select_db($mysql_link_id, $config['dbName']);

	$db = new DBVehicleSample();

	$vendor = ( isset($_GET['vendor']) 	&& $_GET['vendor'] != "" ) 	? mysqli_real_escape_string($mysql_link_id, $_GET['vendor']) : null;
	$car 	= ( isset($_GET['car'])		&& $_GET['car'] != "" ) 	? mysqli_real_escape_string($mysql_link_id, $_GET['car']) : null;
	$year 	= ( isset($_GET['year']) 	&& $_GET['year'] != "" ) 	? (int) $_GET['year'] : null;
	$mod 	= ( isset($_GET['mod']) 	&& $_GET['mod'] != "" ) 	? mysqli_real_escape_string($mysql_link_id, $_GET['mod']) : null;
?>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<style>
		body {font-family:arial;font-size: 12px;}
		h3, h4 {margin:0;padding:0;}
		h3 {font-size: 14px;}
		h4 {font-size: 12px;}
		table {margin-top: 10px;font-size: 12px;}
		table td {width: 250px; vertical-align:top;}
	</style>
</head>
<body>

	<form id="vehicle" action="page_db_vehicle_sample.php">
	
	Производитель:
	<br>
	<select name="vendor" id="vendor" onchange="$('#car').val(0); $('#year').val(0); $('#mod').val(0); $('#vehicle').submit();" style="width:200px">
		<option value="">Выберите производителя</option>
		<?php
			$db->_print_options($db->get_vendors(), 'vendor', $vendor);
		?>
	</select>

	<br><br>

	Модель:
	<br>
	<select name="car" id="car" onchange="$('#year').val(0); $('#mod').val(0); $('#vehicle').submit();" style="width:200px">
		<option value="">Выберите модель</option>
		<?php
		    if (null != $vendor)
				$db->_print_options($db->get_cars($vendor), 'car', $car);
		?>
	</select>

	<br><br>

	Год выпуска:
	<br>
	<select name="year" id="year" onchange="$('#mod').val(0); $('#vehicle').submit();" style="width:200px">
		<option value="">Выберите год</option>
		<?php
		    if (null != $vendor && null != $car)
				$db->_print_options($db->get_years($vendor, $car), 'year', $year);
		?>
	</select>

	<br><br>

	Модификация:
	<br>
	<select name="mod" id="mod" onchange="$('#vehicle').submit();" style="width:200px">
		<option value="">Выберите модификацию</option>
		<?php
		    if (null != $vendor && null != $car && null != $year)
				$db->_print_options($db->get_modifications($vendor, $car, $year), 'modification', $mod);
		?>
	</select>

	<br><br>

	<?php
	    if (null != $vendor && null != $car && null != $year && null != $mod)
			$db->_print_data($db->get_data($vendor, $car, $year, $mod));
	?>
</body>
</html>

