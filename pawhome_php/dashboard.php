<?php
require_once __DIR__ . '/includes/functions.php';
require_login(); 

$stmt = db()->prepare('SELECT full_name, email, created_at FROM users WHERE id = :id');
$stmt->execute([':id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
if (!$user) { 
    $_SESSION = [];
    redirect('login.php');
}

$pageTitle = 'Жеке кабинет';
$activePage = 'dashboard';
require __DIR__ . '/includes/header.php';
?>
<main class="auth-page">
    <section class="auth-card">
        <div class="auth-icon"></div>
        <h1>Сәлем, <?= e($user['full_name']) ?>!</h1>
        <p class="auth-subtitle">Бұл бетті тек жүйеге кірген пайдаланушылар көре алады.</p>
        <p><strong>Электрондық пошта:</strong> <?= e($user['email']) ?></p>
        <p><strong>Тіркелген күні:</strong> <?= e(date('d.m.Y', strtotime($user['created_at']))) ?></p>
        <a href="animals.php" class="btn btn-primary auth-submit">Жануарларды қарау</a>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
