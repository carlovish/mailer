<template>
    <app-header></app-header>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form method="post" @submit.prevent="submit">
                <h2 class="text-center">Create New User</h2>

                <errors-and-messages :errors="errors"></errors-and-messages>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        id="name"
                        v-model="form.name"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        v-model="form.email"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        id="password"
                        v-model="form.password"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="password_confirm">Confirm Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password_confirmation"
                        id="password_confirm"
                        v-model="form.password_confirmation"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input
                        type="text"
                        class="form-control"
                        name="phone"
                        id="phone"
                        v-model="form.phone"
                    />
                </div>

                <div class="form-group">
                    <label for="card_id">Identification Card</label>
                    <input
                        type="text"
                        class="form-control"
                        name="card_id"
                        id="card_id"
                        v-model="form.card_id"
                        required
                    />
                </div>

                <div class="form-group">
                    <label for="day_of_birth">Day of Birth</label>
                    <input
                        type="date"
                        class="form-control"
                        name="ay_of_birth"
                        id="day_of_birth"
                        v-model="form.day_of_birth"
                        required
                    />
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <select
                        name="country"
                        id="country"
                        class="form-control"
                        required
                        @change="onChangeCountry($event)"
                        v-model="form.country_id"
                    >
                        <option value="0">SELECT A COUNTRY</option>
                        <option
                            v-for="country of countries"
                            :key="country.id"
                            :value="country.id"
                        >
                            {{ country.name }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="state">State</label>
                    <select
                        name="state"
                        id="state"
                        class="form-control"
                        @change="onChangeState($event)"
                    >
                        <option value="0" disabled>SELECT A STATE</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <select name="city" id="city" class="form-control" v-model="form.city_id">
                        <option value="0" disabled>SELECT A City</option>
                    </select>
                </div>

                <input
                    type="submit"
                    class="btn btn-primary btn-block"
                    value="Register"
                />
            </form>
        </div>
    </div>
</template>

<script>
import AppHeader from "../../Partials/AppHeader";
import ErrorsAndMessages from "../../Partials/ErrorsAndMessages";

import { inject, reactive } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

const $ = require("jquery");
window.$ = $;
export default {
    name: "Register",
    components: {
        ErrorsAndMessages,
        AppHeader,
    },
    props: {
        errors: Object,
    },
    setup() {
        const form = reactive({
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            phone: null,
            card_id: null,
            country_id: null,
            city_id: null,
            day_of_birth: null,
            _token: usePage().props.value.csrf_token,
        });

        const route = inject("$route");

        const countries = usePage().props.value.countries;

        function submit() {
            Inertia.post(route("admin.store"), form);
        }

        function onChangeCountry(event) {
            $.get(`/ajax/states/${event.target.value}`, function (data) {
                if (data.count == 0) {
                    // No hay estados muestra la ciudades del pais

                     $("#state")[0].innerHTML = "<OPTION>SELECT A STATE</OPTION>";

                    showCities(0);
                } else {
                    $("#state")[0].innerHTML = data.html;
                }
            });
        }

        function onChangeState(event) {
            
            showCities(event.target.value);
        }

        function showCities(state_id) {
            $.get(
                `/ajax/cities/${form.country_id}/${state_id}`,
                function (data) {
                    $("#city")[0].innerHTML = data;
                }
            );
        }

        

        return {
            form,
            submit,
            countries,
            onChangeCountry,
            onChangeState,
        };
    },
};
</script>

<style scoped>
form {
    margin-top: 20px;
}
</style>
