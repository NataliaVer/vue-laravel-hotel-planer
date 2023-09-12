<template>
  <template v-if="!hideFields">
    <div class="container text-center col-sm-4">
    
    <main class="form-fogotpass">
        <h1 class="h3 mb-3 fw-normal mt-3">{{ $t('FogotPassword') }}</h1>
    
        <div class="form-floating mb-3">
          <input name="email" type="email" class="form-control" id="floatingInput" v-model="email" placeholder="name@example.com">
          <label for="floatingInput">Email</label>
        </div>
    
        <div class="mb-3">
        </div>
        <button @click.prevent="FogotPassword()" class="w-100 btn btn-lg btn-primary" type="submit">{{ $t('ResetPassword') }}</button>
        <p class="mt-5 mb-3 text-muted">{{ $t('DidYouRememberPass') }} <router-link to="/signin">{{ $t('SignInHere') }}</router-link></p>
        
    </main>
    
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
  <template v-else>
    <div class="container text-center col-sm-4">
      <h3 class="mt-5">{{ $t('SentTheLetter') }}</h3>
      <p class="mt-3">{{ $t('DontGetTheLetter') }}</p>
    </div>
  </template>
</template>

<script>
import axios from 'axios';


export default {

  data() {
    return {
      email: null,
      errors: null,
      hideFields: false,
    }
  },

  methods: {
    FogotPassword() {
      this.errors = null;
      axios.post('/api/forgot-password',{email: this.email})
      .then(res => {
        this.hideFields = true;
        // console.log(res.data.status);
        // this.$parent.$parent.OnYourEmailSendTheLetter();
      })
      .catch(error => {
        this.hideFields = false;
        console.log(error);
        this.errors = error.response.data.errors;
      });
        console.log('forgot password');
    },
  }
}
</script>

<style></style>