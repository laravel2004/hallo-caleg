<?php

namespace App\Service;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Facade as Indonesia;

class IndonesiaAreaService
{
    public static function getArea($type, $id)
    {
        $result = null;
        switch (strtolower($type)) {
            case 'province':
                $result = Indonesia::findProvince($id)->name;
                break;
            case 'city':
                $result = Indonesia::findCity($id)->name;
                break;
            case 'district':
                $result = Indonesia::findDistrict($id)->name;
                break;
            case 'village':
                $result = Indonesia::findVillage($id)->name;
                break;
            default:
                $result = null;
                break;
        }
        return $result;
    }

    public static function findByName($type, $name) {
        $result = null;
        switch (strtolower($type)) {
            case 'province':
                $prefix = config('laravolt.indonesia.table_prefix').'provinces';
                break;
            case 'city':
                $prefix = config('laravolt.indonesia.table_prefix').'cities';
                break;
            case 'district':
                $prefix = config('laravolt.indonesia.table_prefix').'districts';
                break;
            case 'village':
                $prefix = config('laravolt.indonesia.table_prefix').'villages';
                break;
            default:
                $prefix = null;
                break;
        }
        return ($prefix) ? DB::table($prefix)->where('name', $name)->first()->id : null;
    }
}
