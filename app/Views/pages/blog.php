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
    <div class="container">
        <?php foreach ($posts as $post): ?>
            <?php $postUrl = base_url('blog/' . site_slugify((string) ($post['slug'] ?? $post['title'] ?? ''), 'entrada')); ?>
            <article class="card mb-3 border-0 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <a href="<?= $postUrl ?>">
                            <img src="<?= base_url($post['image_path'] ?: 'assets/media/logo-pot.png') ?>" class="img-fluid rounded-start h-100 w-100 object-fit-cover" alt="<?= esc($post['title']) ?>">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body h-100 d-flex flex-column">
                            <h2 class="card-title h4"><a href="<?= $postUrl ?>" class="text-reset text-decoration-none"><?= esc($post['title']) ?></a></h2>
                            <p class="card-text"><?= esc(mb_substr(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content']))), 0, 220)) ?><?= mb_strlen(trim(preg_replace('/\s+/', ' ', strip_tags((string) $post['content'])))) > 220 ? '…' : '' ?></p>
                            <div class="mt-auto d-flex flex-wrap gap-3 align-items-center justify-content-between">
                                <p class="card-text mb-0"><small class="text-body-secondary"><?= esc(site_datetime($post['created_at'] ?? null, 'd/m/Y')) ?></small></p>
                                <a href="<?= $postUrl ?>" class="btn btn-outline btn-small">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?= $this->endSection() ?>
