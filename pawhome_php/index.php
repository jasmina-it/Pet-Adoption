<?php
$pageTitle = 'Панахана';
$activePage = 'home';
require __DIR__ . '/includes/header.php';
?>
<main>
    <section class="hero">
        <div class="hero-content">
            <span class="eyebrow">Әр жануар үйге лайық</span>
            <h1>Кішкентай табандар.<br><span>Үлкен махаббат.</span></h1>
            <p>Біз жануарларға қамқор отбасы табуға көмектесеміз. Мүмкін, жаңа ең жақын досың дәл осында күтіп отыр.</p>
            <div class="hero-actions">
                <a href="animals.php" class="btn btn-primary">Дос табу &rarr;</a>
                <a href="#about" class="btn btn-outline">Біз туралы</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=1000" alt="Отбасын күтіп отырған ит">
            <div class="image-label">❤️ Біреуге үй сыйла</div>
        </div>
    </section>

    <section class="features">
        <div class="feature"><span>🏡</span><h3>Жаңа үй</h3><p>Әр жануарға отбасы табуға көмектесеміз.</p></div>
        <div class="feature"><span>❤️</span><h3>Қамқорлық</h3><p>Әр жануар махаббатқа лайық.</p></div>
        <div class="feature"><span>🐾</span><h3>Адал дос</h3><p>Отбасыңның бір мүшесіне айналатын жануарды тап.</p></div>
    </section>

    <section class="about" id="about">
        <span class="eyebrow">Жоба туралы</span>
        <h2>Үй қамқорлықтан басталады</h2>
        <p>PawHome болашақ иелерін панаханадағы жануарлармен таныстырады. Мұнда үй жануарлары туралы біліп, жауапты асырап алуға бірінші қадам жасауға болады.</p>
        <a href="animals.php" class="btn btn-primary">Жануарларды қарау &rarr;</a>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
