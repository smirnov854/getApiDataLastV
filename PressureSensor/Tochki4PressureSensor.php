<?php


class Tochki4PressureSensor extends PressureSensor
{
    public function read_from_json() {
        $file_handle = fopen($this->file_name, "r");
        $file_content = fread($file_handle, filesize($this->file_name));
        $json = json_decode($file_content);

        foreach ($json->pressure_sensor as $sensor) {

            $price = !empty($sensor->price) ? $sensor->price : (
            !empty($sensor->price_sk4) ? $sensor->price_sk4 :(
            !empty($sensor->price_sk3) ? $sensor->price_sk3 :
                (
                !empty($sensor->price_yamka) ? $sensor->price_yamka :(
                !empty($sensor->price_mkrs) ? $sensor->price_mkrs : 0
                )
                )
            )
            );
            $amount =
                !empty($sensor->rest_sk4) ? $sensor->rest_sk4 :(
                !empty($sensor->rest_sk3) ? $sensor->rest_sk3 :
                    (
                    !empty($sensor->rest_yamka) ? $sensor->rest_yamka :(
                    !empty($sensor->rest_mkrs) ? $sensor->rest_mkrs : 0
                    )
                    )
                );
            $this->database_fields['source'] = __CLASS__;
            $this->database_fields['cae'] = $sensor->cae;
            $this->database_fields["name"] = $sensor->name;
            $this->database_fields["brand"] = $sensor->brand;
            $this->database_fields["price"] = $price;
            $this->database_fields["price_retail"] = $sensor->price_yamka_rozn;
            $this->database_fields["photo_url"] = $sensor->img_big_pish;
            $this->database_fields['amount'] = $amount;

            $this->add_database();
            $this->clear_value();
        }
        fclose($file_handle);
    }
}