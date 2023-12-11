<template>
    <tr id="hotel_id">
        <td class="text-nowrap align-middle">{{ $t('HotelName') }}</td>
        <td class="text-nowrap align-middle">
            <input type="text" v-model="hotel_name" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('Country') }}</td>
        <td class="text-nowrap align-middle">
            <input type="text" v-model="country" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('City') }}</td>
        <td class="text-nowrap align-middle">
            <input type="text" v-model="city" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('Settlement') }}</td>
        <td class="text-nowrap align-middle">
            <input type="text" v-model="settlement" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('Street') + ', ' + $t('NumberHouse') }}</td>
        <td class="text-nowrap align-middle">
            <div class="row g-2">
                <input type="text" v-model="street" class="form-control" placeholder="Street">
                <input type="text" v-model="number_house" class="form-control" placeholder="Number house">
            </div>
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('HotelPhone') }}</td>
        <td class="text-nowrap align-middle">
            <input type="text" v-model="phone" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('HotelAdditionalServices') }}</td>
        <td class="text-nowrap align-middle">
            <input type="text" v-model="aditional_services" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('Description') }}</td>
        <td class="text-nowrap align-middle">
            <input type="text" v-model="description" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('TimeOfSettlement') }}</td>
        <td class="text-nowrap align-middle">
            <input type="time" v-model="time_of_settlement" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('TimeOfEviction') }}</td>
        <td class="text-nowrap align-middle">
            <input type="time" v-model="time_of_eviction" class="form-control">
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('BagroundPhoto') }}</td>
        <td>
            <input class="form-control" type="file" ref="baground_photo" @change="addBagroundPhoto"
                accept=".jpg, .jpeg, .png, .gif, .bmp" />
        </td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('PhotoOfHotel') }}</td>
        <td class="text-nowrap align-middle">
                <input class="form-control" type="file" ref="all_photos" @change="addAllPhoto"
                    accept=".jpg, .jpeg, .png, .gif, .bmp" multiple />
        </td>
    </tr>
</template>

<script>
import { getActiveLanguage } from 'laravel-vue-i18n';

export default {
    name: "AddHotelComponent",

    data() {
        return {
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

    methods: {
        createDataHotel() {

            const newHotelData = new FormData();
            newHotelData.append('lang_code', getActiveLanguage());
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
            const newHotelData = this.createDataHotel();

            console.log(newHotelData);

            axios.post('api/hotel/create', newHotelData)
                .then(res => {
                    console.log(res);
                    // console.log(newHotelData);
                    this.$parent.getHotel();
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