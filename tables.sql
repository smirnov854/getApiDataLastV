DROP TABLE IF EXISTS tyres_import_prepare;
CREATE TABLE tyres_import_prepare
(
    index index1(hash)
)
SELECT
    md5(
            CONCAT(
                    lower(v.vendor_name),
                    ms.size_width,
                    ms.size_profile,
                    ms.size_radius,
                    ms.speed_index
                )
        ) as hash,
    lower(v.vendor_name) as vendor_name,
    m.model_name,
    m.season_id,
    m.model_stud,
    ms.speed_index,
    ms.size_width,
    ms.size_profile,
    ms.size_radius,
    ms.rof_flag,
    '' as source,
    0 as price,
    0 as ammount
FROM model_size ms
         LEFT JOIN model m on ms.model_id = m.model_id
         LEFT JOIN vendor v on m.vendor_id = v.vendor_id;

DROP TABLE IF EXISTS wheels_import_prepare;
CREATE TABLE wheels_import_prepare
(
    index index1(hash)
)
SELECT
    md5(
            CONCAT(
                    lower(v.vendor_name),
                    ms.pcd_first,
                    ms.pcd_second,
                    ms.diameter,
                    ms.et
                )
        ) as hash,
    lower(v.vendor_name) as vendor_name,
    m.model_name,
    ms.width,
    ms.pcd_first,
    ms.pcd_second,
    ms.diameter,
    ms.dia,
    ms.et,
    '' as source,
    0 as price,
    0 as ammount
FROM wheel_model_size ms
         LEFT JOIN wheel_model m on ms.model_id = m.model_id
         LEFT JOIN wheel_vendor v on m.vendor_id = v.vendor_id;