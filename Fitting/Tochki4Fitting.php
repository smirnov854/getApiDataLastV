<?php


class Tochki4Fitting extends Fitting
{

    public function read_from_json() {
        $file_handle = fopen($this->file_name, "r");
        $file_content = fread($file_handle, filesize($this->file_name));
        $json = json_decode($file_content);

        foreach ($json->consumable_tire_fitting as $fitting) {

            $price = !empty($fitting->price) ? $fitting->price : (
            !empty($fitting->price_sk4) ? $fitting->price_sk4 :(
            !empty($fitting->price_sk3) ? $fitting->price_sk3 :
                (
                !empty($fitting->price_yamka) ? $fitting->price_yamka :(
                !empty($fitting->price_mkrs) ? $fitting->price_mkrs : 0
                )
                )
            )
            );
            $amount =
                !empty($fitting->rest_sk4) ? $fitting->rest_sk4 :(
                !empty($fitting->rest_sk3) ? $fitting->rest_sk3 :
                    (
                    !empty($fitting->rest_yamka) ? $fitting->rest_yamka :(
                    !empty($fitting->rest_mkrs) ? $fitting->rest_mkrs : 0
                    )
                    )
                );

            $this->database_fields['source'] = __CLASS__;
            $this->database_fields['cae'] = $fitting->cae;
            $this->database_fields['name'] = $fitting->name;
            $this->database_fields["brand"] = $fitting->brand;
            $this->database_fields["material"] = $fitting->material;
            $this->database_fields["photo_url"] = $fitting->img_big_pish;
            $this->database_fields["price"] = $price;
            $this->database_fields["amount"] = $amount;
            $this->add_database();
            $this->clear_value();
        }
        fclose($file_handle);
    }

}