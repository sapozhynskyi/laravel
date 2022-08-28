<?php

namespace App\Helpers\Enums;

enum OrderStatusesEnum:string
{
    case InProcess = "In Process";
    case Paid = "Paid";
    case Completed = "Completed";
    case Canceled = "Canceled";

    public function findByKey(string $key){
        return constant("self::$key");
    }
}
