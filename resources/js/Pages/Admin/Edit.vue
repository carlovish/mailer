<template>
    <app-header></app-header>

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form method="post" @submit.prevent="submit">
                <h2 class="text-left">Update User</h2>

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

                <input type="submit" class="btn btn-primary btn-block" value="Update" />
            </form>
        </div>
    </div>
</template>

<script>
import AppHeader from "../../Partials/AppHeader";
import {inject, reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";
import ErrorsAndMessages from "../../Partials/ErrorsAndMessages";
import {usePage} from "@inertiajs/inertia-vue3";
export default {
    name: "Edit",
    components: {
        ErrorsAndMessages,
        AppHeader
    },
    props: {
        errors: Object
    },
    setup() {
        const form = reactive({
            name: null,
            password: null,
            password_confirmation: null,
            phone: null,
            zipcode: null,
            day_of_birth: null,
             _token: usePage().props.value.csrf_token,
            _method: "PUT"
        });

        // retrieve post prop
        const {name,password,phone,zipcode,day_of_birth , id } = usePage().props.value.user;
        form.name = name;
        form.password = password;
        form.password_confirmation=password;
        form.phone=phone;
        form.day_of_birth=day_of_birth;
        form.zipcode=zipcode;

        const route = inject('$route');


        function submit() {
            Inertia.post(route('admin.update', {'id': id}), form, {
                forceFormData: true
            });
        }

        return {
            form, submit
        }
    }
}
</script>

<style scoped>
    form {
        margin-top: 20px;
    }
</style>