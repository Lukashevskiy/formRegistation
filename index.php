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

        use Form\Form;

        include 'form.php';
        $form =  new Form($_POST);

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

        if ($_POST) {
            $errors = $form->empty_fields();

            if (empty($errors)) {
                $form->write_data();
                header("Location: index.php?registration-complete=Ok");
            }else{
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
                <div class="col-12" >
                    <?php
                    #var_dump($_POST);
                    #var_dump($_SERVER['REMOTE_ADDR']);
                    #var_dump(date("d-m-y_h-m-s"));
                    var_dump($form->get_data());
                    ?>

                </div>
                <form method="post" class="needs-validation" style="margin-top: 50px" novalidate>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">Имя</label>
                            <input type="text" name="firstName" class="form-control<?php echo $form->is_empty_field('firstName') ? ' is-invalid' : ' is-valid'?>" id="firstName" placeholder="" value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>" required="">
                            <div class="invalid-feedback">
                                Некоррекное имя
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Фамилия</label>
                            <input type="text" name="lastName" class="form-control<?php echo$form->is_empty_field('lastName') ? ' is-invalid' : ' is-valid'?>" id="lastName" placeholder="" value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>" required="">
                            <div class="invalid-feedback">
                                Некорректная фамилия
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control<?php echo $form->is_empty_field('email') ? ' is-invalid' : ' is-valid'?>" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                            <div class="invalid-feedback">
                                Пожалуйста введите корректный адресс почты, именно на него придет подтверждение о регистрации.
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Номер телефона</label>
                            <input type="tel" name="phone" class="form-control<?php echo $form->is_empty_field('phone') ? ' is-invalid' : ' is-valid'?>" id="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                            <div class="invalid-feedback">
                                Пожалуйста введите корректный адресс почты, именно на него мы будет вести связь с вами.
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            echo '<label for="theme" class="form-label">Тема</label>';
                            echo '<select name="theme" class="form-select' . ($form->is_empty_field('theme') ? ' is-invalid"': ' is-valid"') . ' id="payment" aria-label="Тема">';

                            echo '<option'. (!$theme ? ' selected' : ' ') . '  ></option>';

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
                                (in_array('payment', $errors) ? ' is-invalid"': ' is-valid"') .
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