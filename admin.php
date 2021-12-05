<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Downloader admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"
            integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/"
            crossorigin="anonymous"></script>
</head>
<body>
<?php
require_once "./Common/Database_worker.php";

$db = new Database_worker();
$db->update("parsing_source_list", [
    "last_dl_date" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/opt_kolesa_daromjson.json")),
    "finish_dl" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/opt_kolesa_daromjson.json"))
], 4);
$db->update("parsing_source_list", [
    "last_dl_date" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/opt_kolesa_daromjson.json")),
    "finish_dl" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/opt_kolesa_daromjson.json"))
], 13);

$db->update("parsing_source_list", [
    "last_dl_date" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/M25949.json")),
    "finish_dl" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/M25949.json")),
], 6);

$db->update("parsing_source_list", [
    "last_dl_date" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/M25949.json")),
    "finish_dl" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/M25949.json")),
], 14);

$db->update("parsing_source_list", [
    "last_dl_date" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/M25949.json")),
    "finish_dl" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/M25949.json")),
], 20);

$db->update("parsing_source_list", [
    "last_dl_date" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/M25949.json")),
    "finish_dl" => date('Y-m-d H:i:s', filemtime("/home/c/cf08116/incoming_files/M25949.json")),
], 22);

$res = $db->do_sql("SELECT psl.*,
       CASE
           WHEN psl.type='tyres' THEN (SELECT COUNT(1) FROM parsing_tyres pt WHERE  psl.source=pt.source)
           WHEN psl.type='wheels' THEN (SELECT COUNT(1) FROM parsing_wheels pw WHERE  psl.source=pw.source)
           WHEN psl.type='sensor' THEN (SELECT COUNT(1) FROM parsing_sensor pps WHERE  psl.source=pps.source)
           WHEN psl.type='fitting' THEN (SELECT COUNT(1) FROM parsing_fitting pf WHERE  psl.source=pf.source)
        END as cnt
FROM parsing_source_list psl
ORDER BY psl.type DESC");

?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th></th>
        <th>Название файла</th>
        <th>Тип товара</th>
        <th>Источник</th>
        <th>Скачивание</th>
        <th>Преобразование</th>
        <th>Товары</th>
        <th>Процент</th>
    </tr>

    </thead>
    <tbody>
    <?php
    $total = 0;
    $cur_type = $res[0]->type;
    ?>

    <?php foreach ($res as $key=>$row): ?>
        <?php if ($cur_type != $row->type): ?>
            <?php $cur_type= $row->type?>
            <tr>
                <td colspan="6"></td>
                <td><?= $total ?></td>
                <td></td>
            </tr>
            <?php $total = 0; ?>
        <?php endif; ?>
        <?php
        $total += $row->cnt;
        ?>
        <tr class="<?= $row->get_type == 1 ? 'table-warning' : '' ?>">
            <td><?= $row->id ?></td>
            <td><?= $row->file_name ?></td>
            <td><?= $row->type ?></td>
            <td><?= $row->source ?><br/><?= $row->class_path ?></td>
            <td><?= $row->last_dl_date ?><br/><?= $row->finish_dl ?></td>
            <td><?= $row->start_parse ?><br/><?= $row->end_parse ?></td>
            <td><?= $row->cnt ?><br/><?= $row->total_goods ?></td>
            <td><input name="percent" type="number" row_id="<?=$row->id?>" value="<?= $row->percent ?>"></td>
        </tr>


        <?php if (!isset($res[$key+1])): ?>
            <?php $cur_type= $row->type?>
            <tr>
                <td colspan="6"></td>
                <td><?= $total ?></td>
                <td></td>
            </tr>
            <?php $total = 0; ?>
        <?php endif; ?>

    <?php endforeach; ?>
    </tbody>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("[name=percent]").on("focusout",function(){
            var id = $(this).attr("row_id")
            $.post("set_percent.php",{'id':id,percent:$(this).val()},function(result){

            },"json")
        })
    </script>

</table>
</body>
</html>
