<?php

	$connect = mysqli_connect("localhost","root","","stock");

	$file = file_get_contents("exemple2.json");

	$data = json_decode($file,true);


	foreach ($data as $categories => $anyCol) {
		//сохраняем категории
		$sql = "INSERT INTO categories(name) VALUES('".$categories."')";
		mysqli_query($connect,$sql);
		foreach ($anyCol as $key => $arr) {
			if( $key === 'characteristics'){
				foreach ($arr as $characteristic_name => $params ) {
					//сохраняем характеристику
					$sql = "INSERT characteristics(name) VALUES('".$characteristic_name."')";
					mysqli_query($connect,$sql);
					//делаем запрос на получение id новой х-ки
					$sql_get_id = "SELECT id FROM `characteristics` WHERE name = '".$characteristic_name."'";
					$responce = mysqli_query($connect,$sql_get_id);
					//получаем id
					$characteristic_id = mysqli_fetch_all($responce);
					$id = $characteristic_id[0][0];
					echo $sql_get_id.'<br>';
					foreach ($params as $value) {
						//сохраняем значения характерисстики
						$sql = "INSERT INTO `value_characteristics`(characteristic_id,value) VALUES('".$id."','".$value."')";
						mysqli_query($connect,$sql);
					}
				}
			}
			else {
				foreach ($arr as $val){
					//сохраняем бренды и модели
					$sql = "INSERT INTO `".$key."`(name) VALUES('".$val."')";
					mysqli_query($connect,$sql);
				}
			}
		}
	}
	
	echo "ok";

?>