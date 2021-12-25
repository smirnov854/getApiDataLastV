<?php
require_once "Common/Database_worker.php";

$db = new Database_worker();


@$db->do_sql("DROP TABLE IF EXISTS result_tyres");

$sql = "
CREATE TABLE result_tyres AS
SELECT DISTINCT pt.id,
       pt.source, pt.name,
       pt.type, pt.model as model,
       pt.diameter as diameter,
       pt.width as width,
       pt.profile as profile,
       pt.load_index,
       pt.speed_index,
       COALESCE(t1.model_stud,pt.pins) as  model_stud, COALESCE (t1.rof_flag, pt.runflat) as rof_flag, 
       ROUND(pt.price_edited, 2) as price_edited,
       pt.photo_url, 
      COALESCE(pt.season, t1.season_id) as  season, 
       COALESCE(pt.brand,t1.vendor_name)  as brand,
       pt.cae, pt.amount 
FROM parsing_tyres pt
LEFT JOIN tyres_import_prepare t1 ON pt.hash=t1.hash
WHERE pt.amount>0 and pt.price_edited>0
";
@$db->do_sql($sql);
@$db->do_sql("DROP TABLE IF EXISTS result_wheels");
$sql = "
CREATE TABLE result_wheels AS
SELECT  pw.id, pw.source, pw.name,
        pw.model as model,
        pw.type,
        pw.diameter,
        pw.color,
        pw.pn as pcd_first, pw.pcd,
        pw.et,
        pw.photo_url, pw.brand as brand,
        pw.width,
        ROUND(pw.price_edited,2) as price_edited,pw.cae,pw.amount, pw.dia
FROM parsing_wheels pw
WHERE pw.amount>0 and pw.price_edited>0;
";
@$db->do_sql($sql);