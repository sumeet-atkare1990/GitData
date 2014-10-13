<?php
	session_start();
	$_SESSION['user_id'] = 1;
	//$_SESSION['question_no'] = 1
	include("Connection.php");
	
	$noOfQuestion = mysqli_num_rows(mysqli_query($con,"SELECT * FROM questions"));
	$start = "";
	$question = "";
	$questionRecord = mysqli_query($con,"SELECT * FROM questions order by q_id limit 1");
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
	
	$correctAnswerResult = mysqli_query($con,"SELECT answer FROM choices WHERE q_id=".$start." and correct=true");
	$correctAnswer = "";
	while($row = mysqli_fetch_array($correctAnswerResult)){
		$correctAnswer = $row['answer'];
	}
?>
<html>
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
	
	$("[name=clickableTabs]").click(function(){
		var question = $(this).text();
		$.ajax({
			type: "POST",
			url:"Display_Answers.php",
			data:"question="+question,
			success:function(data){
				$("#testOutput").html(data);
				}
		});
   })
});
</script>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
	<div id="header">
		<h1>WELCOME <?= $_SESSION['user_id']; ?></h1>
	</div>
	<?php
	$userScoreDetails = mysqli_num_rows(mysqli_query($con,"SELECT * FROM user_test WHERE u_id= ".$_SESSION['user_id']));
	if($userScoreDetails<=0){
	?>
	<div id="testScreen">
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
			<li><p name="userQuestion" id="">1. <?= $question; ?></p><br></li>
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
	</div>
	<?php 
	}else{
	
		$userChoiceResult = mysqli_query($con,"SELECT u_answer FROM user_test WHERE q_id = ".$start);
		$userChoice = "";
		while($row = mysqli_fetch_array($userChoiceResult)){
			$userChoice = $row['u_answer'];
		}
	?>
		<div id="testOutput">
			<div id="tabsBar">
			<?php				
				for($x=1;$x<=$noOfQuestion;$x++){
					if($x == $start){ //show current question
				?>
					<span class="tabs" name="clickableTabs" style="color:red;cursor:pointer"><?= $x;?></span>
				<?php
					}else{
				?>
					<span class="tabs" name="clickableTabs" style="cursor:pointer"><?= $x;?></span>
				<?php		
					}
				}
			?>
		</div>
		<input type="hidden" value="<?= $start; ?>" name="questionId"/>
		<div id="testQuestions">
			<ol>
			<li><p name="userQuestion" id="">1. <?= $question; ?></p><br></li>
			<?php
				foreach($choices as $choice){
					if($choice == $userChoice){
				?>
				<li><input type="radio" name="userAnwser" value="<?=$choice;?>" checked="true"><?=$choice;?></li>
				<?php
					}else{
				?>
				<li><input type="radio" name="userAnswer" value="<?=$choice;?>"><?=$choice;?></li>
				<?php
					}
				}
			?>
			</ol>
		<div>
		</div>
	<?php 
	if($userChoice != $correctAnswer){
	?>
		<br><br><span class="tabs" style="color:green">Correct Answers is: <?= $correctAnswer; ?></span>
	<?php
	}else{
		echo "";}
	}
	?>
</body>
</html>