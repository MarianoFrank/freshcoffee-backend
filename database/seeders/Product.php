<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class Product extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $products = [
            array(
                'name' =>  "Caramel Coffee with Chocolate",
                'price' => 59.9,
                'image' => "cafe_01",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Iced Coffee with Chocolate Large",
                'price' => 49.9,
                'image' => "cafe_02",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Iced Latte with Chocolate Large",
                'price' => 54.9,
                'image' => "cafe_03",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Iced Latte with Chocolate Large",
                'price' => 54.9,
                'image' => "cafe_04",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Iced Milkshake with Chocolate Large",
                'price' => 54.9,
                'image' => "cafe_05",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Hot Mocha Coffee Small",
                'price' => 39.9,
                'image' => "cafe_06",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Hot Mocha Coffee Large with Chocolate",
                'price' => 59.9,
                'image' => "cafe_07",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Hot Cappuccino Coffee Large",
                'price' => 59.9,
                'image' => "cafe_08",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Hot Mocha Coffee Medium",
                'price' => 49.9,
                'image' => "cafe_09",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Iced Mocha Coffee with Caramel Medium",
                'price' => 49.9,
                'image' => "cafe_10",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Iced Mocha Coffee with Chocolate Medium",
                'price' => 49.9,
                'image' => "cafe_11",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Espresso Coffee",
                'price' => 29.9,
                'image' => "cafe_12",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Large Cappuccino Coffee with Caramel",
                'price' => 59.9,
                'image' => "cafe_13",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Large Caramel Coffee",
                'price' => 59.9,
                'image' => "cafe_14",
                'category_id' => 1,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            
            array(
                'name' =>  "Pack of 3 Chocolate Donuts",
                'price' => 39.9,
                'image' => "donas_01",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Pack of 3 Glazed Donuts",
                'price' => 39.9,
                'image' => "donas_02",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Strawberry Donut",
                'price' => 19.9,
                'image' => "donas_03",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Donut with Chocolate Cookie",
                'price' => 19.9,
                'image' => "donas_04",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Glazed Donut with Strawberry Sprinkles",
                'price' => 19.9,
                'image' => "donas_05",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Glazed Donut with Chocolate",
                'price' => 19.9,
                'image' => "donas_06",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Chocolate Donut with MORE Chocolate",
                'price' => 19.9,
                'image' => "donas_07",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Pack of 3 Chocolate Donuts",
                'price' => 39.9,
                'image' => "donas_08",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Pack of 3 Vanilla and Chocolate Donuts",
                'price' => 39.9,
                'image' => "donas_09",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Pack of 6 Donuts",
                'price' => 69.9,
                'image' => "donas_10",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Pack of 3 Mixed Donuts",
                'price' => 39.9,
                'image' => "donas_11",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Plain Donut with Chocolate",
                'price' => 19.9,
                'image' => "donas_12",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Pack of 3 Chocolate Donuts with Sprinkles",
                'price' => 39.9,
                'image' => "donas_13",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array(
                'name' =>  "Chocolate and Coconut Donut",
                'price' => 19.9,
                'image' => "donas_14",
                'category_id' => 4,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),

            
            array( 
                'name' =>  "Chocolate Chip Cookie Pack",
                'price' => 29.9,
                'image' => "galletas_01",
                'category_id' => 6,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Chocolate and Oat Cookie Pack",
                'price' => 39.9,
                'image' => "galletas_02",
                'category_id' => 6,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Vanilla Muffins Pack",
                'price' => 39.9,
                'image' => "galletas_03",
                'category_id' => 6,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Pack of 4 Oat Cookies",
                'price' => 24.9,
                'image' => "galletas_04",
                'category_id' => 6,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Assorted Butter Cookies",
                'price' => 39.9,
                'image' => "galletas_05",
                'category_id' => 6,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Fruit-Flavored Cookies",
                'price' => 39.9,
                'image' => "galletas_06",
                'category_id' => 6,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            
            array( 
                'name' =>  "Simple Burger",
                'price' => 59.9,
                'image' => "hamburguesas_01",
                'category_id' => 2,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Chicken Burger",
                'price' => 59.9,
                'image' => "hamburguesas_02",
                'category_id' => 2,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Chicken and Chili Burger",
                'price' => 59.9,
                'image' => "hamburguesas_03",
                'category_id' => 2,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Cheese and Pickles Burger",
                'price' => 59.9,
                'image' => "hamburguesas_04",
                'category_id' => 2,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Quarter Pounder Burger",
                'price' => 59.9,
                'image' => "hamburguesas_05",
                'category_id' => 2,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Double Cheese Burger",
                'price' => 69.9,
                'image' => "hamburguesas_06",
                'category_id' => 2,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Special Hot Dog",
                'price' => 49.9,
                'image' => "hamburguesas_07",
                'category_id' => 2,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Pack of 2 Hot Dogs",
                'price' => 69.9,
                'image' => "hamburguesas_08",
                'category_id' => 2,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            
            array( 
                'name' =>  "4 Slices of Cheesecake",
                'price' => 69.9,
                'image' => "pastel_01",
                'category_id' => 5,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Special Waffle",
                'price' => 49.9,
                'image' => "pastel_02",
                'category_id' => 5,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "House Croissants",
                'price' => 39.9,
                'image' => "pastel_03",
                'category_id' => 5,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Cheesecake",
                'price' => 19.9,
                'image' => "pastel_04",
                'category_id' => 5,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Chocolate Cake",
                'price' => 29.9,
                'image' => "pastel_05",
                'category_id' => 5,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Slice of Chocolate Cake",
                'price' => 29.9,
                'image' => "pastel_06",
                'category_id' => 5,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            
            array( 
                'name' =>  "Spicy Pizza with Double Cheese",
                'price' => 69.9,
                'image' => "pizzas_01",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Ham and Cheese Pizza",
                'price' => 69.9,
                'image' => "pizzas_02",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Double Cheese Pizza",
                'price' => 69.9,
                'image' => "pizzas_03",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "House Special Pizza",
                'price' => 69.9,
                'image' => "pizzas_04",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Chorizo Pizza",
                'price' => 69.9,
                'image' => "pizzas_05",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Hawaiian Pizza",
                'price' => 69.9,
                'image' => "pizzas_06",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Bacon Pizza",
                'price' => 69.9,
                'image' => "pizzas_07",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Vegetables and Cheese Pizza",
                'price' => 69.9,
                'image' => "pizzas_08",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Pepperoni and Cheese Pizza",
                'price' => 69.9,
                'image' => "pizzas_09",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Olives and Cheese Pizza",
                'price' => 69.9,
                'image' => "pizzas_10",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            array( 
                'name' =>  "Cheese, Ham, and Mushrooms Pizza",
                'price' => 69.9,
                'image' => "pizzas_11",
                'category_id' => 3,
                'available' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            
        ];

        DB::table('products')->insert($products);
    }
}