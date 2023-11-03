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

class viewCatById {
    public function viewCategoryById($category_id)
    {
        $category = new categories();
        $data = json_decode($category->viewCategoryById($category_id));

        return json_encode($data);
    }
}

?>