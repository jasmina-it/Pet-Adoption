<?php
require_once __DIR__ . '/includes/functions.php';
require_guest();

$errors = [];
$name = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['full_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (!csrf_valid()) {
        $errors[] = 'Форма токені жарамсыз. Бетті жаңартып, қайталап көріңіз.';
    }
    if ($name === '' || mb_strlen($name) > 100) {
        $errors[] = 'Атыңызды енгізіңіз (100 таңбаға дейін).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255) {
        $errors[] = 'Дұрыс электрондық пошта мекенжайын енгізіңіз.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Құпия сөз кемінде 8 таңбадан тұруы керек.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Құпия сөздер сәйкес келмейді.';
    }

    if (!$errors) {
        $check = db()->prepare('SELECT id FROM users WHERE email = :email');
        $check->execute([':email' => $email]);
        if ($check->fetch()) {
            $errors[] = 'Бұл поштамен тіркелгі бұрыннан бар.';
        }
    }

    if (!$errors) {
        $insert = db()->prepare(
            'INSERT INTO users (full_name, email, password_hash) VALUES (:name, :email, :hash)'
        );
        $insert->execute([
            ':name'  => $name,
            ':email' => $email,
            ':hash'  => password_hash($password, PASSWORD_DEFAULT),
        ]);
        flash('success', 'Тіркелгі жасалды. Енді кіре аласыз.');
        redirect('login.php');
    }
}

$pageTitle = 'Тіркелу';
require __DIR__ . '/includes/header.php';
?>
<main class="auth-page">
    <section class="auth-card">
        <div class="auth-icon">🐾</div>
        <h1>Тіркелгі жасау</h1>
        <p class="auth-subtitle">Асырап алуға бірінші қадам жасау үшін тіркеліңіз.</p>

        <div class="auth-tabs">
            <a class="auth-tab" href="login.php">Кіру</a>
            <a class="auth-tab active" href="register.php">Тіркелу</a>
        </div>

        <form method="post" action="register.php" novalidate>
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="full_name">Атыңыз</label>
                <input type="text" id="full_name" name="full_name" value="<?= e($name) ?>" placeholder="Мысалы, Асхат" autocomplete="name" required>
            </div>
            <div class="form-group">
                <label for="email">Электрондық пошта</label>
                <input type="email" id="email" name="email" value="<?= e($email) ?>" placeholder="example@gmail.com" autocomplete="email" required>
            </div>
            <div class="form-group">
                <label for="password">Құпия сөз</label>
                <input type="password" id="password" name="password" placeholder="Кемінде 8 таңба" autocomplete="new-password" minlength="8" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Құпия сөзді растаңыз</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Құпия сөзді қайталаңыз" autocomplete="new-password" required>
            </div>

            <div class="form-message error" role="alert">
                <?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
            </div>

            <button class="btn btn-primary auth-submit" type="submit">Тіркелу</button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
