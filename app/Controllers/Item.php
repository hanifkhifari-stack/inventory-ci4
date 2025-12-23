<?php

namespace App\Controllers;

class Item extends BaseController
{
    public function detail($id = null)
    {
        echo "Detail item: " . $id;
    }
}
