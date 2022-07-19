import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { createApp, h } from "vue";
import "./bootstrap";

createInertiaApp({
    resolve: (name) => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.config.globalProperties.$route = window.route;
        app.provide("$route", window.route);
        app.use(plugin).mount(el);
    },
});
