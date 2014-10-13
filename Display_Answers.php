<?php
	session_start();
	include("Connection.php");
	
	$start = $_POST['question'];
	$noOfQuestion = mysqli_num_rows(mysqli_query($con,"SELECT * FROM questions"));
	$question = "";
	$questionRecord = mysqli_query($con,"SELECT * FROM questions WHERE q_id=".$start);
	while($row = mysqli_fetch_array($questionRecord )){
		$question = $row['question'];
	}
	//$start = mysqli_num_rows($questionRecord);	
	$choices = array();
	$choicesRecord = mysqli_query($con,"SELECT * FROM choices WHERE q_id=".$start);
	while($row = mysqli_fetch_array($choicesRecord)){
		array_push($choices,$row['answer']);
	}
	
	$userChoice = "";
	$userChoiceResult = mysqli_query($con,"SELECT * FROM user_test WHERE q_id=".$start." and u_id=".$_SESSION['user_id']);
	while($row = mysqli_fetch_array($userChoiceResult)){
		$userChoice = $row['u_answer'];
	}
	
	$correctAnswerResult = mysqli_query($con,"SELECT answer FROM choices WHERE q_id=".$start." and correct=true");
	$correctAnswer = "";
	while($row = mysqli_fetch_array($correctAnswerResult)){
		$correctAnswer = $row['answer'];
	}
?>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
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
			<li><p name="userQuestion" id=""><?=$start; ?>. <?= $question; ?></p><br></li>
			<?php
				foreach($choices as $choice){
					if($choice == $userChoice){
				?>
				<li><input type="radio" name="userAnswer" value="<?=$choice;?>" checked><?=$choice;?></li>
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
<?php
if($userChoice != $correctAnswer){
?>
	<span class="tabs" style="color:green">Correct Answers is: <?= $correctAnswer; ?></span>
<?php	
}else{
	echo "";
}
?>