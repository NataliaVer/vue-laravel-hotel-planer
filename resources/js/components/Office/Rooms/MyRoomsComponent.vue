<template>
    <div>
        <h1 class="text-center mt-2">{{ $t('MyRooms') }}</h1>
        <p class="text-center">{{ $t('DescriptionRoomPage') }}</p>
    </div>
    <div class="text-center mt-2">
        <template v-if="hotel">
            <router-link to="/add_room"><button class="btn btn-primary m-2" @click="addRoom">{{ $t('AddRoom')
            }}</button></router-link>
        </template>
        <template v-else>
            <p class="text-danger">{{ $t('AttentionBeforeAddRoom') }}</p>
        </template>
    </div>
    <div class="container">
        <template v-if="rooms && rooms.length != 0">
            <div class="table-responsive table-lg mt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>{{ $t('Title') }}</th>
                            <th>{{ $t('Rules') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="fullRoom in rooms">
                            <template v-for="room in fullRoom.translations">
                                <template v-if="room.lang_code == langName()">
                                    <tr id="id_user">
                                        <td class="text-nowrap align-middle">{{ $t('RoomName') }}</td>
                                        <td v-if="change != room.room_id" class="text-nowrap align-middle">{{ room.name }}
                                        </td>
                                        <td v-if="change == room.room_id" class="text-nowrap align-middle">
                                            <input type="text" v-model="name" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap align-middle">{{ $t('Price') }}</td>
                                        <td v-if="change != room.room_id" class="text-nowrap align-middle">{{ room.price }}
                                        </td>
                                        <td v-if="change == room.room_id" class="text-nowrap align-middle">
                                            <input type="text" v-model="price" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap align-middle">{{ $t('Description') }}</td>
                                        <td v-if="change != room.room_id" class="align-middle">{{ room.description }}</td>
                                        <td v-if="change == room.room_id" class="text-nowrap align-middle">
                                            <input type="text" v-model="description" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap align-middle">{{ $t('Amenities') }}</td>
                                        <td v-if="change != room.room_id" class="align-middle">{{ room.amenities }}</td>
                                        <td v-if="change == room.room_id" class="text-nowrap align-middle">
                                            <input type="text" v-model="amenities" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap align-middle">{{ $t('CountBed') }}</td>
                                        <td v-if="change != room.room_id" class="text-nowrap align-middle">{{ room.count_bed
                                            > 0 ?
                                            room.count_bed + ' x ' + room.count_seats_in_bed : "" }}</td>
                                        <td v-if="change == room.room_id" class="text-nowrap align-middle">
                                            <div class="row g-2">
                                                <input type="text" v-model="count_bed" class="form-control">
                                                <input type="text" v-model="count_seats_in_bed" class="form-control">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap align-middle">{{ $t('CountOfThisRooms') }}</td>
                                        <td v-if="change != room.room_id" class="text-nowrap align-middle">{{
                                            room.count_rooms }}</td>
                                        <td v-if="change == room.room_id" class="text-nowrap align-middle">
                                            <input type="text" v-model="count_rooms" class="form-control">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-nowrap align-middle">{{ $t('RoomPhoto') }}</td>

                                        <template v-if="photos && change != room.room_id">
                                            <template v-for="photo in photos">
                                                <td class="text-nowrap align-middle"
                                                    v-if="photo.kind_photo == 'room_photos' && photo.room_id == room.room_id">
                                                    <img :src="photo.photo" width="60" height="60"
                                                        class="img img-responsive" />
                                                </td>
                                            </template>
                                        </template>
                                        <td v-if="change == room.room_id" class="text-nowrap align-middle">
                                            <input class="form-control" type="file" :ref="'room_photos' + room.room_id"
                                                @change="addRoomPhoto(room.room_id)" accept=".jpg, .jpeg, .png, .gif, .bmp"
                                                multiple />
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="text-center align-middle">
                                            <div class="align-top">
                                                <button v-if="change != room.room_id" class="btn btn-primary m-2"
                                                    @click="setTheChange(room)">{{ $t('Change') }}</button>
                                                <button v-if="change == room.room_id" class="btn btn-primary m-2"
                                                    @click="changeRoom(room.room_id)">{{ $t('Sent') }}</button>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <button v-if="change != room.room_id" class="btn btn-danger m-2"
                                                @click="deleteRoom(room.room_id)" type="button">{{ $t('Delete') }}</button>
                                            <button v-if="change == room.room_id" class="btn btn-secondary m-2"
                                                @click="setTheChange(false)" type="button">{{ $t('Close') }}</button>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                        </template>
                    </tbody>
                </table>

            </div>
        </template>
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
    name: "MyRoomsComponent",

    data() {
        return {
            hotel: null,
            rooms: null,
            change: null,
            photos: null,
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
        this.getRooms();
    },
    methods: {
        getRooms() {
            axios.get('/api/getRooms')
                .then(res => {
                    this.hotel = res.data.hotel;
                    this.rooms = res.data.rooms;
                    this.photos = res.data.photos;
                    // console.log(this.rooms);
                })
                .catch(err => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                })
        },

        langName() {
            return getActiveLanguage();
        },

        setTheChange(room) {
            this.errors = null;
            if (room) {
                this.change = room.room_id;
                this.name = room.name;
                this.price = room.price;
                this.description = room.description;
                this.amenities = room.amenities;
                this.count_bed = room.count_bed == null ? '' : room.count_bed;
                this.count_seats_in_bed = room.count_seats_in_bed == null ? '' : room.count_seats_in_bed;
                this.count_rooms = room.count_rooms;
            } else {
                this.change = room;
                this.name = '';
                this.price = '';
                this.description = '';
                this.amenities = '';
                this.count_bed = '';
                this.count_seats_in_bed = '';
                this.count_rooms = '';
            }
        },

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
            // console.log(this.room_photos);

            return newRoomData;
        },
        changeRoom(id) {
            this.errors = null;
            let newRoomData = this.createDataRoom();
            axios.post(`/api/roomUpdate/${id}`, newRoomData)
                .then(res => {
                    this.change = false;
                    this.getRooms();
                    // console.log(res);
                })
                .catch(err => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                })

        },
        deleteRoom(id) {
            this.errors = null;
            this.$parent.$parent.$swal({
                title: this.$t('DoYouWantToDeleteThisRoom'),
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: this.$t('Close'),
                confirmButtonText: this.$t('Delete'),
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/room/${id}`)
                        .then(res => {
                            console.log(res.data);
                            this.getRooms();
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
        addRoomPhoto(id) {
            const editName = `room_photos${id}`;
            let files = this.$refs[editName][0].files;

            if (!files || !files.length)
                return;

            this.room_photos = files;
        },
    },
}
</script>