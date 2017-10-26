<?php
	require("../../vpconfig.php");
	$database = "if17_rinde";
	$today = "";
	$weekdayFieldNames = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"];
	$languageSelected = "";

	
	if(isset($_POST["selectLanguage"])){
		if(!empty($_POST["selLang"])){
			//mis kuu on
			$weekdayToday = $weekdayFieldNames[(date("N") - 1)];
			$languageSelected = $_POST["selLang"];
			$language;
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			//echo "hei!";
			if($_POST["selLang"] == "juhuslik keel"){
				$languages = [];
				$stmt = $mysqli->prepare("SELECT language FROM vpweekdays");
				echo $mysqli->error;
				$stmt->bind_result($oneLanguage);
				$stmt->execute();
				while($stmt->fetch()){
					array_push($languages, $oneLanguage);
				}
				$language = $languages[mt_rand(0,count($languages) - 1)];
				$stmt->close();
			} else {
				
				$language = $languageSelected;
				//echo date("n");
				//echo "Kuu on " .$weekdayToday;
			}
			$stmt = $mysqli->prepare("SELECT " .$weekdayToday ." FROM vpweekdays WHERE language = ?");
				$mysqli->error;
				$stmt->bind_param("s", $language);
				$stmt->bind_result($weekdayName);
				$stmt->execute();
				$stmt->fetch();
				$today .= $weekdayName;
				$stmt->close();
				$mysqli->close();
				$today .= ", " .date("d.m.Y.");
				$today .= " Valitud keel: " .$language;
		}
	}
	
	$selectHTML = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT language FROM vpweekdays");
	echo $mysqli->error;
	$stmt->bind_result($oneLanguage);
	$stmt->execute();
	while($stmt->fetch()){
		if($oneLanguage == $languageSelected){
			$selectHTML .= '<option value="' .$oneLanguage .'" selected>' .$oneLanguage ."</option> \n";
		} else {
			$selectHTML .= '<option value="' .$oneLanguage .'">' .$oneLanguage ."</option> \n";
		}
	}
		if($languageSelected == "juhuslik keel"){
			$selectHTML .= '<option value="juhuslik keel" selected>' ."juhuslik keel</option> \n";
		} else {
			$selectHTML .= '<option value="juhuslik keel">' ."juhuslik keel</option> \n";
		}
	$stmt->close();
	$mysqli->close();
	
	?>
<!DOCTYPE html>
<html lang="et">
<head>
<title>Kontrolltöö variant 4</title>
</head>
<body>
<h1>Tänane päev</h1>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<select name="selLang">
		<option value="" selected disabled>Vali keel</option>
		<?php echo $selectHTML;?>
	</select>
	<input type="submit" name="selectLanguage" value="kinnita valik">
</form>
<?php echo $today; ?>
</body>
</html>