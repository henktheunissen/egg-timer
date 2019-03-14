<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Egg timer 🐔</title>
</head>


<body>


<div class="container">
    <h1 class="title">Egg timer 🐔</h1>

    <div class="egg">
        <h1 class="time" id="clockdiv">0:00</h1>
        <img class="image" src="https://i.dlpng.com/static/png/338348_preview.png" width="200px">
    </div>

    <?php
    $type = $size = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        } else {
            $name = form_input($_POST["name"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed"; 
            }
        }
        if (empty($_POST["size"])) {
            $sizeErr = "size is required";
        } else {
            $size = form_input($_POST["size"]);
        }
        if (empty($_POST["type"])) {
            $typeErr = "type is required";
        } else {
            $type = form_input($_POST["type"]);
        }
        if (empty($_POST["size"])) {
            $sizeErr = "size is required";
        } else {
            $size = form_input($_POST["size"]);
        }
    }

    function form_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <br>

        <p class="label-radio">Egg size</p>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-choice <?php if (isset($size) && $size=="small") echo "active";?>">
                <input type="radio" name="size" id="option1" autocomplete="off" value="small" > Small
            </label>
            <label class="btn btn-choice <?php if (isset($size) && $size=="medium") echo "active";?>">
                <input type="radio" name="size" id="option2" value="medium" autocomplete="off" > Medium
            </label>
            <label class="btn btn-choice <?php if (isset($size) && $size=="large") echo "active";?>">
                <input type="radio" name="size" id="option3" value="large" autocomplete="off" > Large
            </label>
        </div>

        <br>

        <p class="label-radio">Egg type</p>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-choice <?php if (isset($type) && $type=="soft") echo "active";?>">
                <input type="radio" name="type" id="option1" value="soft" autocomplete="off"  > Soft
            </label>
            <label class="btn btn-choice <?php if (isset($type) && $type=="medium") echo "active";?>">
                <input type="radio" name="type" id="option2" value="medium" autocomplete="off" > Medium
            </label>
            <label class="btn btn-choice <?php if (isset($type) && $type=="hard") echo "active";?>">
                <input type="radio" name="type" id="option3" value="hard" autocomplete="off" > Hard
            </label>
        </div>

        <br>

        <input class="btn btn-success" type="submit" name="submit" value="Start! ⌛">  
    </form>

    <?php
    switch ([$size, $type]) {
        case ['small', 'soft']:
            $cooktime = 3;
            // $cooktime = 0.1;
            // echo $cooktime;
        break;
        case ['small', 'medium'];
            $cooktime = 5.5;
            // echo $cooktime;
        break;
        case ['small', 'hard'];
            $cooktime = 7;
            // echo $cooktime;
        break;
        case ['medium', 'soft'];
            $cooktime = 3.5;
            // echo $cooktime;
        break;
        case ['medium', 'medium'];
            $cooktime = 6.5;
            // echo $cooktime;
        break;
        case ['medium', 'hard'];
            $cooktime = 8;
            // echo $cooktime;
        break;
        case ['large', 'soft'];
            $cooktime = 4;
            // echo $cooktime;
        break;
        case ['large', 'medium'];
            $cooktime = 7.5;
            // echo $cooktime;
        break;
        case ['large', 'hard'];
            $cooktime = 9;
            // echo $cooktime;
        break;
    }
    ?>

</div>


<script type="text/javascript">
var time_in_minutes = <?php echo $cooktime; ?>;
var current_time = Date.parse(new Date());
var deadline = new Date(current_time + time_in_minutes*60*1000);

function time_remaining(endtime){
	var t = Date.parse(endtime) - Date.parse(new Date());
	var seconds = Math.floor( (t/1000) % 60 );
	var minutes = Math.floor( (t/1000/60) % 60 );
	var hours = Math.floor( (t/(1000*60*60)) % 24 );
	var days = Math.floor( t/(1000*60*60*24) );
	return {'total':t, 'days':days, 'hours':hours, 'minutes':minutes, 'seconds':seconds};
}

function run_clock(id,endtime){
	var clock = document.getElementById(id);
	function update_clock(){
		var t = time_remaining(endtime);
		clock.innerHTML = t.minutes+':'+t.seconds;
		if(t.total<=0){ 
            clearInterval(timeinterval); 
            document.getElementById("clockdiv").classList.add("timerstop");
            new Audio('/alarm1.mp3').play()
        }
	}
	update_clock(); // run function once at first to avoid delay
	var timeinterval = setInterval(update_clock,1000);
}

run_clock('clockdiv',deadline);
</script>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>