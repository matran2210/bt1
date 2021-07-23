<?php
namespace App\Traits;
use Illuminate\Support\Str;
trait Filterable
{

    public function scopeFilter($query,$param)
    {
        foreach ((array)$param as $field => $value) {
            $arrField = explode("--",$field);

            $method = 'filter' . Str::studly($arrField[0]);

            if ($value === '') {
                continue;
            }
            if ($value ==null) {
                continue;
            }
            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
                continue;
            }
            if (empty($this->filterable) || !is_array($this->filterable)) {
                continue;
            }

            //truy van =
            if(sizeof($arrField)<=1)
            {
                if (in_array($arrField[0], $this->filterable)) {
                    $query->where($this->table . '.' . $arrField[0], $value);
                    continue;
                }
                if (key_exists($arrField[0], $this->filterable)) {
                    $query->where($this->table . '.' . $this->filterable[$arrField[0]], $value);
                    continue;
                }
            }
            //truy van dac biet
            else if(sizeof($arrField)>1) {

                if ($arrField[1] === 'like') {
                    $query->where($this->table . '.' . $arrField[0], 'LIKE', '%' . $value . '%');
                    continue;
                }
                if ($arrField[1] === 'date') {
                    $query->whereDate($this->table . '.' . $arrField[0], $value);
                    continue;
                }


            }

        }

        return $query;
    }
}