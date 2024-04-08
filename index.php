<?php

$host = "localhost";

$user = "root";

$pass = "";

$db = "menumagic";

$param = "mysql:dbname=" . $db . ";host=" . $host;

$pdo = new PDO($param, $user, $pass);

$pdo->query('SET NAMES utf8;');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    $items = NULL;
    $sum = NULL;
} else {

    $sql = "SELECT name,price FROM menu ORDER BY RAND() LIMIT 5";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    $items = $stmt->fetchAll();

    $sum = 0;

    foreach ($items as $item) {
        $sum += $item['price'];
    }


    $prices = array_column($items, 'price');

    array_multisort($prices, SORT_ASC, $items);

    unset($pdo);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body id="main" class="bg-dark-subtle">
    <div class="container">
        <div class="col-md-12 text-center">
            <div class="card mt-3">
                <img src="angel.jpg" class="card-img-top" alt="天使です">
            </div>
            <div class="card  px-5 py-5 my-5 col-lg-12 col-md-12">
                <?php if (isset($items)) : ?>
                    <?php foreach ($items as $item) : ?>
                        <div class="text_size">
                            <li class="list-group-item">
                                <?php echo $item['name']; ?>
                                <?php echo $item['price']; ?>円<br>
                            </li>
                        </div>
                    <?php endforeach; ?>

                    <?php if (isset($sum)) : ?>
                        <div class="total mt-4">
                            合計金額<br>
                            <?php echo number_format($sum) ?>円
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="message">サイゼリアのメニュー計５０個の中から、ランダムで５個提案してくれるアプリです。<br>
                        あなたの今日のメニューはこれで決定です。</div>
                <?php endif; ?>
            </div>

            <form method="POST">
                <div class="mt-5">
                    <input type="submit" class="btn btn-success btn-lg py-3" value="あなたの今日のメニューを提案！！" />
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>


</html>