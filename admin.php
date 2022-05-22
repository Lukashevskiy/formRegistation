<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <title>Form</title>
</head>

<body>
    <pre>
        <?php
        $arr = scandir('clients');
        $clients_is_empty = true;
        foreach ($arr as $i) if (strripos($i, 'txt')) $clients_is_empty = false;

        ?>
    </pre>
    <div class="container-md">
        <div class="justify-content-center">
            <form method="post">
                <?php
                echo '<a class="p3" href="index.php">Вернуться к форме регистрации</a>';
                if (!$clients_is_empty) {
                    $selected = [];
                    echo "<table class='table'>";
                    echo "<tr>";
                    echo "<th>" . 'Идентификатор' . "</th>";
                    echo "<th>" . 'Имя' . "</th>";
                    echo "<th>" . 'Фамилия' . "</th>";
                    echo "<th>" . 'Email' . "</th>";
                    echo "<th>" . 'Номер телефона' . "</th>";
                    echo "<th>" . 'Тема'  . "</th>";
                    echo "<th>" . 'Метод оплаты'  . "</th>";
                    echo "<th>" . 'Рассылка'  . "</th>";
                    echo "</tr>";
                    $ch = 0;
                    foreach ($arr as $dir) {
                        if (strripos($dir, 'txt')) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<div class='form-check form-check-inline'>";
                            echo "<input class='form-check-input' type='checkbox' name=" . $ch . ">";
                            echo "<label for=".$ch.">".uniqid()."</label>";
                            echo "</div>";
                            echo "</td>";
                            $user_data = explode("\t", file_get_contents('clients/'.$dir));
                            for ($i = 0; $i < count($user_data); $i++) {
                                echo "<td>" . $user_data[$i] . "</td>";
                            }
                        }
                        echo "</tr>";
                        $ch += 1;
                    }
                echo "</table>";
                echo "<button class='btn btn-primary' type='submit'>Безжалостно удалить</button>";

                if ($_POST) {
                    foreach (array_keys($_POST) as $post) {
                        var_dump($arr[$post]);
                        unlink('clients/'. $arr[$post]);
                    }
                    header('Location: admin.php');
                }
                $key = 0;
                } else echo '<h1>Еще никто не заполнил заявку.</h1>';
                ?>
            </form>
        </div>

    </div>

</body>

</html>