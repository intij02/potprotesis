<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'POT Prótesis Dental') ?></title>
    <meta name="description" content="<?= esc($metaDescription ?? 'POT Prótesis Dental') ?>">
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
    <?= $this->include('layouts/partials/header') ?>
    <main>
        <?= $this->renderSection('content') ?>
    </main>
    <?= $this->include('layouts/partials/footer') ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        (() => {
            const loadingText = 'Enviando...';

            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (event.defaultPrevented) {
                        return;
                    }

                    const submitButton = event.submitter ?? form.querySelector('button[type="submit"], input[type="submit"]');

                    if (!submitButton || submitButton.dataset.loadingApplied === 'true') {
                        return;
                    }

                    submitButton.dataset.loadingApplied = 'true';
                    submitButton.disabled = true;
                    submitButton.classList.add('is-loading');

                    if (submitButton.tagName === 'BUTTON') {
                        if (!submitButton.dataset.originalLabel) {
                            submitButton.dataset.originalLabel = submitButton.innerHTML;
                        }

                        submitButton.innerHTML = '<span class="btn-spinner" aria-hidden="true"></span><span>' + loadingText + '</span>';
                    } else if (submitButton instanceof HTMLInputElement) {
                        if (!submitButton.dataset.originalValue) {
                            submitButton.dataset.originalValue = submitButton.value;
                        }

                        submitButton.value = loadingText;
                    }
                });
            });
        })();
    </script>
</body>
</html>
