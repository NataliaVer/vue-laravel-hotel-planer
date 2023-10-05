<template>
    <div>
        <h1 class="text-center mt-2">{{ $t('MyRooms') }}</h1>
        <p class="text-center">{{ $t('DescriptionRoomPage') }}</p>
    </div>
    <div class="text-center mt-2">
        <template v-if="hotel">
            <router-link to="/add_room"><button class="btn btn-primary m-2" @click="addRoom">{{ $t('AddRoom') }}</button></router-link>
        </template>
        <template v-else>
            <p class="text-danger">{{ $t('AttentionBeforeAddRoom') }}</p>
        </template>
    </div>
    <div class="container">
        <template v-if="rooms">
            <div class="table-responsive table-lg mt-3">
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>{{ $t('Title') }}</th>
                            <th>{{ $t('Rules') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="room in rooms">
                            <tr id="id_user">
                                <td class="text-nowrap align-middle">{{ $t('RoomName') }}</td>
                                <td v-if="change != room.id" class="text-nowrap align-middle">{{ room.name }}</td>
                                <td v-if="change == room.id" class="text-nowrap align-middle">
                                    <input type="text" v-model="name" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('Price') }}</td>
                                <td v-if="change != room.id" class="text-nowrap align-middle">{{ room.price }}</td>
                                <td v-if="change == room.id" class="text-nowrap align-middle">
                                    <input type="text" v-model="price" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('Description') }}</td>
                                <td v-if="change != room.id" class="align-middle">{{ room.description }}</td>
                                <td v-if="change == room.id" class="text-nowrap align-middle">
                                    <input type="text" v-model="description" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('Amenities') }}</td>
                                <td v-if="change != room.id" class="align-middle">{{ room.amenities }}</td>
                                <td v-if="change == room.id" class="text-nowrap align-middle">
                                    <input type="text" v-model="amenities" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('CountBed') }}</td>
                                <td v-if="change != room.id" class="text-nowrap align-middle">{{ room.count_one_bed > 0 ?
                                    room.count_one_bed + ' x 1' :
                                    '' }} {{ room.count_two_bed > 0 ? room.count_two_bed + ' x 2' : '' }}</td>
                                <td v-if="change == room.id" class="text-nowrap align-middle">
                                    <div class="row g-2">
                                        <input type="text" v-model="count_one_bed" class="form-control">
                                        <input type="text" v-model="count_two_bed" class="form-control">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('CountOfThisRooms') }}</td>
                                <td v-if="change != room.id" class="text-nowrap align-middle">{{ room.count_rooms }}</td>
                                <td v-if="change == room.id" class="text-nowrap align-middle">
                                    <input type="text" v-model="count_rooms" class="form-control">
                                </td>
                            </tr>

                            <tr>
                                <td class="text-nowrap align-middle">{{ $t('RoomPhoto') }}</td>

                                <template v-if="photos && change != room.id">
                                    <template v-for="photo in photos">
                                        <td class="text-nowrap align-middle"
                                            v-if="photo.kind_photo == 'room_photos' && photo.room_id == room.id">
                                            <img :src="photo.photo" width="60" height="60" class="img img-responsive" />
                                        </td>
                                    </template>
                                </template>
                                <td v-if="change == room.id" class="text-nowrap align-middle">
                                    <input class="form-control" type="file" :ref="'room_photos' + room.id"
                                        @change="addRoomPhoto(room.id)" accept=".jpg, .jpeg, .png, .gif, .bmp" multiple />
                                </td>

                            </tr>
                            <tr>
                                <td class="text-center align-middle">
                                    <div class="align-top">
                                        <button v-if="change != room.id" class="btn btn-primary m-2"
                                            @click="setTheChange(room)">{{ $t('Change') }}</button>
                                        <button v-if="change == room.id" class="btn btn-primary m-2"
                                            @click="changeRoom(room.id)">{{ $t('Sent') }}</button>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <button v-if="change != room.id" class="btn btn-danger m-2" @click="deleteRoom(room.id)"
                                        type="button">{{ $t('Delete') }}</button>
                                    <button v-if="change == room.id" class="btn btn-secondary m-2"
                                        @click="setTheChange(false)" type="button">{{ $t('Close') }}</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

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
import axios from 'axios';


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
            count_one_bed: '',
            count_two_bed: '',
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
                    console.log(); res
                })
                .catch(err => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                })
        },

        setTheChange(room) {
            if (room) {
                this.change = room.id;
                this.name = room.name;
                this.price = room.price;
                this.description = room.description;
                this.amenities = room.amenities;
                this.count_one_bed = room.count_one_bed == null ? '' : room.count_one_bed;
                this.count_two_bed = room.count_two_bed == null ? '' : room.count_two_bed;
                this.count_rooms = room.count_rooms;
            } else {
                this.change = room;
                this.name = '';
                this.price = '';
                this.description = '';
                this.amenities = '';
                this.count_one_bed = '';
                this.count_two_bed = '';
                this.count_rooms = '';
            }
        },

        createDataRoom() {

            const newRoomData = new FormData();
            newRoomData.append('name', this.name);
            newRoomData.append('price', this.price);
            newRoomData.append('description', this.description);
            newRoomData.append('amenities', this.amenities);
            newRoomData.append('count_one_bed', this.count_one_bed);
            newRoomData.append('count_two_bed', this.count_two_bed);
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
        changeRoom(id) {
            let newRoomData = this.createDataRoom();
            axios.post(`/api/roomUpdate/${id}`, newRoomData)
                .then(res => {
                    this.change = false;
                    this.getRooms();
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                    this.errors = err.response.data.errors;
                })

        },
        deleteRoom(id) {
            axios.delete(`/api/room/${id}`)
            .then(res => {
                console.log(res.data);
                this.getRooms();
            })
            .catch(err => {
                console.log(err);
            })
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