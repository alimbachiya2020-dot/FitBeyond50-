<?php

function searchFoods(PDO $pdo, string $searchTerm): array
{
    $sql= 'SELECT food_id,food_name, calories_per_serving,serving_size
    FROM food
    WHERE food_name LIKE :search ORDER BY food_name';
    $statement=$pdo->prepare($sql);
    $statement->execute(['search' => '%' . $searchTerm . '%']);
    return $statement->fetchAll();

}

// Returns one food, or null if that ID doesn't exist
function getFoodById(PDO $pdo, int $foodId): ?array
{
    $sql = 'SELECT food_id, food_name, calories_per_serving FROM food WHERE food_id = :food_id';
    $statement = $pdo->prepare($sql);
    $statement->execute(['food_id' => $foodId]);
    $food = $statement->fetch();

    if ($food === false) {
        return null;
    }
    return $food;
}

function logFood(PDO $pdo, int $foodId, float $quantity, string $date):void
{
    $sql='INSERT INTO food_log(food_id, quantity, date_logged) VALUES (:food_id,:quantity,:date_logged)';
    $statement=$pdo->prepare($sql);
    $statement->execute(['food_id'=>$foodId,'quantity'=>$quantity,'date_logged'=>$date]);

}

// Returns each food logged on a date, with its calories
function getFoodLogForDate(PDO $pdo, string $date): array
{
    $sql = 'SELECT food.food_name,
                   food_log.quantity,
                   food.calories_per_serving * food_log.quantity AS entry_calories
            FROM food_log
            INNER JOIN food ON food_log.food_id = food.food_id
            WHERE food_log.date_logged = :date_logged
            ORDER BY food_log.food_log_id';
    $statement = $pdo->prepare($sql);
    $statement->execute(['date_logged' => $date]);
    return $statement->fetchAll();
}

// Returns every food in alphabetical order
function getAllFoods(PDO $pdo): array
{
    $statement = $pdo->query('SELECT * FROM food ORDER BY food_name');
    return $statement->fetchAll();
}

// Spelling-tolerant search: returns foods spelt similarly to the search, closest first
function findSimilarFoods(string $searchTerm, array $allFoods): array
{
    $search = strtolower($searchTerm);
    $matches = [];

    foreach ($allFoods as $food) {
        $name = strtolower($food['food_name']);

        // Start with the distance to the whole name, e.g. "masla chai" vs "masala chai"
        $bestDistance = editDistance($search, $name);

        // Then try each word on its own, e.g. "dal" vs "daal" in "gujarati daal"
        $words = explode(' ', $name);
        foreach ($words as $word) {
            $distance = editDistance($search, $word);
            if ($distance < $bestDistance) {
                $bestDistance = $distance;
            }
        }

        // Only keep the food if it is close enough
        if ($bestDistance <= MAX_EDIT_DISTANCE) {
            $matches[] = ['food' => $food, 'distance' => $bestDistance];
        }
    }

    // Put the closest matches first (merge sort from includes/fuzzy.php)
    $sortedMatches = mergeSort($matches);

    // The page only needs the food rows, so take them out in the sorted order
    $similarFoods = [];
    foreach ($sortedMatches as $match) {
        $similarFoods[] = $match['food'];
    }
    return $similarFoods;
}
