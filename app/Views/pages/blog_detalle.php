<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-hero">
    <div class="container center narrow">
        <span class="eyebrow">Blog</span>
        <h1><?= esc($post['title']) ?></h1>
        <p>Publicado el <?= esc(site_datetime($post['created_at'] ?? null, 'd/m/Y - H:i')) ?></p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <?php if (! empty($post['image_path'])): ?>
            <div class="media-block mb-4">
                <img src="<?= base_url($post['image_path']) ?>" alt="<?= esc($post['title']) ?>">
            </div>
        <?php endif; ?>
        <article class="mini-card">
            <?= $post['content'] ?>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
