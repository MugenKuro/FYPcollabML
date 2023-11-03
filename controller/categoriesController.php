<?php

// Include file
require_once dirname(__FILE__) . '\..\entity\categories.php';

class viewAllCategories
{
    public function viewAllCategories()
    {
        //Create instance of User
        $category = new categories();

        //Register User
        $data = json_decode($category->viewAllCategories());

        return json_encode($data);
    }
}

?>