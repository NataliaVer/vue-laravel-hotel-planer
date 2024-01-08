<template>
    <div class="card mb-3" :class="this.$parent.isEdit === booking.id ? '' : 'd-none'">
        <h5 class="card-header">{{ $t('UpdateBookedRoomComponentHeader') }}</h5>
        <div class="card-body">
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
                <label for="name">{{$t('FirstName')}}</label>
                <input type="name" name="first_name" v-model="first_name" class="form-control" id="first_name_br">
            </div>
            <div class="form-group">
                <label for="last_name">{{$t('LastName')}}</label>
                <input type="name" name="last_name" v-model="last_name" class="form-control" id="last_name_br">
            </div>

            <div class="form-group">
                <label for="email">{{$t('Email')}}</label>
                <input type="email" name="email" v-model="email" class="form-control" id="email_br">
            </div>
            <div class="form-group">
                <label for="phone">{{$t('Phone')}}</label>
                <input type="phone" name="phone" v-model="phone" class="form-control" id="phone_br">
            </div>

            <div class="form-group my-2">
                <label for="confirmed">{{$t('Confirmed')}}</label>
                <input type="checkbox" v-model="confirmed" id="confirmed">
            </div>

            <template v-if="errors">
                <div class="alert alert-danger my-3">
                    <p v-for="error in errors">{{ $t(error[0]) }}</p>
                </div>
            </template>

            <div>
                <button class="btn btn-primary mx-2" @click="sentData(booking.id)">{{ $t('Sent') }}</button>
                <!-- <button class="btn btn-secondary" @click="cancelEdit">{{ $t('Cancel') }}</button> -->
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { getActiveLanguage } from 'laravel-vue-i18n';

export default {
    name: "UpdateBookedRoomComponent",

    props: [
        'booking',
        'options'
    ],

    data() {
        return {
            errors: null,
            date_from: null,
            date_to: null,
            room: null,
            first_name: null,
            last_name: null,
            email: null,
            phone: null,
            confirmed: null,
            // options: null,
        }
    },

    mounted() {
    },

    methods: {
        cancelEdit() {
            this.$parent.isEdit = null;
        },

        sentData(id) {
            this.errors = null;
            axios.post(`/api/bookingRoom/update/${id}`, {
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
                    this.$parent.getBockedRooms();
                    this.$parent.isEdit = null;
                })
                .catch(err => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                })
        },

        activeLang() {
            return getActiveLanguage();
        }
    }
}
</script>

<style scoped></style>