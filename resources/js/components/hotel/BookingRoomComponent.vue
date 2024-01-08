<template>
    <div>
        <div class="container text-center my-3">
            <h5 class="title">{{ $t('ReserveRoom') }}</h5>
        </div>

        <div class="container text-center col-md-5 d-flex justify-content-around">
            <!-- <div class="row"> -->
                <template v-if="hotel">
                    <template v-for="photo in hotel.photos">
                        <template v-if="photo.room_id == this.$route.params.id">
                            <div class="">
                                <img :src="photo.photo" class="img-fluid rounded-start" :alt="photo.room_id" width="200"
                                    height="200">
                            </div>
                        </template>
                    </template>
                    <template v-if="hotel.hotel_translations">
                <template v-for="hotel_translate in hotel.hotel_translations">
                    <template v-if="langName() == hotel_translate.lang_code">
                    <div class="text-start align-self-end">
                        <h4>{{ hotel_translate.hotel_name }}</h4>
                        <h6>{{ hotel_translate.settlement }}, {{ hotel_translate.street }}, {{
                            hotel_translate.number_house }}</h6>
                        <p>{{ $t('CheckIn') }}: {{ new Date(this.$route.params.dateFrom).toLocaleDateString('ua') }}</p>
                        <p>{{ $t('CheckOut') }}: {{ new Date(this.$route.params.dateTo).toLocaleDateString('ua') }}</p>
                    </div>
                    </template>
                    </template>
                    </template>
                </template>
            <!-- </div> -->
        </div>

        <div class="container col-md-6">

            <div class="form-group">
                <label for="first_name">{{ $t('FirstName') }}</label>
                <input type="name" name="first_name" class="form-control" v-model="first_name" id="first_name">
            </div>
            <div class="form-group">
                <label for="last_name">{{ $t('LastName') }}</label>
                <input type="name" name="last_name" class="form-control" v-model="last_name" id="last_name">
            </div>

            <div class="form-group">
                <label for="email">{{ $t('Email') }}</label>
                <input type="email" name="email" class="form-control" v-model="email" id="email">
            </div>

            <div class="form-group">
                <label for="phone">{{ $t('Phone') }}</label>
                <input type="phone" name="phone" class="form-control" v-model="phone" id="phone">
            </div>

        </div>
        <template v-if="errors">
            <div class="alert alert-danger my-3">
                <p v-for="error in errors">{{ $t(error[0]) }}</p>
            </div>
        </template>
        <div class="container text-center my-3">
            <button type="button" @click.prevent="bookingRoom()" class="btn btn-primary">{{ $t('Reserve') }}</button>
        </div>

    </div>
</template>

<script>
import { getActiveLanguage } from 'laravel-vue-i18n';
import axios from 'axios';

export default {
    data() {
        return {
            errors: null,
            options : { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' },
            first_name: null,
            last_name: null,
            email: null,
            phone: null,
        }
    },

    mounted() {
        this.$store.dispatch('getHotel', { id: this.$route.params.hotel_id, dateFrom: this.$route.params.dateFrom, dateTo: this.$route.params.dateTo });
    },

    methods: {
        bookingRoom() {
            axios.post('/api/bookingroom', {
                id: this.$route.params.id,
                first_name: this.first_name,
                last_name: this.last_name,
                email: this.email,
                phone: this.phone,
                date_from: this.$route.params.dateFrom,
                date_to: this.$route.params.dateTo,
            })
            .then(res => {
                this.first_name = null;
                this.last_name = null;
                this.email = null;
                this.phone = null;
                this.$parent.$parent.AddReservationSaccess();
                this.$router.push(`/hotel/${this.$route.params.hotel_id}/${this.$route.params.dateFrom}/${this.$route.params.dateTo}`);
            })
            .catch(error => {
                // console.log(error);
                this.errors = error.response.data.errors;
            })
        },

        langName() {
            return getActiveLanguage();
        },
    },

    computed: {
        hotel() {
            return this.$store.getters.hotel
        }
    },
}

</script>