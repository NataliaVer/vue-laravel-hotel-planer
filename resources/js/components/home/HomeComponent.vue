<template>
    <div class="position-relative">
        <h1 class="display-4 fw-bolder fst-italic">{{ $t('Welcome') }}</h1>
        <img src="/img/border_view.jpg" alt="...">
    </div>

    <div class="container mb-2">
        <template class="row">
            <div class="row wrapper">
                <div class="form-group col-md-4 my-2">
                    <input type="text" class="form-control" v-model="city" @input="searchCity()" list="CityList"
                        autocomplete="off" :placeholder="$t('CityOrSettlement')">
                    <datalist id="CityList">
                        <template v-if="cities">
                            <template v-for="settlement in cities">
                                <option :value="settlement.settlement">{{ settlement.settlement }}</option>
                            </template>
                        </template>
                    </datalist>
                </div>
                <div class="form-group col-md-3 my-2">
                    <div class="input-group">
                        <span class="input-group-text" id="dateFromHome">{{ $t('CheckIn') }}</span>
                        <input type="date" class="form-control" v-model="dateFromHome" aria-describedby="dateFromHome"
                            :min="new Date().toLocaleDateString('fr-CA')" @change="ChangeDate('from')">
                    </div>
                </div>
                <div class="form-group col-md-3 my-2">
                    <div class="input-group">
                        <span class="input-group-text" id="dateToHome">{{ $t('CheckOut') }}</span>
                        <input type="date" class="form-control" v-model="dateToHome" aria-describedby="dateToHome"
                            :min="new Date(+new Date() + 86400000).toLocaleDateString('fr-CA')" @change="ChangeDate('to')">
                    </div>
                </div>
                <div class="form-group col-md-2" style="display: none;">
                    <label for="count_adult">Дорослих</label>
                    <input type="number" class="form-control" id="count_adult">
                </div>
                <div class="form-group col-md-2" style="display: none;">
                    <label for="count_children">Дітей</label>
                    <input type="number" class="form-control" id="count_children">
                </div>
                <div class="form-group col-md-2 my-2">
                    <!-- <button class="w-100 btn btn-primary" type="button" id="searchHotels">{{ $t('Find') }}</button> -->
                    <a href="#" class="w-100 btn btn-primary" @click.prevent="searchHotels()">{{ $t('Find') }}</a>
                </div>
            </div>
        </template>

        <template v-if="hotels && hotels.data.length > 0">
            <div class="my-3">
                <template v-for="hotel in hotels.data">
                    <div>
                        <div class="card mb-3" style="max-width: 640px;">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <router-link :to="`/hotel/${hotel.hotel_id}/${dateFromHome}/${dateToHome}`"><img :src="hotel.photo" class="img-fluid rounded-start"
                                            alt="..."></router-link>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <router-link :to="`/hotel/${hotel.hotel_id}/${dateFromHome}/${dateToHome}`">
                                            <h5 class="card-title">{{ hotel[translate('hotel_name')] }}</h5>
                                        </router-link>
                                        <p class="card-text"><small class="text-muted">{{ hotel[translate('city')] }},
                                                {{ hotel[translate('settlement')] }}, {{ hotel[translate('street')] }}, {{ hotel[translate('number_house')] }}</small></p>
                                        <p class="card-text">{{ cutDown(hotel[translate('description')], 100) }}</p>
                                        <p class="card-text"><small class="text-muted">{{ cutDown(hotel[translate('aditional_services')], 50) }}</small>
                                            <!-- Add the ability to change currency -->
                                        <p class="card-text">{{$t('MinPrice')}}: {{ countDays() * hotel.min_price }}</p>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <Bootstrap5Pagination showDisabled align="center" :data="hotels" @pagination-change-page="listOfHotels"></Bootstrap5Pagination>
        </template>

        <template v-if="errors">
            <div class="alert alert-danger mt-3">
            <ul>
                <li>{{ $t(errors) }}</li>
            </ul>
        </div>
        </template>
        
    </div>
</template>

<script>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import { getActiveLanguage } from 'laravel-vue-i18n';

export default {

    data() {
        return {
            city: null,
            dateFromHome: new Date().toLocaleDateString('fr-CA'),
            dateToHome: new Date(+new Date() + 86400000).toLocaleDateString('fr-CA'),
            cities: null,
            hotels: null,
            errors: null,
            results: null,
        }
    },

    setup() {
    },

    mounted() {
        // this.translater(2);
        // console.log(this.translater(2));
    },

    methods: {
        ChangeDate(el) {
            if (el == 'to') {
                if (this.dateFromHome >= this.dateToHome) {
                    this.dateFromHome = new Date(new Date(this.dateToHome) - 86400000).toLocaleDateString('fr-CA');
                }
            } else {
                if (this.dateFromHome >= this.dateToHome) {
                    this.dateToHome = new Date(+new Date(this.dateFromHome) + 86400000).toLocaleDateString('fr-CA');
                }
            }
        },

        searchCity() {
            this.errors = null;
            this.cities = null;
            axios.get(`/api/searchCity?nameCity=${this.city}&lang=${getActiveLanguage()}`)
                .then(res => {
                    this.cities = res.data.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },

        searchHotels() {
            this.errors = null;
            this.hotels = null;
            axios.post('/api/searchHotels', {nameCity: this.city, dateFrom: this.dateFromHome, dateTo: this.dateToHome, lang: getActiveLanguage()})
                .then(res => {
                    if(res.data.status){
                        console.log(res.data);
                        this.hotels = res.data.hotels;
                    }
                    console.log(res);
                    this.errors = res.data.message;
                    // console.log(res);
                })
                .catch(error => {
                    this.errors = error.response.data.message;
                    // console.log(error.response.data.message);
                })
        },

        countDays() {
            return new Date(this.dateToHome).getDate()-new Date(this.dateFromHome).getDate();
        },

         cutDown(content, len){
            if(content.length > len) {
                return content.slice(0, len) + '...';
            }
            return content;
         },

         listOfHotels(page=1) {
            axios.post(`/api/searchHotels?page=${page}`, {nameCity: this.city, dateFrom: this.dateFromHome, dateTo: this.dateToHome, lang: getActiveLanguage()})
            .then(res  => {
                // console.log(res);
                this.hotels = res.data.hotels;
            })
         },

         translate(name) {
                return `${name}_${getActiveLanguage()}`
            },
    },

    components: {
        Bootstrap5Pagination
    },
}
</script>

<style>
.position-relative {
    margin: 0px auto 30px auto;
    position: relative;
    max-height: 500px;
    overflow: hidden;
}

.position-relative img {
    display: inline-block;
    width: 100%;
    height: auto;
    object-fit: cover;

}

.fst-italic {
    position: absolute;
    font-style: italic !important;
    color: lightcyan;
    top: 50%;
    left: 50%;
    transform:translate(-50%,-50%);
    text-align:center;
}

.user-hotel-form {

    margin: auto;
}

.wrapper {
    padding: 12px 0;
    border-radius: 4px;
    background-color: #93C9EB;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    margin: auto;
}</style>
