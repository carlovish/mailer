<template>
    <app-header></app-header>

    <div class="row">
        <div class="col-md-12" style="margin-top: 20px">
            <h2 class="text-left">All Emails</h2>

            <errors-and-messages :errors="errors"></errors-and-messages>

            <div v-if="emails.data.length">
                <DataTable class="display table table-striped">
                    <thead>
                        <tr>
                            <th>Destination email</th>
                            <th>Subject</th>
                            <th>Content</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="email of emails.data" :key="email.id">
                            <td>{{ email.addresee }}</td>
                            <td>{{ email.subject }}</td>
                            <td>{{ email.content }}</td>
                           
                        </tr>
                    </tbody>
                </DataTable>
            </div>
            <div class="text-center" v-else-if="user && user.role=='admin'">
                No emails found!
                <Link :href="$route('email.create')"
                    >Create email</Link
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
import { computed, inject} from "vue";

import DataTable from "datatables.net-vue3";

export default {
    name: "User",
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

        const deleteEmail = (id) => {
            if (!confirm("Are you sure?")) return;
            Inertia.delete(route("admin.destroy", { id }));
        };

        const emails=computed(() => usePage().props.value.emails);

        

        return {
            emails,
            deleteEmail,
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
