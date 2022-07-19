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
                    <label for="zipcode">City Code</label>
                    <input
                        type="number"
                        class="form-control"
                        name="zipcode"
                        id="zipcode"
                        v-model="form.zipcode"
                        required
                    />
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
            zipcode: null,
            day_of_birth: null,
            _token: usePage().props.value.csrf_token,
        });

        const route = inject("$route");

        function submit() {
            Inertia.post(route("admin.store"), form);
        }

        return {
            form,
            submit,
        };
    },
};
</script>

<style scoped>
form {
    margin-top: 20px;
}
</style>
