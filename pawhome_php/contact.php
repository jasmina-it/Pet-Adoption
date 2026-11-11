<?php
require_once __DIR__ . '/includes/functions.php';

$errors = [];
$success = false;
$name = $email = '';
$message = '';
$pet = mb_substr(trim($_GET['pet'] ?? ''), 0, 50); // $_GET: pre-filled from the catalog

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $pet     = mb_substr(trim($_POST['pet'] ?? ''), 0, 50);

    if ($name === '' || mb_strlen($name) > 100) {
        $errors[] = 'Атыңызды енгізіңіз (100 таңбаға дейін).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Дұрыс электрондық пошта мекенжайын енгізіңіз.';
    }
    if (mb_strlen($message) < 10 || mb_strlen($message) > 1000) {
        $errors[] = 'Хабарлама 10 бен 1000 таңба аралығында болуы керек.';
    }
    if (!$errors) {
        $success = true;
        $name = $email = $message = '';
    }
}

$pageTitle = 'Байланыс';
$activePage = 'contact';
require __DIR__ . '/includes/header.php';
?>
<main class="auth-page">
    <section class="auth-card">
        <div class="auth-icon">❤️</div>
        <h1>Панаханамен байланысу</h1>
        <p class="auth-subtitle"><?= $pet !== '' ? 'Сұрақ: ' . e($pet) : 'Асырап алу туралы кез келген сұрақ қойыңыз.' ?></p>

        <?php if ($success): ?>
            <p class="form-message success">Рахмет! Хабарламаңыз қабылданды.</p>
        <?php endif; ?>

        <form method="post" action="contact.php" novalidate>
            <input type="hidden" name="pet" value="<?= e($pet) ?>">
            <div class="form-group">
                <label for="name">Атыңыз</label>
                <input type="text" id="name" name="name" value="<?= e($name) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Электрондық пошта</label>
                <input type="email" id="email" name="email" value="<?= e($email) ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Хабарлама</label>
                <textarea id="message" name="message" rows="5" style="width:100%;padding:13px 14px;border:1px solid #dbe5dc;border-radius:12px;font:inherit"><?= e($message) ?></textarea>
            </div>
            <div class="form-message error" role="alert">
                <?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
            </div>
            <button class="btn btn-primary auth-submit" type="submit">Жіберу</button>
        </form>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
