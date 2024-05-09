<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Meals;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController
{
    public function index() {
        $meals = Meals::all();
        $restaurants = Restaurant::all();
        $dish = Dish::all();
        return view('home.index', compact('meals', 'restaurants', 'dish'));
    }
}
