<template>
  <header
    class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom">

    <ul class="nav mb-2 mb-md-0">
      <router-link to="/" class="nav-link px-2 link-secondary">{{ $t('Home') }}</router-link>
    </ul>

    <div class="col-md-auto">

      <template v-if="!isGuest">
        <router-link to="/signup"><button class="btn btn-outline-primary me-2">{{ $t('SignUp') }}</button></router-link>
        <router-link to="/signin"><button class="btn btn-primary">{{ $t('Login') }}</button></router-link>
      </template>
      <template v-else>
        <a class="btn btn-primary" href="#">{{ $t('Name') }}</a>
        <a class="btn btn-primary" href="#">{{ $t('Logout') }}</a>
      </template>

    </div>

    <!-- Locale Selector -->
    <div class="dropdown col-md-auto px-2">
    <a class="btn btn-light dropdown-toggle" href="#" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ language }}</a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="#" @click.prevent="switchLanguageTo('en')"><img src="https://flagsapi.com/US/flat/32.png" alt=""> English</a></li>
        <li><a class="dropdown-item" href="#" @click.prevent="switchLanguageTo('ua')"><img src="https://flagsapi.com/UA/flat/32.png" alt=""> Ukrainian</a></li>
    </ul>
</div>
  </header>
</template>

<script>
import { loadLanguageAsync } from 'laravel-vue-i18n';

export default {
  props: [
    'isGuest'
  ],

  data() {
    return {
      language: 'en',
    };
  },

  mounted() {
    console.log();
  },

  methods: {
    switchLanguageTo(language) {
      this.language = language;
      loadLanguageAsync(this.language);
    }
  }
}
</script>

<style>

</style>