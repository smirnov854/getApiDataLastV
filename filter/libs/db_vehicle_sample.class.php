<?php

	class DBVehicleSample
	{
		function get_vendors()
		{
			$sql = "SELECT vendor FROM search_by_vehicle GROUP BY vendor";
			return $this->_query($sql);
		}

		function get_cars($vendor)
		{
			$sql = "SELECT car FROM search_by_vehicle 
					WHERE vendor='" . $vendor . "' 
					GROUP BY car";
			return $this->_query($sql);
		}

		function get_years($vendor, $car)
		{
			$sql = "SELECT year FROM search_by_vehicle 
					WHERE vendor = '" . $vendor . "' 
						AND car = '" . $car . "' 
					GROUP BY year";
			return $this->_query($sql);
		}

		function get_modifications($vendor, $car, $year)
		{
			$sql = "SELECT modification FROM search_by_vehicle 
					WHERE vendor = '" . $vendor . "' 
						AND car = '" . $car . "' 
						AND year=" . $year . "
					GROUP BY modification";
			return $this->_query($sql);
		}

		function get_data($vendor, $car, $year, $modification)
		{
			$sql = "SELECT * FROM search_by_vehicle 
					WHERE vendor = '" . $vendor . "' 
						AND car = '" . $car . "' 
						AND year = " . $year . " 
						AND modification = '" . $modification . "'";
			
			$result = $this->_query($sql);

			if (isset($result[0]))
			{
				$result[0]['tyres_factory_list'] 	= explode("|", $result[0]['tyres_factory']);
				$result[0]['tyres_replace_list'] 	= explode("|", $result[0]['tyres_replace']);
				$result[0]['tyres_tuning_list'] 	= explode("|", $result[0]['tyres_tuning']);

				$result[0]['wheels_factory_list'] 	= explode("|", $result[0]['wheels_factory']);
				$result[0]['wheels_replace_list'] 	= explode("|", $result[0]['wheels_replace']);
				$result[0]['wheels_tuning_list'] 	= explode("|", $result[0]['wheels_tuning']);
			}

			return $result[0];
		}

		function _print_options($options, $field, $selected)
		{
			foreach($options as $option)
			{
				if ($option[$field] == $selected)
					echo '<option selected="selected" value="' . $option[$field] . '">' . $option[$field] . '</option>';
				else
					echo '<option value="' . $option[$field] . '">' . $option[$field] . '</option>';
			}
		}

		function _print_data($data)
		{
			echo "<h3>Параметры дисков:</h3><br>";
			echo "PCD: " . $data['param_pcd'] . ", ";
	
			if ( $data['param_nut'] != '' )
				echo "Гайка: " . $data['param_nut'] . ", ";
			
			if ( $data['param_bolt'] != '' )
				echo "Болт: " . $data['param_bolt'] . ", ";

			echo "DIA: " . $data['param_dia'] . "<br>";

			echo "<table><tr><td>";

				echo "<h3>Шины:</h3>";
	
				echo "<br><h4>Заводские:</h4>";
				foreach($data['tyres_factory_list'] as $tyre)
				{
					if (strpos($tyre, ",") != false)    echo str_replace(",", " (front) ", $tyre ) . " (rear)<br>";
					else                                echo $tyre . "<br>";
				}

				echo "<br><h4>Замена:</h4>";
				foreach($data['tyres_replace_list'] as $tyre)
				{
					if (strpos($tyre, ",") != false)    echo str_replace(",", " (front) ", $tyre ) . " (rear)<br>";
					else                                echo $tyre . "<br>";
				}

				echo "<br><h4>Тюнинг:</h4>";
				foreach($data['tyres_tuning_list'] as $tyre)
				{
					if (strpos($tyre, ",") != false)	echo str_replace(",", " (front) ", $tyre ) . " (rear)<br>";
					else                                echo $tyre . "<br>";
				}

			echo "</td><td>";

				echo "<h3>Диски:</h3>";
	
				echo "<br><h4>Заводские:</h4>";
				foreach($data['wheels_factory_list'] as $wheel)
				{
					if (strpos($wheel, ",") != false)   echo str_replace(",", " (front) ", $wheel ) . " (rear)<br>";
					else                                echo $wheel . "<br>";
				}

				echo "<br><h4>Замена:</h4>";
				foreach($data['wheels_replace_list'] as $wheel)
				{
					if (strpos($wheel, ",") != false)   echo str_replace(",", " (front) ", $wheel ) . " (rear)<br>";
					else                                echo $wheel . "<br>";
				}

				echo "<br><h4>Тюнинг:</h4>";
				foreach($data['wheels_tuning_list'] as $wheel)
				{
					if (strpos($wheel, ",") != false)   echo str_replace(",", " (front) ", $wheel ) . " (rear)<br>";
					else                                echo $wheel . "<br>";
				}

			echo "</td></tr></table>";
		}

		function _query($query)
		{
			global $mysql_link_id;
			$result = mysqli_query($mysql_link_id, $query);

			if( !$result )
				echo "DB error #" . $query;

			$rows = array();

			while($row = mysqli_fetch_array($result))
			{
				$rows[] = $row;
			}   	

			return $rows;
		}
	}

