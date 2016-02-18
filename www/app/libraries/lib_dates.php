<?php

class dateConverter{
public static function sqlToDate($date=null) {

        $time = DateTime::createFromFormat('Y-m-d', $date);
        if (!$time) {
            return false;
        }
        return $time->format('j.m.Y');
    }

    public static function dateToSql($date) {

        $time = DateTime::createFromFormat('j.m.Y', $date);
        if (!$time) {
            return false;
        }
        return $time->format('Y-m-d');

        //return  date("j.m.Y", $task['taskdate']);
    }
    
    public static function sqlToShortDate($date=null) {

        $time = DateTime::createFromFormat('Y-m-d', $date);
        if (!$time) {
            return false;
        }
        return $time->format('j.m');
    }
}