import { createRouter, createWebHistory } from "vue-router";

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
            path: '/signin', name: 'signin', component: () => import('./components/auth/SignInComponent.vue')
        },
        {
            path: '/signup', name: 'signup', component: () => import('./components/auth/SignUpComponent.vue')
        },
        {
            path: '/forgotpass', name: 'forgotpass', component: () => import('./components/auth/FogotPasswordComponent.vue')
        },
        {
            path: '/password/reset/:token', name: 'resetpass', component: () => import('./components/auth/ResetPasswordComponent.vue')
        },
        {
            path: '/get', name: 'get', component: () => import('./components/auth/GetComponent.vue')
        },
        {
            path: '/my_profile', name: 'my_profile', component: () => import('./components/Office/UserDataComponent.vue')
        },
        {
            path: '/my_hotel', name: 'my_hotel', component: () => import('./components/Office/MyHotelComponent.vue')
        },
        {
            path: '/my_rooms', name: 'my_rooms', component: () => import('./components/Office/MyRoomsComponent.vue')
        },
        {
            path: '/add_room', name: 'add_room', component: () => import('./components/Office/Rooms/AddRoomComponent.vue')
        },
        {
            path: '/reservations', name: 'reservations', component: () => import('./components/Office/ReservationsComponent.vue')
        },
        {
            path: '/add_reservation', name: 'add_reservation', component: () => import('./components/Office/BookedRoom/AddBookedRoomComponent.vue')
        },
    ]
})

// router.beforeEach((to, from, next) => {
//     const token = localStorage.getItem('x_xsrf_token');

//     if(!token) {
//         // if(to.name === 'signin' || to.name === 'signup' || to.name === 'home') {
//         //     return next()
//         // } else {
//         //     return next ({
//         //         name: 'signin'
//         //     })
//         // }
//     }
//     if((to.name === 'signin' || to.name === 'signup') && token) {
//         return next({
//             name: 'my_profile'
//         })
//     }

//     next()
// });

export default router;