<template>
    <div class="position-relative">
        <h1 class="display-4 fw-bolder fst-italic">{{ $t('Welcome') }}</h1>
        <img src="/img/border_view.jpg" alt="...">
    </div>

    <div class="container">
        <form method="post" class="row">
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
        </form>

        <template v-if="hotels">
            <div class="my-3">
                <template v-for="hotel in hotels">
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
                                            <h5 class="card-title">{{ hotel.hotel_name }}</h5>
                                        </router-link>
                                        <p class="card-text"><small class="text-muted">{{ hotel.city }},
                                                {{ hotel.settlement }}</small></p>
                                        <p class="card-text">{{ hotel.description }}</p>
                                        <p class="card-text"><small class="text-muted">{{ hotel.aditional_services }}</small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </template>
    </div>
</template>

<script>

export default {

    data() {
        return {
            city: null,
            dateFromHome: new Date().toLocaleDateString('fr-CA'),
            dateToHome: new Date(+new Date() + 86400000).toLocaleDateString('fr-CA'),
            cities: null,
            hotels: null,
        }
    },

    mounted() {
        console.log('Component mounted.')
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
            this.cities = null;
            axios.get('/api/searchCity', { nameCity: this.city })
                .then(res => {
                    this.cities = res.data.cities;
                })
                .catch(error => { })
        },

        searchHotels() {
            this.hotels = null;
            axios.post('/api/searchHotels', {nameCity: this.city, dateFrom: this.dateFromHome, dateTo: this.dateToHome})
                .then(res => {
                    this.hotels = res.data.hotels;
                    console.log(res);
                })
                .catch(error => {
                    console.log(error.response.data.message);
                })
        },
    },

    components: {
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
    top: 30%;
    left: 25%;
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
