<?php
$pageTitle = 'Біздің жануарлар';
$activePage = 'animals';
require __DIR__ . '/includes/header.php';

$q    = mb_substr(trim($_GET['q'] ?? ''), 0, 50);
$type = $_GET['type'] ?? 'all';
if (!in_array($type, ['all', 'dog', 'cat'], true)) {
    $type = 'all';
}

$sql    = 'SELECT id, name, type, age, description, image_url FROM animals WHERE 1=1';
$params = [];
if ($type !== 'all') {
    $sql .= ' AND type = :type';
    $params[':type'] = $type;
}
if ($q !== '') {
    $sql .= ' AND name LIKE :q';
    $params[':q'] = '%' . $q . '%';
}
$sql .= ' ORDER BY name';

$stmt = db()->prepare($sql);
$stmt->execute($params);
$animals = $stmt->fetchAll();

function filter_url(string $type, string $q): string
{
    return 'animals.php?' . http_build_query(['type' => $type, 'q' => $q]);
}
?>
<main class="catalog">
    <div class="catalog-heading">
        <span class="eyebrow">Біздің достарымызбен танысыңыз</span>
        <h1>Олар дәл сені күтіп жүр</h1>
        <p>Олардың әрқайсысы мейірімді отбасы құруды армандайды.</p>
    </div>

    <form class="search-container" method="get" action="animals.php">
        <input type="hidden" name="type" value="<?= e($type) ?>">
        <input type="search" name="q" value="<?= e($q) ?>" placeholder="Үй жануарын аты бойынша іздеу..." aria-label="Жануарларды аты бойынша іздеу">
    </form>

    <div class="filters">
        <a class="filter-btn<?= $type === 'all' ? ' active' : '' ?>" href="<?= e(filter_url('all', $q)) ?>">Барлығы</a>
        <a class="filter-btn<?= $type === 'dog' ? ' active' : '' ?>" href="<?= e(filter_url('dog', $q)) ?>">Иттер</a>
        <a class="filter-btn<?= $type === 'cat' ? ' active' : '' ?>" href="<?= e(filter_url('cat', $q)) ?>">Мысықтар</a>
    </div>

    <div class="animal-grid">
        <?php foreach ($animals as $a): ?>
            <article class="animal-card">
                <img src="<?= e($a['image_url']) ?>" alt="<?= e($a['name']) ?>">
                <div class="animal-info">
                    <span class="animal-type"><?= $a['type'] === 'dog' ? 'Ит' : 'Мысық' ?></span>
                    <h2><?= e($a['name']) ?></h2>
                    <p><?= e($a['age']) ?> · <?= e($a['description']) ?></p>
                    <a class="animal-btn" href="<?= is_logged_in() ? 'dashboard.php' : 'register.php' ?>">Танысу: <?= e($a['name']) ?> &rarr;</a>
                </div>
            </article>
        <?php endforeach; ?>
        <?php if (!$animals): ?>
            <p class="no-results">Сұранысыңыз бойынша жануарлар табылмады.</p>
        <?php endif; ?>
    </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
