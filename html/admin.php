<?php

/*** mysql variables ***/


# Connects to Database
try {  
	$dbh = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
	echo 'Connected to Database </br>';
	$sql = "SELECT  `TABLE_NAME`  FROM  `INFORMATION_SCHEMA`.`TABLES`  WHERE  `TABLE_SCHEMA` =  :database";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam('database', $database);
	$stmt->execute();
	$result = $stmt->fetchAll();
	echo '<form method="post" action="self">';
	echo '<h3> Table </h3>'
	echo "<select id='dropdowntables'>";
	foreach($result as $row){
		echo "<option value=$i>{$row['TABLE_NAME']}</option>";
		$i++;
	}
	echo "</select> </br>";
	echo '<input type="submit" name="submit" id="submit" value="Submit!"/>';
	echo "</form>";

	$sql = "SELECT * FROM Queries";
	foreach ($dbh->query($sql) as $row) {
		print $row['id'] . ' - ' . $row['name'] . ' - ' . $row['email'] . ' - ' . $row['comments'] . '</br>';
	}

	$sql = "SELECT  `COLUMN_NAME`  FROM  `INFORMATION_SCHEMA`.`COLUMNS`  WHERE  `TABLE_SCHEMA` =  :database AND `TABLE_NAME` = 'Queries' AND `ORDINAL_POSITION` = '1'";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam('database', $database);
	$stmt->execute();
	$result = $stmt->fetch();
	$firstcolumn = $result[COLUMN_NAME];

	$sql = "SELECT * FROM Queries";
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
	echo '<form method="post" action="self">';
	echo "<select id='dropdownboxid'>";
	echo "<option>$firstcolumn</option>";
	foreach($result as $row){
		echo "<option value=$i>{$row[$firstcolumn]}</option>";
		$i++;
	}
	echo "</select>";


	$sql = "SELECT  `COLUMN_NAME`  FROM  `INFORMATION_SCHEMA`.`COLUMNS`  WHERE  `TABLE_SCHEMA` =  :database AND `TABLE_NAME`='Queries'";
	$stmt = $dbh->prepare($sql);
	$stmt->bindParam('database', $database);
	$stmt->execute();
	$result = $stmt->fetchAll();
	echo "<select id='dropdownboxcolumns'>";
	echo "<option />";
	foreach($result as $row){
		echo "<option value=$i>{$row['COLUMN_NAME']}</option>";
		$i++;
	}
	echo "</select> </br>";
	echo '<input type="submit" name="submit" id="submit" value="Submit!"/>';
	echo "</form>";

	# Closes connection
	$dbh = null;
}
# If error connecting to Database
catch(PDOException $e) {  
	echo $e->getMessage();  
}  

?>