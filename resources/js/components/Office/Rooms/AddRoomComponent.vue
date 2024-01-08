<template>
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
                            <tr id="id_user">
                                <td class="text-nowrap align-middle">{{ $t('RoomName') }}</td>
                                <td class="text-nowrap align-middle">
                                    <input type="text" v-model="name" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('Price') }}</td>
                                <td class="text-nowrap align-middle">
                                    <input type="text" v-model="price" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('Description') }}</td>
                                <td class="text-nowrap align-middle">
                                    <input type="text" v-model="description" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('Amenities') }}</td>
                                <td class="text-nowrap align-middle">
                                    <input type="text" v-model="amenities" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('CountBed') }}</td>
                                <td class="text-nowrap align-middle">
                                    <div class="row g-2">
                                        <input type="text" v-model="count_bed" class="form-control" placeholder="count bed">
                                        <input type="text" v-model="count_seats_in_bed" class="form-control" placeholder="count seats in bed">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('CountOfThisRooms') }}</td>
                                <td class="text-nowrap align-middle">
                                    <input type="text" v-model="count_rooms" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('RoomPhoto') }}</td>
                                <td class="text-nowrap align-middle">
                                    <input class="form-control" type="file" ref="room_photos"
                                        @change="addRoomPhoto()" accept=".jpg, .jpeg, .png, .gif, .bmp" multiple />
                                </td>

                            </tr>
                            <tr>
                                <td class="text-center align-middle">
                                    <div class="align-top">
                                        <button class="btn btn-primary m-2"
                                            @click="sentRoomData">{{ $t('Sent') }}</button>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <router-link to="/my_rooms"><button class="btn btn-secondary m-2">{{ $t('Close') }}</button></router-link>
                                </td>
                            </tr>
                    </tbody>
                </table>

            </div>
        <template v-if="errors">
            <div class="alert alert-danger">
                <ul>
                    <template v-for="error in errors">
                        <li>{{ error[0] }}</li>
                    </template>
                </ul>
            </div>
        </template>
    </div>
</template>

<script>
import axios from 'axios';
import { getActiveLanguage } from 'laravel-vue-i18n';

export default {
    name: "AddRoomsComponent",

    data() {
        return {
            errors: null,
            name: null,
            price: null,
            description: null,
            amenities: null,
            count_bed: '',
            count_seats_in_bed: '',
            count_rooms: null,
            room_photos: null,
        }
    },

    mounted() {
    },
    methods: {

        createDataRoom() {

            const newRoomData = new FormData();
            newRoomData.append('lang_code', getActiveLanguage());
            newRoomData.append('name', this.name);
            newRoomData.append('price', this.price);
            newRoomData.append('description', this.description);
            newRoomData.append('amenities', this.amenities);
            newRoomData.append('count_bed', this.count_bed);
            newRoomData.append('count_seats_in_bed', this.count_seats_in_bed);
            newRoomData.append('count_rooms', this.count_rooms);
            if (this.room_photos) {
                for (let i = 0; i < this.room_photos.length; i++) {
                    newRoomData.append('room_photos[' + i + ']', this.room_photos[i]);
                };
            } else {
                newRoomData.append('room_photos', null);
            };
            console.log(this.room_photos);

            return newRoomData;
        },

        sentRoomData() {
            this.errors = null;
            let newRoomData = this.createDataRoom();
            axios.post(`/api/room/create`, newRoomData)
            .then(res => {
                console.log(res.data);
                this.$router.push('my_rooms');
            })
            .catch(err => {
                console.log(err);
                this.errors = err.response.data.errors;
            })
        },

        addRoomPhoto(id) {
            let files = this.$refs.room_photos.files;

            if (!files || !files.length)
                return;

            this.room_photos = files;
        },
    },
}
</script>