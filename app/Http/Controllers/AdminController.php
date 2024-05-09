<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Meals;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function Index()
    {
        return view('admin.index');
    }

    public function Restaurant()
    {
        return view('admin.restaurant');
    }

    public function getDataTableDataRestaurant(Request $request)
    {
        try {
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');

            $sortColumn = $request->input('columns[' . $request->input('order[0][column]') . '][name]');
            $sortColumnAscDesc = $request->input('order[0][dir]');
            $searchValue = $request->input('search[value]');

            $pageSize = $length != null ? (int)$length : 0;
            $skip = $start != null ? (int)$start : 0;
            $resultTotal = 0;

            $gridItems = Restaurant::query();

            //Sorting
            if (!empty($sortColumn) && !empty($sortColumnAscDesc)) {
                $gridItems->orderBy($sortColumn, $sortColumnAscDesc);
            }

            //Search
            if (!empty($searchValue)) {
                $searchValue = strtolower($searchValue);
                $gridItems->where(function ($query) use ($searchValue) {
                    $query->where('id', 'like', '%' . $searchValue . '%')
                        ->orWhere('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                        ->orWhere('update_at', 'like', '%' . $searchValue . '%');
                });
            }

            $resultTotal = $gridItems->count();
            $result = $gridItems->skip($skip)->take($pageSize)->get();

            return response()->json([
                'draw' => $draw,
                'recordsFiltered' => $resultTotal,
                'recordsTotal' => $resultTotal,
                'data' => $result
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'draw' => [],
                'recordsFiltered' => 0,
                'recordsTotal' => 0,
                'data' => []
            ]);
        }
    }

    public function AddEditRestaurant($id)
    {

        $restaurant = Restaurant::find($id);
        if (!$restaurant) {
            $restaurant = new Restaurant();
            $restaurant->id = 0;
            $restaurant->name = "";
        }

        return view("admin.addEditRestaurant", ['restaurant' => $restaurant]);
    }

    public function SaveRestaurant(Request $request)
    {
        try {
            $id = $request->input('id');
            $data = $request->except('_token');
            if ($id) {
                Restaurant::updateOrCreate(['id' => $id], $data);
            } else {
                $restaurant = new Restaurant();
                $restaurant->name = $data['name'];
                $restaurant->save();
            }
            return response()->json([
                'code' => 200,
                'message' => ''
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $request
            ]);
        }
    }

    public function DeleteRestaurant($id)
    {
        $deleted = Restaurant::destroy($id);
        return response()->json([
            'code' => 200,
            'message' => $deleted
        ]);
    }

    public function Meal()
    {
        return view('admin.meal');
    }

    public function getDataTableDataMeal(Request $request)
    {
        try {
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');

            $sortColumn = $request->input('columns[' . $request->input('order[0][column]') . '][name]');
            $sortColumnAscDesc = $request->input('order[0][dir]');
            $searchValue = $request->input('search[value]');

            $pageSize = $length != null ? (int)$length : 0;
            $skip = $start != null ? (int)$start : 0;
            $resultTotal = 0;

            $gridItems = Meals::query();

            //Sorting
            if (!empty($sortColumn) && !empty($sortColumnAscDesc)) {
                $gridItems->orderBy($sortColumn, $sortColumnAscDesc);
            }

            //Search
            if (!empty($searchValue)) {
                $searchValue = strtolower($searchValue);
                $gridItems->where(function ($query) use ($searchValue) {
                    $query->where('id', 'like', '%' . $searchValue . '%')
                        ->orWhere('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                        ->orWhere('update_at', 'like', '%' . $searchValue . '%');
                });
            }

            $resultTotal = $gridItems->count();
            $result = $gridItems->skip($skip)->take($pageSize)->get();

            return response()->json([
                'draw' => $draw,
                'recordsFiltered' => $resultTotal,
                'recordsTotal' => $resultTotal,
                'data' => $result
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'draw' => [],
                'recordsFiltered' => 0,
                'recordsTotal' => 0,
                'data' => []
            ]);
        }
    }

    public function AddEditMeal($id)
    {

        $meal = Meals::find($id);
        if (!$meal) {
            $meal = new Meals();
            $meal->id = 0;
            $meal->name = "";
        }

        return view("admin.addEditMeal", ['meal' => $meal]);
    }

    public function SaveMeal(Request $request)
    {
        try {
            $id = $request->input('id');
            $data = $request->except('_token');
            if ($id) {
                Meals::updateOrCreate(['id' => $id], $data);
            } else {
                $meal = new Meals();
                $meal->name = $data['name'];
                $meal->save();
            }
            return response()->json([
                'code' => 200,
                'message' => ''
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $request
            ]);
        }
    }

    public function DeleteMeal($id)
    {
        $deleted = Meals::destroy($id);
        return response()->json([
            'code' => 200,
            'message' => $deleted
        ]);
    }
public function Dish()
    {
        return view('admin.dish');
    }

    public function getDataTableDataDish(Request $request)
    {
        try {
            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');

            $sortColumn = $request->input('columns[' . $request->input('order[0][column]') . '][name]');
            $sortColumnAscDesc = $request->input('order[0][dir]');
            $searchValue = $request->input('search[value]');

            $pageSize = $length != null ? (int)$length : 0;
            $skip = $start != null ? (int)$start : 0;
            $resultTotal = 0;

            $gridItems = Dish::query();

            //Sorting
            if (!empty($sortColumn) && !empty($sortColumnAscDesc)) {
                $gridItems->orderBy($sortColumn, $sortColumnAscDesc);
            }

            //Search
            if (!empty($searchValue)) {
                $searchValue = strtolower($searchValue);
                $gridItems->where(function ($query) use ($searchValue) {
                    $query->where('id', 'like', '%' . $searchValue . '%')
                        ->orWhere('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('created_at', 'like', '%' . $searchValue . '%')
                        ->orWhere('update_at', 'like', '%' . $searchValue . '%');
                });
            }

            $resultTotal = $gridItems->count();
            $result = $gridItems->skip($skip)->take($pageSize)->get();

            return response()->json([
                'draw' => $draw,
                'recordsFiltered' => $resultTotal,
                'recordsTotal' => $resultTotal,
                'data' => $result
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'draw' => [],
                'recordsFiltered' => 0,
                'recordsTotal' => 0,
                'data' => []
            ]);
        }
    }

    public function AddEditDish($id)
    {

        $dish = Dish::find($id);
        if (!$dish) {
            $dish = new Dish();
            $dish->id = 0;
            $dish->name = "";
        }

        return view("admin.addEditDish", ['dish' => $dish]);
    }

    public function SaveDish(Request $request)
    {
        try {
            $id = $request->input('id');
            $data = $request->except('_token');
            if ($id) {
                Dish::updateOrCreate(['id' => $id], $data);
            } else {
                $dish = new Dish();
                $dish->name = $data['name'];
                $dish->save();
            }
            return response()->json([
                'code' => 200,
                'message' => ''
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $request
            ]);
        }
    }

    public function DeleteDish($id)
    {
        $deleted = Dish::destroy($id);
        return response()->json([
            'code' => 200,
            'message' => $deleted
        ]);
    }

    public  function  SaveData(Request $request)
    {
        try {
            $newData = [
                'id' => $request->input('id'),
                'restaurant' => $request->input('restaurant'),
                'meal' => $request->input('meal'),
                'dish' => $request->input('dish')
            ];

            $filePath = 'data.json';
            $existingData = Storage::disk('local')->get($filePath);
            $existingArray = json_decode($existingData, true);
            $existingArray[] = $newData;

            $jsonData = json_encode($existingArray);

            Storage::disk('local')->put($filePath, $jsonData);

            return response()->json([
                'code' => 200,
                'message' => $newData
            ]);

        }catch (Exception $exception){
            return response()->json([
                'code' => 500,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function DataDish(){

        $filePath = 'data.json';
        $existingData = Storage::disk('local')->get($filePath);
        $existingArray = json_decode($existingData, true);

        return view('admin.dataDish', ['data' => $existingArray]);
    }

}
