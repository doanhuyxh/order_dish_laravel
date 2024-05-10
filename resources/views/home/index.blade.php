@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

    <div class="form flex-column justify-content-center text-center" id="formDish">

        <div class="btn-group m-auto my-3" role="group">
            <button type="button" class="btn btn-outline-primary" :class="{ 'active': step == 1 }">Step 1</button>
            <button type="button" class="btn btn-outline-primary" :class="{ 'active': step == 2 }">Step 2</button>
            <button type="button" class="btn btn-outline-primary" :class="{ 'active': step == 3 }">Step 3</button>
            <button type="button" class="btn btn-outline-primary" :class="{ 'active': step == 4 }">Review</button>
        </div>


        <div class="form-group w-50 m-auto" v-if="step==1">
            <div class="form-group my-2">

                <label class="form-label">Please Select a meal</label>
                <select class="form-select" v-model="dataSubmit.meal" >
                    <option selected disabled></option>
                    <option v-for="(item) in meals" :value="item" :key="item" v-text="item"></option>

                </select>
            </div>
            <div class="form-group m-auto my-2">
                <label for="people" class="form-label">Please Enter number of people</label>
                <input class="form-control" v-model="dataSubmit.numberPerson" id="people"/>
            </div>

        </div>

        <div class="form-group w-50 m-auto" v-if="step==2">
            <div class="form-group my-2">
                <label class="form-label">Please Select a Restaurant</label>
                <select class="form-select" v-model="dataSubmit.restaurant" >
                    <option selected disabled></option>
                    <option v-for="(item) in restaurants" :value="item" :key="item" v-text="item"></option>
                </select>
            </div>
        </div>

        <div class="form-group m-auto" v-if="step==3">

            <div class="form-group d-flex justify-content-center gap-3" v-for="(_item, index) in dataSubmit.dish"
                 :key="index">
                <div class="form-group my-2 ">
                    <label class="form-label">Please Select a Dish</label>
                    <select class="form-select" v-model="dataSubmit.dish[index].dish" v-on:change="filteredDishesAdd">
                        <option selected></option>
                        <option v-for="(item) in dish" :value="item" :key="item.id" v-text="item.name"></option>
                    </select>

                </div>

                <div class="form-group my-2">
                    <label class="form-label">Please Enter no. of servings</label>
                    <input class="form-control" v-model="dataSubmit.dish[index].number" type="number">
                </div>

            </div>
            <div class="d-flex w-25 m-auto">
                <span class="btn btn-success" v-on:click="addDish()">+</span>
            </div>
        </div>

        <div class="form-group m-auto" v-if="step==4">

            <div class="container w-50">
                <div class="row p-3">
                    <div class="col-6">Meal</div>
                    <div class="col-6">
                        <span v-text="dataSubmit.meal"></span>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-6">No of People</div>
                    <div class="col-6">
                        <span v-text="dataSubmit.numberPerson"></span>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-6">Restaurant</div>
                    <div class="col-6">
                        <span v-text="dataSubmit.restaurant"></span>
                    </div>
                </div>
                <div class="row p-3">
                    <div class="col-6">Dishs</div>
                    <div class="col-6 border border-bottom-dark">
                        <div class="d-flex justify-content-start" v-for="(item, index) in dataSubmit.dish" :key="index">
                            <span class="" v-text="item.dish.name"></span>
                            <span class="px-2">-</span>
                            <span class="" v-text="item.number"></span>
                        </div>
                    </div>
                </div>

            </div>


        </div>


        <div class="container mt-5 d-flex justify-content-between">
            <button class="btn btn-outline-primary float-left" v-show="step>1" v-on:click="pre">Previous</button>
            <button class="btn btn-outline-primary float-end" v-show="step<4" v-on:click="next">Next</button>
            <button class="btn btn-outline-primary float-end" v-show="step==4" v-on:click="submit">Submit</button>
        </div>
    </div>


    <script>

        var app_vue = new Vue({
            el: "#formDish",
            data: {
                step: 1,
                meals: [],
                restaurants:[] ,
                dish:[],
                dishMain: [],
                dataSubmit: {
                    meal: null,
                    restaurant: null,
                    dish: [],
                    numberPerson: 1
                }
            },


            mounted() {
                this.initData();
            },
            methods: {
                filteredDishesMeal() {
                    this.dish = [...this.dishMain];
                    if (this.dataSubmit.meal) {
                        let filteredByRestaurant = this.dish.filter(dishes => dishes.availableMeals.includes(this.dataSubmit.meal));
                        this.restaurants = [...new Set(filteredByRestaurant.map(dish => dish.restaurant))];

                        return filteredByRestaurant;
                    }
                    else {
                        return this.dish;
                    }
                },
                filteredDishesMealRestaurant(){
                    this.dish = [...this.dishMain];

                    if (this.dataSubmit.restaurant) {
                        let filteredByRestaurant = this.dish.filter(dish => dish.restaurant === this.dataSubmit.restaurant);
                        return filteredByRestaurant;

                    }
                    else {

                        return this.dish;
                    }
                },
                filteredAll(){
                    this.dish = [...this.dishMain];

                    if (this.dataSubmit.meal && this.dataSubmit.restaurant) {
                        return this.dish.filter(dishes => {
                            return dishes.availableMeals.includes(this.dataSubmit.meal) && dishes.restaurant === this.dataSubmit.restaurant;
                        });

                    }
                    else {
                        return this.dish;
                    }
                },
                filteredDishesAdd() {
                    let newDishName = this.dataSubmit.dish[this.dataSubmit.dish.length - 1].dish.name;

                    if (this.dataSubmit.dish.some(item => item.dish.name === newDishName && item !== this.dataSubmit.dish[this.dataSubmit.dish.length - 1])) {
                        alert('This dish has already been selected');
                        this.dataSubmit.dish.pop();
                    }

                },
                initData() {
                    fetch('/dishes.json')
                        .then(response => response.json())
                        .then(data => {
                            this.dish = data.dishes;
                            this.dishMain = data.dishes;
                            this.meals = [...new Set(this.dish.flatMap(dish => dish.availableMeals))];
                            console.log(this.dish);

                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                },
                addDish() {

                    let obj = {
                        dish: null,
                        number: 1
                    }

                    this.dataSubmit.dish.push(obj);
                    console.log(this.dataSubmit.dish);

                },
                submit() {

                    let currentThis = this;
                    let dish = []
                    currentThis.dataSubmit.dish.forEach(item=>{
                        dish.push({
                            "name":item.dish.name,
                            "number":item.number
                        })
                    })

                    fetch("/admin/saveData",{
                        method:"POST",
                        headers:{
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: new Date().getTime(),
                            "restaurant": currentThis.dataSubmit.restaurant.name,
                            "meal": currentThis.dataSubmit.meal.name,
                            "dish":dish,
                            "_token": "{{ csrf_token() }}"
                        })
                    }).then(res=>{
                        Swal.fire({
                            title: "Success!",
                            icon: "success"
                        }).then(res=>{
                            window.location.reload()
                        });
                    })
                },
                next() {
                    let check = false;
                    switch (this.step) {
                        case 1:
                            if (!this.dataSubmit.meal) {
                                alert('Please Select a meal');
                                return;
                            }
                            if (this.dataSubmit.numberPerson < 1 || this.dataSubmit.numberPerson > 10) {
                                alert('Please enter a minimum number of 1 person and a maximum of 10 people');
                                return;
                            }
                            this.dish = this.filteredDishesMeal();
                            console.log(this.dish)
                            break;
                        case 2:
                            if (!this.dataSubmit.restaurant) {
                                alert('Please Select a restaurant');
                                return;
                            }
                            this.dish = this.filteredDishesMealRestaurant();
                            console.log(this.dish)

                            break;
                        case 3:
                            this.dish = this.filteredAll();
                            let totalDishes = this.dataSubmit.dish.reduce((total, item) => total + item.number, 0);

                            if (totalDishes < this.dataSubmit.numberPerson) {
                                alert('Total number of dishes must be greater than or equal to the number of persons');
                                return;
                            }

                            if (totalDishes > 10) {
                                alert('Total number of dishes cannot exceed 10');
                                return;
                            }
                            console.log(this.dish)
                            break;

                    }

                    if (check) {
                        return
                    }

                    if (this.step < 4) {
                        this.step += 1;
                    }
                },
                pre() {
                    if (this.step > 1) {
                        this.step -= 1;
                        if(this.step == 1){
                            this.dish = this.filteredDishesMeal();
                        }else if(this.step == 2){
                            this.dish = this.filteredDishesMealRestaurant();
                            this.dataSubmit.dish = [];

                        }
                    }
                }
            }
        })

    </script>

@endsection
