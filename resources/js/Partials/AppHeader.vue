<template>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <Link href="/" class="navbar-brand">MAILER S.A.</Link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                      <Link href="/" class="nav-link">Home</Link>
                    </li>
                    <li class="nav-item" v-if="user && user.role=='admin'">
                        <Link :href="$route('admin.create')" class="nav-link">Create New user</Link>
                    </li>
                    <li class="nav-item" v-if="user.role=='user'">
                        <Link :href="$route('email.create')" class="nav-link">Create New Email</Link>
                    </li>
                </ul>
            </div>

            <div class="navbar-collapse collapse order-3 dual-collapse2">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item" v-if="!user">
                     
                        <Link href="/login" class="nav-link">Login</Link>
                       
                    </li>
                    
                    <li class="nav-item" v-if="user">
                        <span class="navbar-text" v-if="user">
                            Logged in as {{user.name}}
                        </span>
                        <Link :href="$route('logout')" as="button" method="post" class="nav-link logout-link" style="display: inline" type="button">Logout</Link>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
import {computed} from "vue";
import {usePage, Link} from "@inertiajs/inertia-vue3";


export default {
    name: "AppHeader",
    components:{
        Link
    },
    setup() {
        const user = computed(() => usePage().props.value.auth.user);
        
        return {
            user
        }
    }
}
</script>