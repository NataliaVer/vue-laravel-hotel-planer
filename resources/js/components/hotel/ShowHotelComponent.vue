<template>
    <template v-if="hotel">
        <div class="container mt-3">
            <template v-if="hotel.photos">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-controls">
                            <div class="carousel-indicators">
                                <template v-for="photo, index in hotel.photos">
                                <template v-if="photo.kind_photo == 'all_photos'">
                                <button type="button" data-bs-target="#carouselExample" :data-bs-slide-to="index-1" :class="index === 1 ? 'li active': 'li'"
                                    aria-current="true" :aria-label="'Slide '+index" :style="'background-image: url('+photo.photo+')'"></button>
                                </template>
                                </template>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="prev">
                                <img src="/img/left-arrow.svg" alt="Prev">
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                                data-bs-slide="next">
                                <img src="/img/right-arrow.svg" alt="Next">
                            </button>
                        </div>
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

                    </div>
            </template>
        </div>

        <div class="container pt-3 col-md-7">
            <template v-if="hotel.hotel_translations">
                <template v-for="hotel_translate in hotel.hotel_translations">
                    <template v-if="langName() == hotel_translate.lang_code">
                <div class="card text-center">
                    <div class="card-header">
                        {{ hotel_translate.hotel_name }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ hotel_translate.city }}, {{ hotel_translate.settlement }}, {{ hotel_translate.street
                        }}, {{
    hotel_translate.number_house }}</h5>
                        <p class="card-text">{{ hotel_translate.description }}</p>
                        <p class="card-text">{{ $t('AdditionalServices') }} {{ hotel_translate.aditional_services }}</p>
                        <p class="card-text">{{ $t('Check-inTime') }} {{ hotel_translate.time_of_settlement }} {{
                            $t('EvictionTime') }} {{ hotel_translate.time_of_eviction }}</p>
                    </div>
                    <div class="card-footer text-muted">
                        {{ $t('CallUs') }} {{ hotel_translate.phone }}
                    </div>
                </div>
            </template>
                </template>
            </template>
        </div>

        <div class="container alert alert-info col-md-6 my-3" role="alert">
            <div class="input-group">
                <!-- <div class="input-group-prepend"> -->
                    <span class="input-group-text col-md-4">{{ $t('SelectDate') }}</span>
                <!-- </div> -->
                <input type="date" class="form-control" @change="ChangeDate('from')" v-model="dateFrom"
                    :min="new Date().toLocaleDateString('fr-CA')">
                <input type="date" class="form-control" @change="ChangeDate('to')" v-model="dateTo"
                    :min="new Date(+new Date() + 86400000).toLocaleDateString('fr-CA')">
            </div>
        </div>

        <div class="container col-md-6">
            <template v-if="hotel.rooms">
                <h4 class="my-3" style="text-align: center">{{ $t('PricesRooms') }}</h4>
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
                                    <template v-for="room_translate in room.translations">
                                <template v-if="langName() == room_translate.lang_code">
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ room_translate.name }}</h5>
                                            <p class="card-text">{{ room_translate.description }}</p>
                                            <p class="card-text"><small class="text-muted">{{ $t('AmenitiesInTheRoom') }} {{
                                                room_translate.amenities }}</small></p>
                                            <p class="card-text">{{ $t('Price') }} {{ room_translate.price * subtractDate }} {{
                                                $t('For') }} {{ subtractDate }} {{ createLabel(subtractDate) }}</p>
                                            <p class="card-text">{{ $t('NumberOfBeds') }} {{ room_translate.count_one_bed }}</p>
                                            <router-link
                                                :to="`/booking_room/${hotel.hotel.id}/${room.id}/${dateFrom}/${dateTo}`">
                                                <button class="btn btn-primary" type="button" :data-id="room.id">{{
                                                    $t('Reserve') }}</button>
                                            </router-link>
                                        </div>
                                    </div>
                                </template>
                            </template>
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
        // console.log(this.$parent.$parent.langs);
        this.translate();
        this.$store.dispatch('getHotel', { id: this.$route.params.id, dateFrom: this.$route.params.dateFrom, dateTo: this.$route.params.dateTo });
    },

    methods: {

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
            this.subtractDate = (new Date(this.dateTo).getTime() - new Date(this.dateFrom).getTime()) / 86400000;
        },

        createLabel(number) {
            let locate = getActiveLanguage();

            if (locate == 'ua') {
                const cases = [2, 0, 1, 1, 1, 2];
                let titles = ['день', 'дня', 'днів'];
                return `${titles[number % 100 > 4 && number % 100 < 20 ? 2 : cases[number % 10 < 5 ? number % 10 : 5]]}`;
            } else if (locate == 'en') {
                return number == 1 ? 'day' : 'days';
            }
        },

        langName() {
            return getActiveLanguage();
        },

        translate() {
            console.log(this.hotel.rooms);
            // this.hotel.translations.forEach(translation => {
            //     if(translation.language_id === getActiveLanguage()){
            //         console.log(translation);
            // //         // console.log(translation);
            // //         // return translation;
            //     }
            // });
            // return true;
        },

    },

    computed: {
        hotel() {
            return this.$store.getters.hotel
        }
    },
}
</script>

<style>
.carousel .carousel-item {
    min-height: 50vh;
    background-position: center;
    background-size: cover;
    position: relative;
    z-index: 1;
    /* max-height: 600px;
  max-width: 600px; */
}

.carousel .carousel-item:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.carousel-item img {
    /* max-height: 600px; */
    max-width: 1000px;
    background-position: center;
    background-size: cover;
}

.carousel .carousel-controls {
    position: absolute;
    left: 50%;
    bottom: 40px;
    z-index: 10;
    transform: translateX(-50%);
}

.carousel .carousel-indicators{
    position: relative;
    margin: 0;
}

.carousel .carousel-indicators .li{
    height: 70px;
    width: 70px;
    margin: 0 5px;
    border-radius: 50%;
    background-position: center;
    background-size: cover;
    border: 3px solid transparent;
    transition: all 0.3s linear;
}

.carousel .carousel-indicators .li.active{
    border-color: #ffffff;
    transform: scale(1.2);
}

.carousel .carousel-control-next,
.carousel .carousel-control-prev{
    height: 60px;
    width: 60px;
    opacity: 1;
    z-index: 3;
    top: 50%;
    transform:translateY(-50%);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.carousel .carousel-control-next:hover,
.carousel .carousel-control-prev:hover{
    box-shadow: 0 0 10px #ffffff;
}

.carousel .carousel-control-next img,
.carousel .carousel-control-prev img{
    width: 30px;
}

.carousel .carousel-control-next{
    right:-90px;
}

.carousel .carousel-control-prev{
    left: -90px;
}

/*responsive*/
@media(max-width: 767px){
    .carousel .carousel-control-next,
    .carousel .carousel-control-prev{
        display: none;
    }

    .carousel .carousel-indicators .li{
        height: 40px;
        width: 40px;
    }

    .carousel-item img {
        max-width: 600px;
    }
}
</style>