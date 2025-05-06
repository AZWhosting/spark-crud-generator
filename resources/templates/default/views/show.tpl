<h1><?= esc($title) ?></h1>

<ul>
{{showFields}}
</ul>

<p><a href="/{{entityLower}}"><?= lang('CrudGenerator.backToList') ?></a></p>