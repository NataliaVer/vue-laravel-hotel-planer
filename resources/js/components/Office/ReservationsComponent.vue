<template>
    <div>
        <h1 class="text-center mt-2">{{ $t('Reservations') }}</h1>
        <p class="text-center">{{ $t('DescriptionReservationPage') }}</p>
    </div>
    <div class="my-3">
        <VueDatePicker v-model="date" range multi-calendars :enable-time-picker="false" @update:model-value="changeDate" />
    </div>
    <!-- <template v-if="rooms"> -->
        <div class="text-center">
        <router-link to="add_reservation"><button type="button" class="btn btn-primary mb-3">Add Reservation</button></router-link>
    </div>
    <!-- </template>
    <template v-else>
        <p class="text-danger text-center">Щоб створювати резервування, спочатку заповніть кімнати</p>
    </template> -->
    <template v-if="bookings">
        <template v-for="booking in bookings">
            <div class="card mb-3">
                <h5 class="card-header">{{ new Date(booking.date_from).toLocaleString("ru", {
                    day: 'numeric', month:
                        'numeric', year: 'numeric'
                }) +
                    ' - ' + new Date(booking.date_to).toLocaleString("ru", {
                        day: 'numeric', month: 'numeric', year:
                            'numeric'
                    }) }}</h5>
                <div class="card-body">
                    <h5 class="card-title">{{ booking.name }}</h5>
                    <p class="card-text">{{ booking.first_name + ' ' + booking.last_name }}</p>
                    <p class="card-text">{{ 'E-mail: ' + booking.email }}</p>
                    <p class="card-text">{{ 'Тел.: ' + booking.phone }}</p>
                    <template v-if="booking.confirmed">
                        <button class="btn btn-secondary" @click="confirmBooking(booking.id, 0)">{{ $t('CancelBooking') }}</button>
                    </template><template v-else>
                        <button class="btn btn-primary" @click="confirmBooking(booking.id, 1)">{{ $t('ConfirmBooking') }}</button>
                    </template>
                    <button class="btn btn-danger mx-2" @click="deleteBooking(booking.id)" style="float: right;">{{ $t('Delete') }}</button>
                    <button class="btn btn-info" @click="changeBooking(booking)" style="float: right;">{{ $t('Change') }}</button>
                </div>
            </div>
            <UpdateBookedRoomComponent :booking="booking" :options="options" :ref="`editBooking_${booking.id}`"></UpdateBookedRoomComponent>
        </template>
    </template>
</template>

<script>
import axios from 'axios';
import UpdateBookedRoomComponent from './BookedRoom/UpdateBookedRoomComponent.vue';


export default {

    data() {
        return {
            date: null,
            rooms: null,
            bookings: null,
            isEdit: null,
            options: null,
            errors: null,
        };
    },

    mounted() {
        //set date in datepicker and cookies
        let startDate = this.$cookies.get("startDate");
        startDate = startDate == null ? new Date() : startDate;
        let endDate = this.$cookies.get("endDate");
        endDate = endDate == null ? new Date(new Date().setDate(startDate.getDate() + 7)) : endDate;
        this.date = [startDate, endDate];
        this.getBockedRooms();

    },

    methods: {
        changeDate() {
            this.$cookies.set("startDate", new Date(this.date[0]).toISOString(), "1h");
            this.$cookies.set("endDate", new Date(this.date[1]).toISOString(), "1h");
            this.getBockedRooms();
        },

        getBockedRooms() {
            axios.get(`/api/searchBookedRooms/${new Date(this.date[0]).toLocaleDateString('fr-CA')}/${new Date(this.date[1]).toLocaleDateString('fr-CA')}`)
                .then(res => {
                    this.bookings = res.data;
                })
                .catch(err => {
                    // console.log(err);
                });
        },

        confirmBooking(id, action) {
            this.$swal({
                title: this.$t('QuestionConfirnOrCancelBooking'),
                showCancelButton: true,
                confirmButtonText: this.$t('Yes'),
                cancelButtonText: this.$t('No'),
            })
            .then((result) => {
                if (result.isConfirmed){
                    axios.get(`/api/confirmBooking/${id}/${action}`)
                    .then(res => {
                        console.log(res.data);
                        this.getBockedRooms();
                    })
                    .catch(err => {
                        console.log(err);
                    })
                }
            })
        },

        changeBooking(booking) {
            const date_from = new Date(booking.date_from).toLocaleDateString('fr-CA');
            const date_to = new Date(booking.date_to).toLocaleDateString('fr-CA');
            this.getAvialableRooms(booking.id, date_from, date_to);
            this.isEdit = booking.id;
            let editName = `editBooking_${booking.id}`;
            let fullEditName = this.$refs[editName][0];
            fullEditName.room = booking.room_id;
            fullEditName.date_from = date_from;
            fullEditName.date_to = date_to;
            fullEditName.first_name = booking.first_name;
            fullEditName.last_name = booking.last_name;
            fullEditName.email = booking.email;
            fullEditName.phone = booking.phone;
            fullEditName.confirmed = booking.confirmed === 0 ? false : true;
        },

        deleteBooking(id) {
            this.$swal({
                title: this.$t('QuestionDeleteBooking'),
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: this.$t('Delete'),
                cancelButtonText: this.$t('No'),
            })
            .then(result => {
                if (result.isConfirmed) {
                    axios.delete(`/api/bookingRoom/${id}`)
                    .then(res => {
                        console.log(res.data);
                        this.getBockedRooms();
                    })
                    .catch(err => {
                        console.log(err);
                    })
                }
            })
        },

        getAvialableRooms(id, dateFrom, dateTo) {
            let arrayOptions = [];
            axios.get(`/api/listAvialableRooms/${id}/${dateFrom}/${dateTo}`)
            .then(res => {
                this.options = res.data;
                for(let option of res.data){
                    arrayOptions.push(option);
                }
                this.options = arrayOptions;
            })
            .catch(err => {
                console.log(err);
                this.options = null;
            })
        },
    },

    components: {
        UpdateBookedRoomComponent,
    }

}
</script>