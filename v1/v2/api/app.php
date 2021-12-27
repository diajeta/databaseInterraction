<?php
require_once 'headers.php';

$conn = new mysqli('localhost', 'root', '', 'school');
$conn2 = new mysqli('localhost', 'root', '', 'school2');
$conn3 = new mysqli('localhost', 'root', '', 'school3');
$session = '2018/2019';
$term = '1';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if($term == 1){
	
		if(isset($_GET['id'])){

			$id = $_GET['id'];
			$theclass = $_GET['theclass'];

			$sql = $conn->query("SELECT * FROM `$theclass` WHERE admNo = '$id' AND session = '$session'");
			$data1 = $sql->fetch_assoc();
		}else{

			$theclass = $_GET['theclass'];
			$thesubject = $_GET['thesubject'];
			$test1 = $thesubject.'1';
			$test2 = $thesubject.'2';
			$testE = $thesubject.'E';
			$testT = $thesubject.'T';
			$testG = $thesubject.'G';

			$data1 = array();

			$sql = $conn->query("SELECT `admNo`, `name`, `$test1` as 'test1', `$test2` as 'test2', `$testE` as 'exam', `$testT` as 'total', `$testG` as 'grade' FROM `$theclass` WHERE session = '$session'");

			while($d = $sql->fetch_assoc()){
				$data1[] = $d;
			}
	
		}


		exit(json_encode($data1));
	
	}elseif($term == 2){
		
		if(isset($_GET['id'])){

			$id = $_GET['id'];
			$theclass = $_GET['theclass'];

			$sql = $conn2->query("SELECT * FROM `$theclass` WHERE admNo = '$id' AND session = '$session'");
			$data1 = $sql->fetch_assoc();
		}else{

			$theclass = $_GET['theclass'];
			$thesubject = $_GET['thesubject'];
			$test1 = $thesubject.'1';
			$test2 = $thesubject.'2';
			$testE = $thesubject.'E';
			$testT = $thesubject.'T';
			$testG = $thesubject.'G';

			$data1 = array();

			$sql = $conn2->query("SELECT `admNo`, `name`, `$test1` as 'test1', `$test2` as 'test2', `$testE` as 'exam', `$testT` as 'total', `$testG` as 'grade' FROM `$theclass` WHERE session = '$session'");

			while($d = $sql->fetch_assoc()){
				$data1[] = $d;
			}
	
		}


		exit(json_encode($data1));
	
	}elseif($term == 3){
	
		if(isset($_GET['id'])){

			$id = $_GET['id'];
			$theclass = $_GET['theclass'];

			$sql = $conn2->query("SELECT * FROM `$theclass` WHERE admNo = '$id' AND session = '$session'");
			$data1 = $sql->fetch_assoc();
		}else{
			

			$theclass = $_GET['theclass'];
			$thesubject = $_GET['thesubject'];
			/*$theclass = 'ss1a';
			$thesubject = 'ma';*/
			$test1 = $thesubject.'1';
			$test2 = $thesubject.'2';
			$testE = $thesubject.'E';
			$testT = $thesubject.'T';
			$test11 = $thesubject.'11';
			$test22 = $thesubject.'22';
			$testTT = $thesubject.'TT';
			$testG = $thesubject.'G';

			$sql = $conn3->query("SELECT `admNo`, `name`, `$test1` as 'test1', `$test2` as 'test2', `$testE` as 'exam', `$testT` as 'total', `$test11` as 'test11', `$test22` as 'test22', `$testTT` as 'totalAll', `$testG` as 'grade' FROM `$theclass` WHERE session = '$session'");

			while($d = $sql->fetch_assoc()){
				$data1[] = $d;
			}

		}


		exit(json_encode($data1));
	
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	if($term == 1){
			parse_str(file_get_contents("php://input"),$post_vars);
			
			$id = $post_vars['id'];

			$theSubject = $post_vars['theSubject'];
			$firstTest = $theSubject."1";
			$secondTest = $theSubject."2";
			$examScore = $theSubject."E";
			$totalScore = $theSubject."T";
			$gradeVal = $theSubject."G";
			$grade = checkGrade($post_vars['total']);
			$term1 = $firstTest."1";
			
			$sql = $conn->query("UPDATE `".$post_vars['theClass']."` SET `$firstTest` = '".$post_vars['test1']."', `$secondTest` = '".$post_vars['test2']."', `$examScore` ='".$post_vars['exam']."', `$totalScore` = '".$post_vars['total']."', `$gradeVal` ='$grade' WHERE `admNo` = '$id' AND `session` = '$session'"); 

			$sql3 = $conn3->query("UPDATE `".$post_vars['theClass']."` SET `$term1` = '".$post_vars['total']."' WHERE `admNo` = '$id' AND `session` = '$session'");

			if($sql){
				exit(json_encode(array('status' => 'success')));
			}else{
				exit(json_encode(array('status' => 'error')));
			}

	}
	if($term == 2){
		if(isset($_GET['id'])){
			$id = $conn2->real_escape_string($_GET['id']);

			$data = json_decode(file_get_contents("php://input"));
			$term2 = $data->test1Val."2";
			
			$sql = $conn2->query("UPDATE `".$data->theClass."` SET `".$data->test1Val."` = '".$data->test1."', `".$data->test2Val."` = '".$data->test2."', `".$data->examVal."` ='".$data->exam."', `".$data->totalVal."` = '".$data->total."', `".$data->gradeVal."` ='".$data->grade."' WHERE `admNo` = '".$data->admNo."' AND `session` = '$session'"); 

			$sql3 = $conn3->query("UPDATE `".$data->theClass."` SET `$term2` = '".$data->total."' WHERE `admNo` = '".$data->admNo."' AND `session` = '$session'");

			if($sql){
				exit(json_encode(array('status' => 'success')));
			}else{
				exit(json_encode(array('status' => 'error')));
			}

		}
	}
	if($term == 3){
		if(isset($_GET['id'])){
			$id = $conn3->real_escape_string($_GET['id']);
			
			$data = json_decode(file_get_contents("php://input"));
			$sql = $conn3->query("UPDATE `$theClass` SET `".$data->ftest."` = '".$data->ftestV."', `".$data->stest."` = '".$data->stestV."', `".$data->exam."` ='".$data->examV."', `".$data->total1."` = '".$data->total1V."', `".$data->total2."` = '".$data->total2V."', `".$data->grade."` ='".$data->gradeV."' WHERE `admNo` = '$id' AND `session` = '$session'");

			if($sql){
				exit(json_encode(array('status' => 'success')));
			}else{
				exit(json_encode(array('status' => 'error')));
			}

		}
	}
}

function checkGrade($en){
    if ($en > 89) {
        return 'A1';
    } else if ($en > 79) {
        return 'B2';
    } else if ($en > 69) {
        return 'B3';
    } else if ($en > 59) {
        return 'C4';
    } else if ($en > 54) {
        return 'C5';
    } else if ($en > 49) {
        return 'C6';
    } else if ($en > 44) {
        return 'D7';
    } else if ($en > 39) {
        return 'E8';
    } else { return 'F9'; }
}

