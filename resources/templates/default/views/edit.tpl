<h1><?= esc($title) ?></h1>

<?php if (session('errors')): ?>
    <div class="text-red-500 mb-4">
        <ul>
            <?php foreach (session('errors') as $field => $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/{{entityLower}}/edit/<?= $item->id ?>" method="post">
    <?= csrf_field() ?>
    {{formFields}}
    <button type="submit"><?= lang('CrudGenerator.update') ?></button>
</form>

