<template>
    <div>
        <h1 class="text-center mt-2">{{ $t('MyHotel') }}</h1>
        <p class="text-center">{{ $t('DescriptionHotelPage') }}</p>
    </div>
    <div class="container">
    <div class="table-responsive table-lg mt-3">
        <table class="table table-bordered">
            <!-- <template v-if="hotel"> -->
            <thead>
                <tr>
                    <th>{{ $t('Title') }}</th>
                    <th>{{ $t('Rules') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr id="hotel_id">
                    <td class="text-nowrap align-middle">{{ $t('HotelName') }}</td>
                    <td v-if="!change && hotel" class="align-middle">{{ hotel_name }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="text" v-model="hotel_name" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('Country') }}</td>
                    <td v-if="!change && hotel" class="align-middle">{{ country }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="text" v-model="country" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('City') }}</td>
                    <td v-if="!change && hotel" class="align-middle">{{ city }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="text" v-model="city" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('Settlement') }}</td>
                    <td v-if="!change && hotel" class="align-middle">{{ settlement }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="text" v-model="settlement" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('Street') +', '+ $t('NumberHouse') }}</td>
                    <td v-if="!change && hotel" class="align-middle">{{ street }}, {{ number_house }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <div class="row g-2">
                        <input type="text" v-model="street" class="form-control" placeholder="Street">
                        <input type="text" v-model="number_house" class="form-control" placeholder="Number house">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('HotelPhone') }}</td>
                    <td v-if="!change && hotel" class="align-middle">{{ phone }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="text" v-model="phone" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('HotelAdditionalServices') }}</td>
                    <td v-if="!change && hotel" class="align-middle">{{ aditional_services }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="text" v-model="aditional_services" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('Description') }}</td>
                    <td v-if="!change && hotel" class="align-middle">{{ description }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="text" v-model="description" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('TimeOfSettlement') }}</td>
                    <td v-if="!change && hotel" class="text-nowrap align-middle">{{ time_of_settlement }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="time" v-model="time_of_settlement" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('TimeOfEviction') }}</td>
                    <td v-if="!change && hotel" class="text-nowrap align-middle">{{ time_of_eviction }}</td>
                    <td v-if="change || !hotel" class="text-nowrap align-middle">
                        <input type="time" v-model="time_of_eviction" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('BagroundPhoto') }}</td>
                    <template v-if="photos && ! change">
                        <template v-for="photo in photos">
                            <td v-if="photo.kind_photo == 'baground_photo'" class="text-nowrap align-middle">
                                <img :src="photo.photo" width="60" height="60" class="img img-responsive mx-1" />
                            </td>
                        </template>
                    </template>
                    <td v-if="change || !hotel">
                        <input class="form-control" type="file" ref="baground_photo" @change="addBagroundPhoto"
                            accept=".jpg, .jpeg, .png, .gif, .bmp" />
                    </td>
                </tr>
                <tr>
                    <td class="text-nowrap align-middle">{{ $t('PhotoOfHotel') }}</td>
                    <td class="text-nowrap align-middle">
                        <template v-if="photos && !change">
                            <template v-for="photo in photos">
                                <template v-if="photo.kind_photo == 'all_photos'">
                                    <img :src="photo.photo" width="60" height="60" class="img img-responsive mx-1" />
                                </template>
                            </template>
                        </template>
                        <template v-if="change || !hotel">
                            <input class="form-control" type="file" ref="all_photos" @change="addAllPhoto"
                                accept=".jpg, .jpeg, .png, .gif, .bmp" multiple />
                        </template>
                    </td>
                </tr>
                <tr v-if="hotel">
                    <td class="text-center align-middle">
                        <div class="align-top">
                            <button v-if="!change" class="btn btn-primary m-2" @click="setTheChange(true)">{{ $t('Change') }}</button>
                            <button v-if="change" class="btn btn-primary m-2" @click="changeHotel()">{{ $t('Send') }}</button>
                        </div>
                    </td>
                    <td class="text-center align-middle">
                        <button v-if="!change" class="btn btn-danger m-2" @click="deleteHotel()">{{ $t('Delete') }}</button>
                        <button v-if="change" class="btn btn-secondary m-2" @click="setTheChange()">{{ $t('Close') }}</button>
                    </td>
                </tr>
            </tbody>
            <!-- </template> -->
            <template v-if="!hotel">
                <div class="text-center">
                    <button class="btn btn-primary m-2" @click="createHotel()">{{ $t('AddHotel') }}</button>
                </div>
            </template>
        </table>
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
</div>
</template>

<script>
import axios from 'axios';

export default {
    name: "MyHotelComponent",

    data() {
        return {
            hotel: null,
            change: null,
            photos: null,
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
    },

    methods: {
        getHotel() {
            axios.get('/api/getHotel')
                .then(res => {
                    this.hotel = res.data.hotel;
                    this.photos = res.data.photos;
                    if (res.data.hotel) {
                        this.hotel_name = res.data.hotel.hotel_name;
                        this.country = res.data.hotel.country;
                        this.city = res.data.hotel.city;
                        this.settlement = res.data.hotel.settlement;
                        this.street = res.data.hotel.street;
                        this.number_house = res.data.hotel.number_house;
                        this.phone = res.data.hotel.phone;
                        this.aditional_services = res.data.hotel.aditional_services;
                        this.description = res.data.hotel.description;
                        this.time_of_settlement = res.data.hotel.time_of_settlement;
                        this.time_of_eviction = res.data.hotel.time_of_eviction;
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

            // for (const [key, value] of newHotelData) {
            //     console.log(`${key}: ${value}\n`);
            // }
            

            axios.post(`/api/hotelUpdate/${this.hotel.id}`, newHotelData)
            .then(res => {
                this.change = false;
                console.log(res);
                this.getHotel();
            })
            .catch(err => {
                console.log(err);
                this.errors = err.response.data.errors;
            })
        },

        deleteHotel() {
            this.errors = null;
            axios.delete(`/api/hotel/${this.hotel.id}`)
            .then(res => {
                console.log(res);
                this.getHotel();
            })
            .catch(err => {
                this.errors = err.response.data.errors;
                console.log(err);
            })
        },

        createDataHotel(){

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
            if(this.all_photos) {
            for (let i=0; i< this.all_photos.length; i++) {
                newHotelData.append('all_photos['+i+']', this.all_photos[i]);
            };
            } else {
                newHotelData.append('all_photos', null);
            }

            return newHotelData;
        },

        createHotel() {
            
            this.errors = null;
            const newHotelData = this.createDataHotel();

            console.log(newHotelData);

            axios.post('api/hotel/create', newHotelData)
                .then(res => {
                    console.log(res);
                    // console.log(newHotelData);
                    this.getHotel();
                })
                .catch(err => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                })
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

    },
}
</script>