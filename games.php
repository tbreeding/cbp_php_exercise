<?php
require_once './db.php';

define('DB_HOST', 'localhost'); // address of the server
define('DB_NAME', 'games');     // name of the database
define('DB_USER', 'test_db');      // username
define('DB_PASS', 'test123');  // password

$query = "
    SELECT *
    FROM `game`
";

$games = db::select($query);

// var_dump($games);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main.css">
    <script>
    const games = <?php echo json_encode($games); ?>;
</script>
</head>
<body>
    <div class="container">
    <?php foreach($games as $value) : ?>
        <div class="game">
            <div class="image">
                <img src="<?= $value['image_url'] ?>" />
                <div class="rating"><h2>Rating: </h2><p><?= $value['rating'] ?></p></div>
            </div>
            <div class="info">
                <h2 class="name"><?= $value['name'] ?></h2>
                <div class="description">
                <?= $value['description'] ?>
                </div>
                <div class="release">Released at: <?= $value['released_at'] ?></div>      
            </div>
        </div>
    <?php endforeach ?>
    </div>
</body>
</html>

