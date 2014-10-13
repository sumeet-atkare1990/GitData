<?php
	//session_start();
	if(!isset($_SESSION)){
		//$userResponse = $_SESSION['userAnswers'];
		session_start();
	}
	include("Connection.php");
	 
	$userResponse = array();	
	$quest = $_POST['question'];
	$ans = $_POST['answer'];
	mysqli_query($con,"INSERT INTO user_test(u_id,q_id,u_answer) VALUES(".$_SESSION['user_id'].",".$quest.",'".$ans."')");
	//$_SESSION['userAnswers'] = array();
	if(isset($_SESSION['userAnswers1'])){
		//$userResponse = $_SESSION['userAnswer'];
		$rec = array($quest,$ans);
		//array_push($userResponse,$rec);
		array_push($_SESSION['userAnswers1'],$rec);
		
	}else{
		$_SESSION['userAnswers1'] = array();
		/* $userResponse = array($quest,$ans);
		array_push($_SESSION['userAnswers1'],$userResponse); */
		$rec = array($quest,$ans);
		//array_push($userResponse,$rec);
		array_push($_SESSION['userAnswers1'],$rec);
	}
	$noOfQuestion = mysqli_num_rows(mysqli_query($con,"SELECT * FROM questions"));
	//print_r ($_SESSION['userAnswers1']);
	$quest++;
	
	if($quest<=$noOfQuestion){
	$question = "";
	$questionRecord = mysqli_query($con,"SELECT * FROM questions WHERE q_id =".$quest."  limit 1");
	while($row = mysqli_fetch_array($questionRecord )){
		$question = $row['question'];
		$start = $row['q_id'];
	}
	//$start = mysqli_num_rows($questionRecord);	
	$choices = array();
	$choicesRecord = mysqli_query($con,"SELECT * FROM choices WHERE q_id=".$start);
	while($row = mysqli_fetch_array($choicesRecord)){
		array_push($choices,$row['answer']);
	}
	
?>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
   
   $("button").click(function(){
   var question = $("input[name=questionId]").val();
   var answer = $("input[name=userAnswer]:checked").val();
  	$.ajax({
			type: "POST",
			url:"Save_Record.php",
			data:"question="+question+"&answer="+answer,
			success:function(data){
				$("#testScreen").html(data);
				}
		}); 
	}); 
});
</script>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
	<div id="tabsBar">
			<?php				
				for($x=1;$x<=$noOfQuestion;$x++){
					if($x == $start){ //show current question
				?>
					<span class="tabs" style="color:red;"><?= $x;?></span>
				<?php
					}else{
				?>
					<span class="tabs"><?= $x;?></span>
				<?php		
					}
				}
			?>
		</div>
		<input type="hidden" value="<?= $start; ?>" name="questionId"/>
		<div id="testQuestions">
			<ol>
			<li><p name="userQuestion"><?= $quest ?>. <?= $question; ?></p><br></li>
			<?php
				foreach($choices as $choice){
				?>
				<li><input type="radio" name="userAnswer" value="<?=$choice;?>"><?=$choice;?></li>
				<?php
				}
			?>
			<li><br><button>Submit Answer</button></li>
			</ol>
	<div>
<?php
}else{   //Check answers and store result into the database
$answersResult = mysqli_query($con,"SELECT * FROM choices WHERE correct = true order by q_id"); 

$records = array();
while($row = mysqli_fetch_array($answersResult)){
	
	$record = array($row['q_id'],$row['answer']);
	array_push($records,$record);
	
}
$score = 0;
 for($x=0 ;$x<count($records); $x++){
	if(($records[$x][0] == $_SESSION['userAnswers1'][$x][0]) && ($records[$x][1] == $_SESSION['userAnswers1'][$x][1])){
		$score++;
	}
} 
?>
<center>
	<h2>Congratulations <?= $_SESSION['user_id'] ?> on Compeleting the Test<h2>
	<br>
	<br>You have scored: <?=$score; ?> on <?=count($records)?>
	<br>
	<br><a href="Quiz.php">Click Here to go back and see you answers</a>
</center>
<?php
/* for($x=0;$x<count($records);$x++){
	$record = array($records[$x][0],$records[$x][1]);
	
} */
mysqli_close($con);
unset($_SESSION['userAnswers1']);
//unset($_SESSION['user_id']);
}
?>