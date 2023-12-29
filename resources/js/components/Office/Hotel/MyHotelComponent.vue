<template>
    <div>
        <h1 class="text-center mt-2">{{ $t('MyHotel') }}</h1>
        <p class="text-center">{{ $t('DescriptionHotelPage') }}</p>
    </div>
    <div class="container">
        <div class="table-responsive table-lg mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ $t('Title') }}</th>
                        <th>{{ $t('Rules') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="hotel_translations">
                        <template v-for="translate in hotel_translations">
                            <template v-if="langName() == translate.lang_code">
                                <template v-if="!change && hotel">
                                    <ShowMyHotelComponent :translate="translate" :photos="photos"></ShowMyHotelComponent>
                                </template>
                                <template v-if="change && hotel">
                                    <EditHotelComponent :translate="translate"></EditHotelComponent>
                                </template>
                            </template>
                        </template>
                    </template>
                    <template v-if="!hotel">
                        <AddHotelComponent ref="form"></AddHotelComponent>
                    </template>
                </tbody>
            </table>
        </div>
        <template v-if="!hotel">
            <div class="text-center">
                <button class="btn btn-primary m-2" @click="createHotel()">{{ $t('AddHotel') }}</button>
            </div>
        </template>
        <template v-if="errors">
            <div class="alert alert-danger">
                <ul>
                    <template v-for="error in errors">
                        <li>{{ error }}</li>
                    </template>
                </ul>
            </div>
        </template>
    </div>
</template>

<script>
import EditHotelComponent from './EditHotelComponent.vue';
import ShowMyHotelComponent from './ShowMyHotelComponent.vue';
import AddHotelComponent from './AddHotelComponent.vue';
import { getActiveLanguage } from 'laravel-vue-i18n';
export default {
    name: "MyHotelComponent",

    data() {
        return {
            hotel: null,
            change: null,
            photos: null,
            hotel_translations: null,
            errors: null,
            hotel_name: null,
            country: null,
            city: null,
            settlement: null,
            street: null,
            number_house: null,
            phone: null,
            aditional_services: null,
            description: null,
            time_of_settlement: null,
            time_of_eviction: null,
            baground_photo: null,
            all_photos: null,
        }
    },

    mounted() {
        this.getHotel();
        // console.log(this.hotel);
    },

    methods: {
        getHotel() {
            axios.get('/api/getHotel')
                .then(res => {
                    console.log(res);
                    this.photos = res.data.photos;
                    this.hotel_translations = res.data.translations;
                    if (res.data.hotel.length > 0) {
                        this.hotel = res.data.hotel[0];
                        this.hotel_name = res.data.hotel[0].hotel_name;
                        this.country = res.data.hotel[0].country;
                        this.city = res.data.hotel[0].city;
                        this.settlement = res.data.hotel[0].settlement;
                        this.street = res.data.hotel[0].street;
                        this.number_house = res.data.hotel[0].number_house;
                        this.phone = res.data.hotel[0].phone;
                        this.aditional_services = res.data.hotel[0].aditional_services;
                        this.description = res.data.hotel[0].description;
                        this.time_of_settlement = res.data.hotel[0].time_of_settlement;
                        this.time_of_eviction = res.data.hotel[0].time_of_eviction;
                    }
                })
                .catch(err => {
                    console.log(err);
                })
        },

        setTheChange(change) {
            this.change = change;
        },

        changeHotel() {

            this.errors = null;
            const newHotelData = this.createDataHotel();

            axios.post(`/api/hotelUpdate/${this.hotel.id}`, newHotelData)
                .then(res => {
                    this.change = false;
                    this.getHotel();
                })
                .catch(err => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                })
        },

        deleteHotel() {
            this.errors = null;
            this.$parent.$parent.$swal({
                title: this.$t('DoYouWantToDeleteYourHotel'),
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: this.$t('Close'),
                confirmButtonText: this.$t('Delete'),
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/hotel/${this.hotel.id}`)
                        .then(res => {
                            console.log(res);
                            this.hotel = null;
                            this.getHotel();
                        })
                        .catch(err => {
                            this.$parent.$parent.$swal({
                                icon: "error",
                                title: "Oops...",
                                text: err.response.data.message,
                            });
                            console.log(err);
                        })
                } else {
                    return null;
                }
            });
        },

        createDataHotel() {

            const newHotelData = new FormData();
            newHotelData.append('hotel_name', this.hotel_name);
            newHotelData.append('country', this.country);
            newHotelData.append('city', this.city);
            newHotelData.append('settlement', this.settlement);
            newHotelData.append('street', this.street);
            newHotelData.append('number_house', this.number_house);
            newHotelData.append('phone', this.phone);
            newHotelData.append('aditional_services', this.aditional_services);
            newHotelData.append('description', this.description);
            newHotelData.append('time_of_settlement', this.time_of_settlement);
            newHotelData.append('time_of_eviction', this.time_of_eviction);
            newHotelData.append('baground_photo', this.baground_photo);
            if (this.all_photos) {
                for (let i = 0; i < this.all_photos.length; i++) {
                    newHotelData.append('all_photos[' + i + ']', this.all_photos[i]);
                };
            } else {
                newHotelData.append('all_photos', null);
            }

            return newHotelData;
        },

        createHotel() {

            this.errors = null;
            this.$refs.form.createHotel();
        },
        addBagroundPhoto(e) {
            let files = this.$refs.baground_photo.files;

            if (!files || !files.length)
                return;

            this.baground_photo = files[0];
            console.log(this.baground_photo);
        },

        addAllPhoto(ev) {
            let files = this.$refs.all_photos.files;

            if (!files || !files.length)
                return;

            this.all_photos = files;
        },

        langName() {
            return getActiveLanguage();
        },

    },

    components: {
        ShowMyHotelComponent,
        EditHotelComponent,
        AddHotelComponent,
    },
}
</script>