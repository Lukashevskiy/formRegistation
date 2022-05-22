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
            $array_data = file('./clients/clients')
        ?>
    </pre>
    <div class="container-md">
        <div class="justify-content-center">
            <form method="post">
                <?php
                echo '<a class="p3" href="index.php">Вернуться к форме регистрации</a>';
                if ($array_data) {
                    $selected = [];
                    echo "<table class='table'>";
                    echo "<tr>";
                    echo "<th>" . 'Идентификатор' . "</th>";
                    echo "<th>" . 'Дата заявки' . "</th>";
                    echo "<th>" . 'IP отправителя заявки' . "</th>";
                    echo "<th>" . 'Имя' . "</th>";
                    echo "<th>" . 'Фамилия' . "</th>";
                    echo "<th>" . 'Email' . "</th>";
                    echo "<th>" . 'Номер телефона' . "</th>";
                    echo "<th>" . 'Тема' . "</th>";
                    echo "<th>" . 'Метод оплаты' . "</th>";
                    echo "<th>" . 'Рассылка' . "</th>";
                    echo "</tr>";
                    $ch = 0;
                    foreach ($array_data as $el) {
                        $user_data = explode("\t", $el);
                       // var_dump($user_data);
                        if (end($user_data) == 0) {
                            echo "<tr>";
                            echo "<td>";
                            echo "<div class='form-check form-check-inline'>";
                            echo "<input class='form-check-input' type='checkbox' name=" . $ch . ">";
                            echo "<label for=" . $ch . ">" . uniqid() . "</label>";
                            echo "</div>";
                            echo "</td>";
                            for ($i = 0; $i < count($user_data) - 1; $i++) {
                                echo "<td>" . $user_data[$i] . "</td>";
                            }
                            echo "</tr>";
                        }
                        $ch += 1;
                    }
                    echo "</table>";
                    echo "<button class='btn btn-primary ' type=\'submit\'>Безжалостно удалить</button>";

                if ($_POST) {
                    //(array_keys($_POST));
                    foreach (array_keys($_POST) as $post) {
                        $old_data = explode("\t", $array_data[$post]);
                        $old_data[count($old_data) - 1] = 1;
                        //var_dump($old_data);
                        $array_data[$post] = implode("\t",$old_data).PHP_EOL;
                    }
                    #var_dump(print_r($array_data));
                    file_put_contents('clients/clients', $array_data);
                    unset($array_data);
                    //header('Location: admin.php');
                }
                } else echo '<h1>Еще никто не заполнил заявку.</h1>';

                ?>

            </form>
        </div>

    </div>

</body>

</html>
