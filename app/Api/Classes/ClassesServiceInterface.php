<?php

namespace App\Api\Classes;

interface ClassesServiceInterface
{
    public function listClasses($page = 1, $limit = 10);

    public function getClass($id);

    public function insertClass($name, $start_date, $end_date, $capacity);

    public function updateClass($id, $name, $start_date, $end_date, $capacity);

    public function deleteClass($id);

    public function classBookings($id);
}
