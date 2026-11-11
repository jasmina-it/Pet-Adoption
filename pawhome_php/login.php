<?php
require_once __DIR__ . '/includes/functions.php';
require_guest();

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!csrf_valid()) {
        $errors[] = 'Форма токені жарамсыз. Бетті жаңартып, қайталап көріңіз.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Дұрыс электрондық пошта мекенжайын енгізіңіз.';
    }
    if ($password === '') {
        $errors[] = 'Құпия сөзді енгізіңіз.';
    }

    if (!$errors) {
        $stmt = db()->prepare('SELECT id, full_name, password_hash FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true); // prevents session fixation
            $_SESSION['user_id']   = (int) $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            redirect('dashboard.php');
        }
        // One message for both cases, so attackers cannot tell which emails exist.
        $errors[] = 'Электрондық пошта немесе құпия сөз қате.';
    }
}

$pageTitle = 'Кіру';
require __DIR__ . '/includes/header.php';
?>
<main class="auth-page">
    <section class="auth-card">
        <div class="auth-icon">🐾</div>
        <h1>Қайта қош келдіңіз!</h1>
        <p class="auth-subtitle">Үй жануарларымен танысуды жалғастыру үшін жүйеге кіріңіз.</p>

        <div class="auth-tabs">
            <a class="auth-tab active" href="login.php">Кіру</a>
            <a class="auth-tab" href="register.php">Тіркелу</a>
        </div>

        <form method="post" action="login.php" novalidate>
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="email">Электрондық пошта</label>
                <input type="email" id="email" name="email" value="<?= e($email) ?>" placeholder="example@gmail.com" autocomplete="email" required>
            </div>
            <div class="form-group">
                <label for="password">Құпия сөз</label>
                <input type="password" id="password" name="password" placeholder="Құпия сөзді енгізіңіз" autocomplete="current-password" required>
            </div>

            <div class="form-message error" role="alert">
                <?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
            </div>

            <button class="btn btn-primary auth-submit" type="submit">Кіру</button>
        </form>
        <p class="auth-note">Әрбір құйрықты жанға деген махаббатпен</p>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
