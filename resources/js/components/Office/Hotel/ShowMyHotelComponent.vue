<template>
    <tr id="hotel_id">
        <td class="text-nowrap align-middle">{{ $t('HotelName') }}</td>
        <td class="align-middle">{{ translate.hotel_name }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('Country') }}</td>
        <td class="align-middle">{{ translate.country }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('City') }}</td>
        <td class="align-middle">{{ translate.city }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('Settlement') }}</td>
        <td class="align-middle">{{ translate.settlement }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('Street') + ', ' + $t('NumberHouse') }}</td>
        <td class="align-middle">{{ translate.street }}, {{ translate.number_house }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('HotelPhone') }}</td>
        <td class="align-middle">{{ translate.phone }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('HotelAdditionalServices') }}</td>
        <td class="align-middle">{{ translate.aditional_services }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('Description') }}</td>
        <td class="align-middle">{{ translate.description }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('TimeOfSettlement') }}</td>
        <td class="text-nowrap align-middle">{{ translate.time_of_settlement }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('TimeOfEviction') }}</td>
        <td class="text-nowrap align-middle">{{ translate.time_of_eviction }}</td>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('BagroundPhoto') }}</td>
        <template v-if="photos">
            <template v-for="photo in photos">
                <td v-if="photo.kind_photo == 'baground_photo'" class="text-nowrap align-middle">
                    <img :src="photo.photo" width="60" height="60" class="img img-responsive mx-1" />
                </td>
            </template>
        </template>
    </tr>
    <tr>
        <td class="text-nowrap align-middle">{{ $t('PhotoOfHotel') }}</td>
        <td class="text-nowrap align-middle">
            <template v-if="photos">
                <template v-for="photo in photos">
                    <template v-if="photo.kind_photo == 'all_photos'">
                        <img :src="photo.photo" width="60" height="60" class="img img-responsive mx-1" />
                    </template>
                </template>
            </template>
        </td>
    </tr>
    <tr>
        <td class="text-center align-middle">
            <div class="align-top">
                <button class="btn btn-primary m-2" @click="this.$parent.setTheChange(true)">{{ $t('Change') }}</button>
            </div>
        </td>
        <td class="text-center align-middle">
            <button class="btn btn-danger m-2" @click="this.$parent.deleteHotel()">{{ $t('Delete') }}</button>
        </td>
    </tr>
</template>

<script>
export default {
    name: "ShowMyHotelComponent",

    props: [
        'translate',
        'photos'
    ],

}
</script>