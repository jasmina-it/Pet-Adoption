<?php
require_once __DIR__ . '/functions.php';
$pageTitle  = $pageTitle  ?? 'PawHome';
$activePage = $activePage ?? '';
$flash      = get_flash();
function nav_class(string $name, string $active): string
{
    return $name === $active ? ' class="active"' : '';
}
?>
<!DOCTYPE html>
<html lang="kk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | PawHome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="header">
    <nav class="navbar">
        <a href="index.php" class="logo">🐾 PawHome</a>
        <button type="button" class="menu-toggle" aria-label="Мәзірді ашу" aria-expanded="false">☰</button>
        <div class="nav-links">
            <a href="index.php"<?= nav_class('home', $activePage) ?>>Басты бет</a>
            <a href="animals.php"<?= nav_class('animals', $activePage) ?>>Біздің жануарлар</a>
            <a href="contact.php"<?= nav_class('contact', $activePage) ?>>Байланыс</a>
            <a href="index.php#about">Біз туралы</a>
            <?php if (is_logged_in()): ?>
                <a href="dashboard.php"<?= nav_class('dashboard', $activePage) ?>>Жеке кабинет</a>
                <form action="logout.php" method="post" class="logout-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="login-btn">Шығу</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="login-btn">Кіру</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
<?php if ($flash): ?>
    <div class="flash flash-<?= e($flash['type']) ?>" role="status"><?= e($flash['message']) ?></div>
<?php endif; ?>
