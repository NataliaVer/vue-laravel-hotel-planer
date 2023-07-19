<template>
    <template v-if="hotel">
    <div class="container">
        <template v-if="hotel.photos">
            <div class="col-lg-12 d-flex justify-content-center">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <template v-for="photo, index in hotel.photos">
                            <template v-if="photo.kind_photo == 'all_photos'">
                                <div :class="index === 1 ? 'carousel-item active' : 'carousel-item'">
                                    <div class="d-flex justify-content-center">
                                        <img :src="photo.photo" class="d-block" alt="...">
                                    </div>
                                </div>
                            </template>
                        </template>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div class="container pt-3 col-md-7">
        <template v-if="hotel.hotel">
            <div class="card text-center">
                <div class="card-header">
                    {{ hotel.hotel.hotel_name }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ hotel.hotel.city }}, {{ hotel.hotel.settlement }}, {{ hotel.hotel.street }}, {{
                        hotel.hotel.number_house }}</h5>
                    <p class="card-text">{{ hotel.hotel.description }}</p>
                    <p class="card-text">{{ $t('AdditionalServices') }} {{ hotel.hotel.aditional_services }}</p>
                    <p class="card-text">{{ $t('Check-inTime') }} {{ hotel.hotel.time_of_settlement }} {{ $t('EvictionTime') }} {{ hotel.hotel.time_of_eviction }}</p>
                </div>
                <div class="card-footer text-muted">
                    {{ $t('CallUs') }} {{ hotel.phone }}
                </div>
            </div>
        </template>
    </div>

    <div class="container alert alert-info col-md-8 my-3" role="alert">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="">{{ $t('SelectDate') }}</span>
            </div>
            <input type="date" class="form-control" @change="ChangeDate('from')" v-model="dateFrom" :min="new Date().toLocaleDateString('fr-CA')">
            <input type="date" class="form-control" @change="ChangeDate('to')" v-model="dateTo" :min="new Date(+new Date() + 86400000).toLocaleDateString('fr-CA')">
        </div>
    </div>

    <div class="container col-md-6">
        <template v-if="hotel.rooms">
            <h6 style="text-align: center">{{ $t('PricesRooms') }}</h6>
            <div class="room-cards" id="room-cards">
                <template v-for="room in hotel.rooms">
                    <template v-if="room.count_rooms - room.booked_rooms_count > 0">
                        <div class="card mb-3" style="max-width: 540px;">
                            <div class="row g-0">
                                <template v-if="hotel.photos">
                                    <template v-for="photo in hotel.photos">
                                        <template v-if="photo.room_id == room.id">
                                            <div class="col-md-4">
                                                <img :src="photo.photo" class="img-fluid rounded-start"
                                                    :id="'photo_room_' + room.id" :alt="room.id">
                                            </div>
                                        </template>
                                    </template>
                                </template>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ room.name }}</h5>
                                        <p class="card-text">{{ room.description }}</p>
                                        <p class="card-text"><small class="text-muted">{{ $t('AmenitiesInTheRoom') }} {{ room.amenities }}</small></p>
                                        <p class="card-text">{{ $t('Price') }} {{ room.price * subtractDate }} {{ $t('For') }} {{ subtractDate }} {{ createLabel(subtractDate) }}</p>
                                        <p class="card-text">{{ $t('NumberOfBeds') }} {{ room.count_one_bed }}</p>
                                        <router-link :to="`/booking_room/${hotel.hotel.id}/${room.id}/${dateFrom}/${dateTo}`">
                                        <button class="btn btn-primary" type="button"
                                            :data-id="room.id">{{ $t('Reserve') }}</button>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
            </div>
        </template>
    </div>
</template>
</template>

<script>
import { getActiveLanguage } from 'laravel-vue-i18n'

export default {
    data() {
        return {
            dateFrom: new Date().toLocaleDateString('fr-CA'),
            dateTo: new Date(+new Date() + 86400000).toLocaleDateString('fr-CA'),
            subtractDate: 1,
        }
    },

    mounted() {
        // this.getHotel();
        this.$store.dispatch('getHotel', {id: this.$route.params.id, dateFrom: this.$route.params.dateFrom, dateTo: this.$route.params.dateTo});
    },

    methods: {
        // getHotel() {
        //     axios.get(`/api/hotel/${this.$route.params.id}/${this.$route.params.dateFrom}/${this.$route.params.dateTo}`)
        //         .then(data => {
        //             console.log(data);
        //             this.hotel = data.data.hotel;
        //             this.rooms = data.data.rooms;
        //             this.photos = data.data.photos;
        //             this.subtractDate = (new Date(this.dateTo).getTime()-new Date(this.dateFrom).getTime())/86400000;
        //         })
        //         .catch(error => { })
        // },

        ChangeDate(el) {
            if (el == 'to') {
                if (this.dateFrom >= this.dateTo) {
                    this.dateFrom = new Date(new Date(this.dateTo) - 86400000).toLocaleDateString('fr-CA');
                }
            } else {
                if (this.dateFrom >= this.dateTo) {
                    this.dateTo = new Date(+new Date(this.dateFrom) + 86400000).toLocaleDateString('fr-CA');
                }
            }
            this.subtractDate = (new Date(this.dateTo).getTime()-new Date(this.dateFrom).getTime())/86400000;
        },

        createLabel(number) {
            let locate = getActiveLanguage();

            if (locate == 'ua') {
                const cases = [2, 0, 1, 1, 1, 2];
                let titles = ['день','дня','днів'];
                return `${titles[number % 100 > 4 && number % 100 < 20 ? 2 : cases[number % 10 < 5 ? number % 10 : 5]]}`;
            } else if (locate == 'en') {
                return number == 1 ? 'day': 'days';
            }
        },

    },

    computed: {
        hotel() {
            return this.$store.getters.hotel
        }
    },
}
</script>

<style></style>