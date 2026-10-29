<?php

function getAllWorkouts(PDO $pdo):array
{
    $sql='SELECT workout_id,workout_name,duration_minutes FROM workout ORDER BY workout_name';
    return $pdo->query($sql)->fetchAll();

}
