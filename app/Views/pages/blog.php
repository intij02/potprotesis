<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Blog</span>
        <h1>Artículos y novedades</h1>
        <p>Contenido sobre procesos, recomendaciones y comunicación clínica con el laboratorio.</p>
    </div>
</section>

<section class="section">
    <?php foreach ($posts as $index => $post): ?>
        <section class="section<?= $index % 2 === 1 ? ' muted' : '' ?>">
            <div class="container split<?= $index % 2 === 1 ? ' reverse' : '' ?>">
                <div class="media-block">
                    <a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>">
                        <img src="<?= base_url($post['image_path'] ?: 'assets/media/logo-pot.png') ?>" alt="<?= esc($post['title']) ?>">
                    </a>
                </div>
                <div class="content-block">
                    <span class="eyebrow">Entrada reciente</span>
                    <h2><a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>" class="text-reset text-decoration-none"><?= esc($post['title']) ?></a></h2>
                    <p><?= esc(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content']))), 0, 220)) ?><?= mb_strlen(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content'])))) > 220 ? '…' : '' ?></p>
                    <a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>" class="btn btn-outline btn-small">Leer más</a>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
</section>
<?= $this->endSection() ?>
