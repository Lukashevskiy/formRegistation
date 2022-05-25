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

    <pre><?php
        $payment_array = [
            "WebMoney",
            "Яндекс Деньги",
            "PayPal",
            "Кредитная карта"
        ];
        $theme_array = [
            "Бизнес",
            "Технологии",
            "Маркетинг"
        ];

        $themeSelected = '';
        $errors = [];
        $dir_to_save = "clients/";
        $file_to_save = 'clients';
        $key = 0;

        $fname = $_POST['firstName'] ?? null;
        $lname = $_POST['lastName'] ?? null;
        $email = $_POST['email'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $theme = $_POST['theme'] ?? null;
        $themeSelected = $_POST['themeSelected'] ?? null;
        $payment = $_POST['payment'] ?? null;
        $confirm = (bool)($_POST['mailing'] ?? 0);

        if ($_POST) {
            $error = '';
            if (!$fname) {
                $errors[] = 'name';
            }
            if (!$lname) {
                $errors[] = 'last';;
            }
            if (!$email) {
                $errors[] = 'email';
            }
            if (!$theme) {
                $errors[] = 'theme';
            }
            if (!$payment) {
                $errors[] = 'payment';
            }
            if (!$phone) {
                $errors[] = 'phone';
            }


            if (isset($errors) and empty($errors)) {
                $out = 0;
                $out = date("d-m-y_h-m-s") ."\t".
                $_SERVER['REMOTE_ADDR']."\t".
                $fname . "\t" . $lname . "\t" .
                $email . "\t" . $phone . "\t" .
                $theme . "\t" . $payment . "\t" .
                (!$confirm ? 'Нет':'Да') . "\t". '0' .PHP_EOL;

            if (!is_dir($dir_to_save)) {
                mkdir($dir_to_save);
            }

                file_put_contents($dir_to_save.$file_to_save, $out, FILE_APPEND);
                header("Location: index.php?registration-complete=Ok");
                $key = 1;
            } else if ($key === 1) {
                $key = 0;
                header("Location: index.php");
            }
        }

    ?></pre>
    <?php if (isset($_GET['registration-complete']) and $_GET['registration-complete'] === 'Ok') : ?>
        <div class="container-md py-4">
            <div class="row justify-content-center">
                <div class="col col-lg-6">
                    <a href='admin.php'>админ?</a>
                    <h1>Успех!</h1>
                </div>
            </div>
        </div>
    <?php else : ?>
    <div class="row justify-content-center">
        <div class="col-5">
            <h1>Регистрация</h1>
            <div class="col-12 visually-hidden" >
                <?php var_dump($_POST);
                var_dump($_SERVER['REMOTE_ADDR']);
                var_dump(date("d-m-y_h-m-s"));?>
            </div>
            <form method="post" class="needs-validation" style="margin-top: 50px">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">Имя</label>
                        <input type="text" name="firstName" class="form-control<?php echo(in_array('name', $errors)) ? ' is-invalid' : ''?>" id="firstName" placeholder="" value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>" required="">
                        <div class="invalid-feedback">
                            Некоррекное имя
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">Фамилия</label>
                        <input type="text" name="lastName" class="form-control<?php echo(in_array('last', $errors)) ? ' is-invalid' : ''?>" id="lastName" placeholder="" value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>" required="">
                        <div class="invalid-feedback">
                            Некорректная фамилия
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control<?php echo(in_array('email', $errors)) ? ' is-invalid' : ''?>" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                        <div class="invalid-feedback">
                            Пожалуйста введите корректный адресс почты, именно на него придет подтверждение о регистрации.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input type="tel" name="phone" class="form-control<?php echo(in_array('phone', $errors)) ? ' is-invalid' : ''?>" id="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                        <div class="invalid-feedback">
                            Пожалуйста введите корректный адресс почты, именно на него мы будет вести связь с вами.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo '<label for="theme" class="form-label">Тема</label>';
                        echo '<select name="theme" class="form-select'.
                            (in_array('theme', $errors) ? ' is_invalid"': ' is_valid"') .
                            ' id="payment" aria-label="Тема">';

                        echo '<option'. (!$theme ? ' selected' : ' ') . '></option>';

                        foreach($theme_array as $themes){
                            echo '<option'. ($themes === $theme ? ' selected': '') .
                                '>' .
                                htmlspecialchars($themes) .
                                '</option>';
                        }
                        echo '</select>';

                        echo "<div class= invalid-feedback >";
                        echo " Выберите тему";
                        echo "</div>";
                        ?>

                    </div>

                    <div class="col-sm-6">
                        <?php
                            echo '<label for="payment" class="form-label">Cпособ оплаты</label>';
                            echo '<select name="payment" class="form-select'.
                                (in_array('payment', $errors) ? ' is_invalid"': ' is_valid"') .
                                ' id="payment" aria-label="Способ оплаты">';

                            echo '<option'. (!$payment ? ' selected' : ' ') . '></option>';

                            foreach($payment_array as $pay){
                                echo '<option'. ($payment === $pay ? ' selected': '') .
                                    '>' .
                                    htmlspecialchars($pay) .
                                    '</option>';
                            }
                            echo '</select>';

                            echo "<div class= invalid-feedback >";
                            echo " Выберите способ оплаты ";
                            echo "</div>";
                        ?>
                    </div>
                    <div class="col-12">
                        <input class="form-check-input" type="checkbox" value="1" id="mailing" name="mailing" <?php echo $confirm == "1" ? 'checked':'' ?> >
                        <label class="form-check-label" for="mailing">
                            Выбрав, соглашаетесь на рассылку новостей на указанную почту и номер телефона.
                        </label>
                    </div>
                    <button class="btn btn-primary btn-lg" type="submit">Зарегистрироваться</button>
                </div>
            </form>
        </div>

    </div>
    <?php endif;?>
</body>

</html>