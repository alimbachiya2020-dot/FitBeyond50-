<?php //swtiches into php
require_once __DIR__ .'/db.php'; // loads dp.php which loads config.php
require_once __DIR__ .'/includes/dashboard.php'; // loads doasbhoard functions

$pdo=getDatabaseConnection(); // loads database connections and stored it in $pdo so it can run in sql
$totalXP=getTotalXp($pdo); // adds up all the XP in workout_log
$caloriesToday=getDailyCalories($pdo,date('Y-m-d')); // gives todays date as text , and then it adds up caloriesxquanity for that date and returns a decimal no.
$streak=calculateStreak(getWorkoutDates($pdo),date('Y-m-d'));
//date as stringn

?>

<!DOCTYPE html> <! its html for browser> 
<html> 
<html lang="en"> <!its in english for browser>
<head>
 <meta name="viewport" content="width=device-width,initial-scale=1"> <! makes it fit phones and tablet screens>
 <meta charset="UTF-8"> <!this is the way unicode is stored as bytes, so it tells browser to decode this page using it>
 <title>FitBeyond50</title>

 <style>
 body{
  margin:0;
  background-colour:#D3D3D3;
  font-family:sans-serif;
 }
 .topnav{
 background-color:white;
 width:100%;
 display:flex;
 justify-content:center;
 position:sticky;
 top:0;
 z-index:100;
}
.topnav a{
 color:black;
 text-align:center;
 padding: 16px 24px;
 text-decoration:none;
 font-size:18px;
 font-family:sans-serif;
 border-bottom:3px solid transparent;
}
.topnav a :hover{
 background-color:#ddd;
 color:white;
}

.topnav a.active{
 background-color: white;
 color:Black;
 border-bottom:3px solid black;
}

.main-title{
 color:Black;
 font-family:sans-serif;
 font-size:400%;
 text-align:center;
 margin-top:40px;
 margin-bottom:10px;
}

.dashboard-content{
 max-width:800px;
 margin:0 auto;
 padding:48px 20px 20px 20px;
 text-align:center;
}
.stats-container{
 display:flex;
 justify-content:center;
 gap:100px;
 color:Black;
 margin-top:20px;
 font-size:160%;
}

:root{
    --surface:#fff;
    --border:#d4d9e5;
    --accent:#2563eb;

}
body{
    font-family:"Inter",sans-serif;
    background:#D3D3D3;
    padding:0;
    margin:0;
}
.container{
    display:flex;
    justify-content:center;
    gap:20px;
    max-width:800px;
    margin:20px auto;
}
.card1{
    width:50%;
    margin:0 ;
    padding:16px 28px;
    border:2px solid var(--border);
    border-radius:18px;
    background:var(--surface);
    box-shadow:0 14px 28px rgba(15,23,42,0.08);
}
.card1 p{
    margin:0;
    line-height:1.6;
    font-size:0.85rem;
}
.card2{
    width:50%;
    margin:0 ;
    padding:16px 28px;
    border:2px solid var(--border);
    border-radius:18px;
    background:var(--surface);
    box-shadow:0 14px 28px rgba(15,23,42,0.08);
}
.card2 p{
    margin:0;
    line-height:1.6;
    font-size:0.85rem;
}
.bottom-box{
    max-width:800px;
    margin:20px auto;
    padding:20px 28px;
    border:2px solid var(--border);
    border-radius:18px;
    background:var(--surface);
    box-shadow:0 14px 28px rgba(15,23,42,0.08);
}
h1{
    font-size:20px;
    font-family:"Inter",sans-serif
}
.button{
    border:none;
    color:white;
    padding:15px 32px;
    text-align:center;
    text-decoration:none;
    display:inline-block;
    font-size:16px;
    margin:4px 2px;
    cursor:pointer;
}
.button1{background-color: black;}

.button2{background-color:black}

.button3{
    background-color: black;
    text-align:center;
    }
.center-wrapper{
    text-align:center;
    margin:30px 0;
}
</style>

</head>
<link rel="stylesheet"
href="styles.css"
type="text/css">

 <body>
  <div class="topnav">
   <a class="active" href="index.php">Home</a>
   <a href="workout.php">Workout</a>
   <a href="food.php">Food</a>
   <a href="progress.php">Progress</a>
  </div>

<h1 class="main-title">FitBeyond50</h1>

<div class="dashboard-content">
 <p style="color:Black;font-size:160%">Welcome Sejal,</p>

 <div class="stats-container">

  <div>XP: <?= htmlspecialchars((string)$totalXP) ?></div>
  <!turns number into text, as htmlspecialchars makes it safe to print>
  <div>Streak:<?= htmlspecialchars((string)$streak) ?> days </div>
 </div>
</div>

<div class="container">

 <article class="card1">
    <p>
       <b> Fitness Level</b>:Beginner
    </p>

 </article>

 <article class="card2">
    <h1>
        Today's workout:
    </h1>
    <p>
        Beginner Full Body Cardio
        <a href="workout.php" class="button button1">Start Workout </a>
        </button>

    </p>
 </article>
</div>

 <div class="bottom-box">
    <p>
        <b>Today's Food Log:</b><br>
        <?= number_format($caloriesToday);
        ?> 
        <a href="food.php" class="button button2">Log Food </a>
        </button>
    </p>
 </div>
</div>
<div class="center-wrapper">
    <a href= "progress.php"class="button button3">View Progress </a>
</div>

</Progress></button>
</body>
</html>


