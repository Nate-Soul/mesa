<?php

class Products extends Connect{


    public function create()
    {
        return null;
    }
    
    public function read()
    {
        //get only products that are in stock and arrange desc order by date created 
        return array(
            0 => array(
                "id"   => 1,
                "name" => "Electric Shoes",
                "slug" => Helper::slugify("Electric Shoes"),
                "image" => "shoe-7.png",
                "price" => 106.98,
                "is"    => "feature",
                "in_stock" => 1,
                "category" => "Shoes",
                "available_qty" => 3,
            ),
            1 => array(
                "id"   => 2,
                "name" => "Portable School Bag",
                "slug" => Helper::slugify("Portable School Bag"),
                "image" => "bagpacks-1.png",
                "price" => 45.67,
                "is"    => "feature",
                "in_stock" => 1,
                "category" => "school-bags",
                "available_qty" => 6,
            ),
            2 => array(
                "id"   => 3,
                "name" => "Easy Shirt 2022 Edition",
                "slug" => Helper::slugify("Easy Shirt 2022 Edition"),
                "image" => "shirt-8.png",
                "price" => 56.67,
                "is"    => "top_rated",
                "in_stock" => 1,
                "category" => "Clothes",
                "available_qty" => 4,
            ),
            3 => array(
                "id"   => 4,
                "name" => "Coral Black T-shirt",
                "slug" => Helper::slugify("Coral Black T-shirt"),
                "image" => "black-tshirt.png",
                "price" => 40.20,
                "is"    => "on_sale",
                "in_stock" => 1,
                "category" => "Clothes",
                "available_qty" => 8,
            ),
        );
    }

    public function countProduct(){
        return count($this->read());
    }

    public function update(){
        return null;
    }

    public function delete($id){
        return null;
    }

    public function getProduct($id){
        if(!empty($id)){
            $products = $this->read();
            $product  = Helper::ArraySearch($products, "id", $id);
            if(!empty($product)){
                $product  = array_shift($product);
                return $product;
            }
        }
    }

    public function getProductBySlug($slug){
        if(!empty($slug)){
            $products = $this->read();
            $product  = Helper::ArraySearch($products, "slug", $slug);
            if(!empty($product)){
                $product  = array_shift($product);
                return $product;
            }
        }
    }

    
    public function getProductsByCategory($category){
        if(!empty($category)){
            $products = $this->read();
            $product  = Helper::ArraySearch($products, "category", $category);
            if(!empty($product)){
                return $product;
            }
        }
    }
    
    public function getRelatedProducts($name){
        if(!empty($name)){
            $products = $this->read();
            $product  = Helper::ArraySearch($products, "name", $name);
            if(!empty($product)){
                return $product;
            }
        }
    }

    public function search(){
        return false;
    }
}