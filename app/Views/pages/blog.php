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
    <div class="container cards-grid">
        <?php foreach ($posts as $post): ?>
            <article class="service-card">
                <a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>" class="text-decoration-none">
                    <img src="<?= base_url($post['image_path'] ?: 'assets/media/logo-pot.png') ?>" alt="<?= esc($post['title']) ?>">
                </a>
                <div class="card-body">
                    <h2 class="h4"><a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>" class="text-reset text-decoration-none"><?= esc($post['title']) ?></a></h2>
                    <p><?= esc(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content']))), 0, 180)) ?><?= mb_strlen(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content'])))) > 180 ? '…' : '' ?></p>
                    <a href="<?= base_url('blog/' . ($post['slug'] ?? '')) ?>" class="btn btn-outline btn-small">Leer más</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
