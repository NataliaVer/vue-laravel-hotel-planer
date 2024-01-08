<template>
    <div class="mb-3 mx-3">
        <h5 class="header text-center mt-3">{{ $t('AddReservationTextComponent') }}</h5>
        <div class="body">
            <div class="form-group">
                <label for="dateFrom">{{ $t('dateFrom') }}</label>
                <input type="date" id="dateFrom" v-model="date_from" class="form-control">
            </div>
            <div class="form-group">
                <label for="dateTo">{{ $t('dateTo') }}</label>
                <input type="date" id="dateTo" v-model="date_to" class="form-control">
            </div>
            <div class="form-group">
                <label for="UserRoomList">{{ $t('Room') }}</label>
                <select class="form-control" id="UserRoomList" v-model="room">
                    <template v-if="options">
                        <template v-for="option in options">
                            <template v-for="translation in option.translations">
                                <option v-if="activeLang() === translation.lang_code" :value="option.id">
                                    {{ translation.name }}
                                </option>
                            </template>
                        </template>
                    </template>
                </select>
            </div>
            <div class="form-group">
                <label for="name">{{ $t('FirstName') }}</label>
                <input type="name" name="first_name" v-model="first_name" class="form-control" id="first_name_br">
            </div>
            <div class="form-group">
                <label for="last_name">{{ $t('LastName') }}</label>
                <input type="name" name="last_name" v-model="last_name" class="form-control" id="last_name_br">
            </div>

            <div class="form-group">
                <label for="email">{{ $t('Email') }}</label>
                <input type="email" name="email" v-model="email" class="form-control" id="email_br">
            </div>
            <div class="form-group">
                <label for="phone">{{ $t('Phone') }}</label>
                <input type="phone" name="phone" v-model="phone" class="form-control" id="phone_br">
            </div>

            <div class="form-group my-2">
                <label for="confirmed">{{ $t('Confirmed') }}</label>
                <input type="checkbox" v-model="confirmed" id="confirmed">
            </div>

            <template v-if="errors">
                <div class="alert alert-danger my-3">
                    <p v-for="error in errors">{{ $t(error[0]) }}</p>
                </div>
            </template>

            <div>
                <button class="btn btn-primary mx-2" @click="sentData()">{{ $t('AddReservationButton') }}</button>
                <router-link to="/reservations"><button class="btn btn-secondary">{{ $t('Cancel') }}</button></router-link>
            </div>
        </div>

    </div>
</template>

<script>
import axios from 'axios';
import { getActiveLanguage } from 'laravel-vue-i18n';

export default {
    name: "AddBookedRoomComponent",

    data() {
        return {
            errors: null,
            date_from: new Date().toLocaleDateString('fr-CA'),
            date_to: new Date(new Date().setDate(new Date().getDate() + 1)).toLocaleDateString('fr-CA'),
            room: null,
            first_name: null,
            last_name: null,
            email: null,
            phone: null,
            confirmed: true,
            options: null,
        }
    },

    mounted() {
        const date_from = new Date().toLocaleDateString('fr-CA');
        const date_to = new Date(new Date().setDate(new Date().getDate() + 1)).toLocaleDateString('fr-CA');
        this.getAvialableRooms(date_from, date_to);
    },

    methods: {
        cancelAdd() {
            // this.$router.push('reservations');
        },

        sentData() {
            this.errors = null;
            axios.post(`/api/storeBookingRoom`, {
                date_from: this.date_from,
                date_to: this.date_to,
                room_id: this.room,
                first_name: this.first_name,
                last_name: this.last_name,
                email: this.email,
                phone: this.phone,
                confirmed: this.confirmed ? '1' : '0',
            })
                .then(res => {
                    // console.log(res);
                    // this.$parent.getBockedRooms();
                    this.$router.push('reservations');
                })
                .catch(err => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                })
        },

        getAvialableRooms(date_from, date_to) {
            // const date_from = new Date(this.date_from).toLocaleDateString('fr-CA');
            // const date_to = new Date(this.date_to).toLocaleDateString('fr-CA');
            let arrayOptions = [];
            axios.get(`/api/listAvialableRooms/empty/${date_from}/${date_to}`)
                .then(res => {
                    // console.log(res.data);
                    this.options = res.data;
                    // console.log(this.options);
                    for (let option of res.data) {
                        // console.log(option);
                        arrayOptions.push(option);
                    }
                    // console.log(arrayOptions);
                    this.options = arrayOptions;
                })
                .catch(err => {
                    console.log(err);
                    this.options = null;
                })
        },
        activeLang() {
            return getActiveLanguage();
        }
    }
}
</script>

<style scoped></style>