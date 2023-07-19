/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from "vue-router";
import store from './store';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import { i18nVue } from 'laravel-vue-i18n'

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application'./components/home/ExampleComponent.vueor you.
 */

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/hotel/:id/:dateFrom/:dateTo', name: 'hotel.show', component: () => import('./components/hotel/ShowHotelComponent.vue')
        },
        {
            path: '/', name: 'home', component: () => import('./components/home/HomeComponent.vue')
        },
        {
            path: '/booking_room/:hotel_id/:id/:dateFrom/:dateTo', name: 'room.book', component: () => import('./components/hotel/BookingRoomComponent.vue')
        },
        {
            path: '/signin', name: 'signin', component: () => import('./components/auth/SigninComponent.vue')
        },
        {
            path: '/signup', name: 'signup', component: () => import('./components/auth/SignUpComponent.vue')
        },
    ]
})

const app = createApp({});

import App from './components/App.vue'
app.component('app-component', App);

import FooterComponent from './components/includes/FooterComponent.vue';
app.component('footer-component', FooterComponent);

import HeaderComponent from './components/includes/HeaderComponent.vue';
app.component('header-component', HeaderComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.use(VueSweetalert2);
app.use(store);

app.use(i18nVue, {
    resolve: async lang => {
        const langs = import.meta.glob('../lang/*.json');
        return await langs[`../lang/${lang}.json`]();
    }
});

app.use(router).mount('#app');

