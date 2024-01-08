<template>
  <header
    class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom">

    <ul class="nav mb-2 mb-md-0">
      <router-link to="/" class="nav-link px-2 link-secondary">{{ $t('Home') }}</router-link>
    </ul>

    <div class="col-md-auto">

      <!-- <template v-if="user">USER</template> -->
      <template v-if="guest">
        <router-link to="/signup"><button class="btn btn-outline-primary me-2">{{ $t('SignUp') }}</button></router-link>
        <router-link to="/signin"><button class="btn btn-primary me-2">{{ $t('Login') }}</button></router-link>
        <!-- <router-link v-if="token" to="/signin"><button class="btn btn-primary me-2">{{ $t('YourOffice') }}</button></router-link> -->
      </template>
      <template v-else>
        <router-link to="/my_profile" class="btn btn-primary me-2">{{ $t('MyOffice') }}</router-link>
        <a class="btn btn-primary me-2" @click.prevent="Logout()" href="#">{{ $t('Logout') }}</a>
      </template>

      <!-- <a class="btn btn-primary me-2" @click.prevent="isGuestNow()" href="#">{{ $t('isGuest') }}</a> -->

    </div>

    <!-- Locale Selector -->
    <div class="dropdown col-md-auto px-2" v-if="languages">
    <a class="btn btn-light dropdown-toggle" href="#" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ language }}</a>
    <ul class="dropdown-menu">
      <template v-for="lang in languages">
        <li><a class="dropdown-item" href="#" @click.prevent="switchLanguageTo(lang.code)"><img :src="`https://flagsapi.com/${flagName(lang.code)}/flat/32.png`" alt=""> {{ lang.name}}</a></li>
      </template>
    </ul>
</div>
  </header>
</template>
<!-- <li><a class="dropdown-item" href="#" @click.prevent="switchLanguageTo('ua')"><img src="https://flagsapi.com/UA/flat/32.png" alt=""> Ukrainian</a></li> -->

<script>
import axios from 'axios';
import { loadLanguageAsync, getActiveLanguage } from 'laravel-vue-i18n';
import {setCity} from '../home/valuecity.js';

export default {

  // props: ['user'],

  data() {
    return {
      language: getActiveLanguage(),
      languages: null,
    };
  },

  mounted() {
      this.getListOfLanguage();
    },

  methods: {
    switchLanguageTo(language) {
      this.language = language;
      loadLanguageAsync(this.language);
      this.translateCity(localStorage.getItem('city'));
    },
    Logout() {
      axios.post('/logout')
      .then(res => {
        localStorage.setItem('guest', 1);
        this.$store.dispatch('getIsGuest');
        this.$router.go('/signin');
        
      })
    },

    getListOfLanguage() {
      axios.get('/api/all_languages')
      .then(res => {
        this.languages = res.data;
        // console.log(res.data);
      })
    },

    flagName(lang) {
      return lang == 'en' ? 'US' : lang.toUpperCase();
    },

    translateCity(city) {
      if (city) {
        axios.get(`/api/translateCity/${this.language}/${city}`)
        .then(res => {
          setCity(res.data);
        })
      }
    },
  },

  computed: {
      guest() {
            return this.$store.getters.guest;
        },
    },
    
}
</script>

<style>

</style>