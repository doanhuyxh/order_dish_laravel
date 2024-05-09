@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

    <div class="form flex-column justify-content-center text-center">

        <div class="btn-group m-auto my-3" role="group">
            <button type="button" class="btn btn-outline-primary" :class="{ 'active': step == 1 }">Step 1</button>
            <button type="button" class="btn btn-outline-primary" :class="{ 'active': step == 2 }">Step 2</button>
            <button type="button" class="btn btn-outline-primary" :class="{ 'active': step == 3 }">Step 3</button>
            <button type="button" class="btn btn-outline-primary" :class="{ 'active': step == 4 }">Review</button>
        </div>


        <div class="form-group w-50 m-auto" v-if="step==1">
            <div class="form-group my-2">
                <label class="form-label">Please Select a meal</label>
                <select class="form-select" v-model="dataSubmit.meal">
                    <option selected disabled></option>
                    <option v-for="(item) in meals" :value="item" :key="item.id" v-text="item.name"></option>

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
                <select class="form-select" v-model="dataSubmit.restaurant">
                    <option selected disabled></option>
                    <option v-for="(item) in restaurants" :value="item" :key="item.id" v-text="item.name"></option>
                </select>
            </div>
        </div>

        <div class="form-group m-auto" v-if="step==3">

            <div class="form-group d-flex justify-content-center gap-3" v-for="(_item, index) in dataSubmit.dish"
                 :key="index">
                <div class="form-group my-2 ">
                    <label class="form-label">Please Select a Dish</label>
                    <select class="form-select" v-model="dataSubmit.dish[index].dish">
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
                <span class="btn" v-on:click="addDish()">+</span>
            </div>
        </div>

        <div class="form-group m-auto" v-if="step==4">

            <div class="container w-50">
                <div class="row p-3">
                    <div class="col-6">Meal</div>
                    <div class="col-6">
                        <span v-text="dataSubmit.meal.name"></span>
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
                        <span v-text="dataSubmit.restaurant.name"></span>
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
            el: ".form",
            data: {
                step: 1,
                meals: @json($meals),
                restaurants: @json($restaurants),
                dish:@json($dish),
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
                initData() {
                },
                addDish() {
                    let obj = {
                        dish: null,
                        number: 1
                    }
                    this.dataSubmit.dish.push(obj)
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
                            if (this.dataSubmit.numberPerson < 1) {
                                check = true;
                                alert("Enter people")
                            }
                            break;
                        case 2:

                            break;
                        case 3:

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
                    }
                }
            }
        })

    </script>

@endsection
