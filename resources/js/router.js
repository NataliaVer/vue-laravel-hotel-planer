import store from './store';
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/hotel/:id/:dateFrom/:dateTo',
            name: 'hotel.show',
            component: () => import('./components/hotel/ShowHotelComponent.vue'),
            meta: { guest: true},
        },
        {
            path: '/',
            name: 'home',
            component: () => import('./components/home/HomeComponent.vue'),
            meta: { guest: true},
        },
        {
            path: '/booking_room/:hotel_id/:id/:dateFrom/:dateTo',
            name: 'room.book',
            component: () => import('./components/hotel/BookingRoomComponent.vue'),
            meta: { guest: true},
        },
        {
            path: '/forgotpass',
            name: 'forgotpass',
            component: () => import('./components/auth/FogotPasswordComponent.vue'),
            meta: { guest: true},
        },
        {
            path: '/password/reset/:token',
            name: 'resetpass',
            component: () => import('./components/auth/ResetPasswordComponent.vue'),
            meta: { guest: true},
        },
        {
            path: '/my_profile',
            name: 'my_profile',
            component: () => import('./components/Office/UserDataComponent.vue'),
            meta: { guest: false},
        },
        {
            path: '/my_hotel',
            name: 'my_hotel',
            component: () => import('./components/Office/Hotel/MyHotelComponent.vue'),
            meta: { guest: false},
        },
        {
            path: '/my_rooms',
            name: 'my_rooms',
            component: () => import('./components/Office/Rooms/MyRoomsComponent.vue'),
            meta: { guest: false},
        },
        {
            path: '/add_room',
            name: 'add_room',
            component: () => import('./components/Office/Rooms/AddRoomComponent.vue'),
            meta: { guest: false},
        },
        {
            path: '/reservations',
            name: 'reservations',
            component: () => import('./components/Office/BookedRoom/ReservationsComponent.vue'),
            meta: { guest: false},
        },
        {
            path: '/add_reservation',
            name: 'add_reservation',
            component: () => import('./components/Office/BookedRoom/AddBookedRoomComponent.vue'),
            meta: { guest: false},
        },
        {
            path: '/signin',
            name: 'signin',
            component: () => import('./components/auth/SignInComponent.vue'),
            meta: { guest: true},
        },
        {
            path: '/signup',
            name: 'signup',
            component: () => import('./components/auth/SignUpComponent.vue'),
            meta: { guest: true},
        },
    ]
})

router.beforeEach(async(to, from) => {
    
    const guest = await store.getters.guest;

    if(to.meta.guest === false && guest === '1') {
        return {
            path: '/signin',
        }
    }

    if(to.path == '/signin' || to.path == '/signup') {
        if(guest != '1'){
            return {
                path: from.path,
            }
        }
    }
});

export default router;