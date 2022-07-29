<?php

$user = 'root';
$pass = 'root';
$dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);

$cars = $dbh->prepare('SELECT * FROM cars');
$cars->execute();

$owners = $dbh->prepare('SELECT * FROM old_owners');
$owners->execute();

$getAuto = $dbh->prepare("SELECT title, id FROM cars");
$getAuto->execute();

function getTitleAuto($id)
{
    $user = 'root';
    $pass = 'root';
    $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $pass);
    $getTitleAuto = $dbh->prepare("SELECT title FROM cars WHERE id = $id");
    $getTitleAuto->execute();

    foreach ($getTitleAuto as $item) {
        echo $item['title'];
    }
}

//Обычно в формах указыввется action! Я не делал для того, чтобы не создавать лишние страницы.
if (isset($_POST['title']) AND !empty($_POST['title'])) {
    $sql = "INSERT INTO cars (title, description, engine, fuel, price) VALUES (:title, :description, :engine, :fuel, :price)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':title', $_POST['title']);
    $stmt->bindParam(':description', $_POST['description']);
    $stmt->bindParam(':engine', $_POST['engine']);
    $stmt->bindParam(':fuel', $_POST['fuel'] );
    $stmt->bindParam(':price', $_POST['price'] );
    $stmt->execute();
    header('Location: /');
}

if (isset($_POST['name']) AND !empty($_POST['name'])) {
var_dump($_POST);
    $sql = "INSERT INTO old_owners (name, surname, cars_id) VALUES (:name, :surname, :cars_id)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name', $_POST['name']);
    $stmt->bindParam(':surname', $_POST['surname']);
    $stmt->bindParam(':cars_id', $_POST['cars_id']);
    $stmt->execute();
    header('Location: /');
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Тестовое задание</title>
</head>
<body>

<div class="container mt-2">
    <h3 class="mb-3">Тестовое задание</h3>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#auto"> Добавить авто </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#user"> Добавить пользователя </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#get-auto"> Все марки авто </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#get-user"> Все пользователи </a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="auto">
            <div class="row border g-0 rounded shadow-sm">
                <div class="col p-4">

                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" name="description" class="form-control" id="description">
                        </div>
                        <div class="mb-3">
                            <label for="engine" class="form-label">Engine</label>
                            <input type="text" name="engine" class="form-control" id="engine">
                        </div>
                        <div class="mb-3">
                            <label for="fuel" class="form-label">Fuel</label>
                            <input type="text" name="fuel" class="form-control" id="fuel">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" name="price" class="form-control" id="price">
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>

                </div>
            </div>
        </div>

        <div class="tab-pane" id="user">
            <div class="row border g-0 rounded shadow-sm">
                <div class="col p-4">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" name="surname" class="form-control" id="surname">
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Your Auto</label>
                            <select class="form-select" name="cars_id">
                                <?php foreach ($getAuto as $auto):?>
                                <option value="<?php echo $auto['id'];?>"> <?php echo $auto['title'];?> </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>

            </div>
        </div>

        <div class="tab-pane" id="get-auto">
            <div class="row border g-0 rounded shadow-sm">
                <div class="col p-4">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Engine</th>
                            <th scope="col">Fuel</th>
                            <th scope="col">Price</th>
                        </tr>
                        </thead>
                        <tbody>
                           <?php foreach($cars as $car): ?>
                                    <tr>
                                        <td><?php echo $car['id']; ?></td>
                                        <td><?php echo $car['title']; ?></td>
                                        <td><?php echo $car['description']; ?></td>
                                        <td><?php echo $car['engine']; ?></td>
                                        <td><?php echo $car['fuel']; ?> L</td>
                                        <td><?php echo $car['price']; ?> $</td>
                                    </tr>
                           <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="tab-pane" id="get-user">
            <div class="row border g-0 rounded shadow-sm">
                <div class="col p-4">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Your Auto</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($owners as $owner): ?>
                            <tr>
                                <td><?php echo $owner['id']; ?></td>
                                <td><?php echo $owner['name']; ?></td>
                                <td><?php echo $owner['surname']; ?></td>
                                <td><?php getTitleAuto($owner['cars_id']); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>