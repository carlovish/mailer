<template>
    <app-header></app-header>

    <div class="row">
        <div class="col-md-12" style="margin-top: 20px">
            <h2 class="text-left">All Users</h2>

            <errors-and-messages :errors="errors"></errors-and-messages>

            <div v-if="users.data.length > 0">
                <DataTable class="display table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Card Id</th>
                            <th>Date of Birth</th>
                            <th>Age</th>
                            <th>City</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user of users.data" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.phone }}</td>
                            <td>{{ user.card_id }}</td>
                            <td>{{ user.day_of_birth }}</td>
                            <td>{{ getAge(user.day_of_birth)}}</td>
                            <td>{{ user.city.name }}</td>
                            <td>
                                <Link
                                    :href="
                                        $route('admin.edit', { id: user.id })
                                    "
                                    class="btn btn-primary pull-right action-btn"
                                    >Edit</Link
                                >
                                <a
                                    href="javascript:void(0);"
                                    class="btn btn-warning pull-right action-btn"
                                    @click.prevent="deleteUser(user.id)"
                                    ><i class="fas fa-trash-alt"></i> Delete</a
                                >
                                <Link
                                    :href="
                                        $route('showEmails', { id: user.id })
                                    "
                                    class="btn btn-primary pull-right action-btn"
                                    >View Emails</Link
                                >
                            </td>
                        </tr>
                    </tbody>
                </DataTable>

                <!-- Pagination links-->
                <nav
                    aria-label="Page navigation"
                    v-if="users.total > users.per_page"
                    style="margin-top: 20px"
                >
                    <ul class="pagination">
                        <!-- Previous link -->
                        <li
                            :class="
                                'page-item' +
                                (users.links[0].url == null ? ' disabled' : '')
                            "
                        >
                            <Link
                                :href="
                                    users.links[0].url == null
                                        ? '#'
                                        : users.links[0].url
                                "
                                class="page-link"
                                v-html="users.links[0].label"
                            ></Link>
                        </li>

                        <!-- Numbers -->
                        <li
                            v-for="item in numberLinks"
                            :key="item"
                            :class="
                                'page-item' + (item.active ? ' disabled' : '')
                            "
                        >
                            <Link
                                :href="item.active ? '#' : item.url"
                                class="page-link"
                                v-html="item.label"
                            ></Link>
                        </li>

                        <!-- Next link -->
                        <li
                            :class="
                                'page-item' +
                                (users.links[users.links.length - 1].url == null
                                    ? ' disabled'
                                    : '')
                            "
                        >
                            <inertia-link
                                :href="
                                    users.links[users.links.length - 1].url ==
                                    null
                                        ? '#'
                                        : users.links[users.links.length - 1]
                                              .url
                                "
                                class="page-link"
                                v-html="
                                    users.links[users.links.length - 1].label
                                "
                            ></inertia-link>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="text-center" v-else>
                No users found!
                <Link :href="$route('admin.create')"
                    >Create user</Link
                >
            </div>
        </div>
    </div>
</template>

<script>
import AppHeader from "../../Partials/AppHeader";
import ErrorsAndMessages from "../../Partials/ErrorsAndMessages";
import { usePage, Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { computed, inject } from "vue";

import DataTable from "datatables.net-vue3";

export default {
    name: "Admin",
    components: {
        ErrorsAndMessages,
        AppHeader,
        Link,
        DataTable,
    },
    props: {
        errors: Object,
    },
    setup() {
        const route = inject("$route");

        const deleteUser = (id) => {
            if (!confirm("Are you sure?")) return;
            Inertia.delete(route("admin.destroy", { id }));
        };

        const users = computed(() => usePage().props.value.users);
        console.log(users);
        const numberLinks = users.value.links.filter(
            (v, i) => i > 0 && i < users.value.links.length - 1
        );

        const getAge =dateString=> {
            var ageInMilliseconds = new Date() - new Date(dateString);
            return Math.floor(ageInMilliseconds / 1000 / 60 / 60 / 24 / 365); // convert to years
        }

        return {
            users,
            deleteUser,
            getAge,
            numberLinks,
        };
    },
};
</script>

<style scoped>
.action-btn {
    margin-left: 12px;
    font-size: 13px;
}

.article {
    margin-top: 20px;
}

@import "datatables.net-bs5";
</style>
