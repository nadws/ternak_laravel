<input type="hidden" name="kd_user" value="<?= $id_user ?>">
<table class="table ">
    <thead>
        <tr>
            <th>Menu</th>
            <th>Sub Menu</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($menu as $m) : ?>

        <tr>
            <td style="vertical-align: middle;">
                <?= $m->menu ?>
            </td>
            <td>
                <?php $sub = DB::table('tb_sub_menu')
                ->where('id_menu', $m->id_menu)
                ->get() ?>
                <?php foreach ($sub as $s) : ?>
                <?= $s->sub_menu ?> <br>
                <?php endforeach ?>
            </td>
            <td>
                <?php foreach ($sub as $s) : ?>

                <?php $menu_p = DB::table('tb_permission')
                ->where('permission', $s->id_sub_menu)
                ->where('id_user', $id_user)
                ->first() ?>

                <?php if (empty($menu_p->permission)) : ?>
                <input type="checkbox" name="permission[]" value="<?= $s->id_sub_menu ?>" id=""><br>
                <?php else : ?>
                <input type="checkbox" name="permission[]" value="<?= $s->id_sub_menu ?>" checked><br>
                <?php endif ?>

                <?php endforeach ?>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>

</table>