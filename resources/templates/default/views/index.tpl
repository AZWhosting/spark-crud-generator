<h1>Liste des {{entityLower}}</h1>
<a href="/{{entityLower}}/create"><?= lang('CrudGenerator.createNew') ?></a>
<table border="1">
    <tr>
{{theadFields}}
        <th>Actions</th>
    </tr>
    <?php foreach (${{entityLower}}s as ${{entityLower}}): ?>
    <tr>
{{tbodyFields}}
        <td>
            <a href="/{{entityLower}}/edit/<?= ${{entityLower}}->id ?>"><?= lang('CrudGenerator.edit') ?></a>
            <a href="/{{entityLower}}/delete/<?= ${{entityLower}}->id ?>"><?= lang('CrudGenerator.delete') ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
