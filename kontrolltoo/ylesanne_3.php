<?php
	require("../../vpconfig.php");
	$database = "if17_rinde";
	$monthFieldNames = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday", "august", "september", "october", "november", "december"];
	
	$firstname = "";
	$lastname = "";
	$language = "";
	$monday = "";
	$tuesday = "";
	$wednesday = "";
	$thursday = "";
	$friday = "";
	$saturday = "";
	$sunday = "";
	
	if(isset($_POST["saveweekdays"])){
		if(isset($_POST["firstname"]) and !empty($_POST["firstname"])){
			$firstname = testInput($_POST["firstname"]);
		}
		if(isset($_POST["lastname"]) and !empty($_POST["lastname"])){
			$lastname = testInput($_POST["lastname"]);
		}
		if(isset($_POST["language"]) and !empty($_POST["language"])){
			$language = testInput($_POST["language"]);
		}
		if(isset($_POST["monday"]) and !empty($_POST["monday"])){
			$monday = testInput($_POST["monday"]);
		}
		if(isset($_POST["tuesday"]) and !empty($_POST["tuesday"])){
			$tuesday = testInput($_POST["tuesday"]);
		}
		if(isset($_POST["wednesday"]) and !empty($_POST["wednesday"])){
			$wednesday = testInput($_POST["wednesday"]);
		}
		if(isset($_POST["thursday"]) and !empty($_POST["thursday"])){
			$thursday = testInput($_POST["thursday"]);
		}
		if(isset($_POST["friday"]) and !empty($_POST["friday"])){
			$friday = $_POST["friday"];
		}
		if(isset($_POST["saturday"]) and !empty($_POST["saturday"])){
			$saturday = testInput($_POST["saturday"]);
		}
		if(isset($_POST["sunday"]) and !empty($_POST["sunday"])){
			$sunday = testInput($_POST["sunday"]);
		}
		
		if(!empty($firstname) and !empty($lastname) and !empty($language) and !empty($monday) and !empty($tuesday) and !empty($wednesday) and !empty($thursday) and !empty($friday) and !empty($saturday) and !empty($sunday)){
			saveweekdays($firstname, $lastname, $language, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
		}
	}

	function saveweekdays($firstname, $lastname, $language, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday){
		//echo "salvestame nüüd!";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT language FROM vptestweekdays WHERE language = ?");
		echo $mysqli->error;
		$stmt->bind_param("s", $language);
		$stmt->bind_result($languageFromDb);
		$stmt->execute();
		if($stmt->fetch()){
			echo "Kahjuks selline keel on juba olemas!";
			$stmt->close();
			$mysqli->close();
		} else {
			$stmt->close();
			$stmt = $mysqli->prepare("INSERT INTO vptestweekdays (firstname, lastname, language, monday, tuesday, wednesday, thursday, friday, saturday, sunday) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$mysqli->error;
			//echo $lastname;
			$stmt->bind_param("ssssssssss", $firstname, $lastname, $language, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
			if($stmt->execute()){
				echo "Õnnestus!";
			} else {
				echo "Salvestamisel tekkis tõrge: " .$stmt->error;
			}
			$stmt->close();
			$mysqli->close();
			cleanVariables();
		}
	}

	//sisestuse kontrollimise funktsioon
	function testInput($input) {
		$input = trim($input); //eemaldab ebavajaliku - liigsed tühikud, TAB, reavahetused
		$input = stripslashes($input); //eemaldab kaldkriipsud "\"
		$input = htmlspecialchars($input); //see mul juba vormi action atribuudi väärtuses olemas, eemaldab keelatud märgid.
		return $input;
	}	
	
function cleanVariables(){
	$GLOBALS["language"] = "";
	$GLOBALS["monday"] = "";
	$GLOBALS["tuesday"] = "";
	$GLOBALS["wednesday"] = "";
	$GLOBALS["thursday"] = "";
	$GLOBALS["friday"] = "";
	$GLOBALS["saturday"] = "";
	$GLOBALS["sunday"] = "";
}
	
	
	?>
<!DOCTYPE html>
<html lang="et">
<head>
<title>Kontrolltöö variant 3</title>
</head>
<body>
<h1>Salvestame nädalapäevade nimed mingis keeles</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<label>Eesnimi </label><input name="firstname" type="text" value="<?php echo $firstname; ?>"><br>
	<label>Perekonnanimi </label><input name="lastname" type="text" value="<?php echo $lastname; ?>"><br>
	
	<?php
		if(!empty($firstname) and !empty($lastname)){
			require("addWeekdays.php");
		}
	?>
	<input type="submit" name="saveweekdays" value="Salvesta">
</form>
</body>
</html>