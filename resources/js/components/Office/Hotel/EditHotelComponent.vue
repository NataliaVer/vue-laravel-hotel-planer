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
            <template>
                <input class="form-control" type="file" ref="all_photos" @change="addAllPhoto"
                    accept=".jpg, .jpeg, .png, .gif, .bmp" multiple />
            </template>
        </td>
    </tr>
    <tr>
        <td class="text-center align-middle">
            <div class="align-top">
                <button class="btn btn-primary m-2" @click="this.$parent.changeHotel()">{{ $t('Send') }}</button>
            </div>
        </td>
        <td class="text-center align-middle">
            <button class="btn btn-secondary m-2" @click="this.$parent.setTheChange()">{{ $t('Close') }}</button>
        </td>
    </tr>

    <!-- <template v-if="errors">
        <div class="alert alert-danger">
            <ul>
                <template v-for="error in errors">
                    <li>{{ error }}</li>
                </template>
            </ul>
        </div>
    </template> -->
</template>

<script>
export default {
    name: "EditHotelComponent",

    props: [
        'translate'
    ],

    data() {
        return {
            hotel_name: this.translate.hotel_name,
            country: this.translate.country,
            city: this.translate.city,
            settlement: this.translate.settlement,
            street: this.translate.street,
            number_house: this.translate.number_house,
            phone: this.translate.phone,
            aditional_services: this.translate.aditional_services,
            description: this.translate.description,
            time_of_settlement: this.translate.time_of_settlement,
            time_of_eviction: this.translate.time_of_eviction,
            baground_photo: null,
            all_photos: null,
        }
    },
}
</script>