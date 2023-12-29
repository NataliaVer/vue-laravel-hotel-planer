<template>
    <div class="container text-center col-sm-4">
    
    <main class="form-signin">
        <h1 class="h3 mb-3 fw-normal mt-3">{{ $t('SignIn') }}</h1>
    
        <div class="form-floating mb-3">
          <input name="email" type="email" class="form-control" id="floatingInput" v-model="email" placeholder="name@example.com">
          <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
          <input name="password" type="password" class="form-control" v-model="password" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">{{ $t('Pass') }}</label>
        </div>
    
        <div class="checkbox mb-3">
        </div>
        <button @click.prevent="SignIn()" class="w-100 btn btn-lg btn-primary" type="submit">{{ $t('SignIn') }}</button>
        <p class="mt-5 mb-3 text-muted">{{ $t('DontHaveAccount') }} <router-link to="/signup">{{ $t('SignUpHere') }}</router-link></p>
        <p class="mt-5 mb-3 text-muted"><router-link to="/forgotpass">{{ $t('ForgotYourPassword') }}</router-link></p>
        
    </main>
    
    <template v-if="errors">
        <div class="alert alert-danger">
            <ul>
              <template v-for="error in errors">
                <li>{{ $t(error[0]) }}</li>
              </template>
            </ul>
        </div>
    </template>
    
    </div>
</template>

<script>

export default {

  data() {
    return {
      email: null,
      password: null,
      errors: null,
      isGuest: null,
    }
  },

  mounted() {
      // this.$store.dispatch('getUser');
    },

  methods: {
    SignIn() {
      this.errors = null;
      axios.post('/login', {
        email: this.email,
        password: this.password
      })
      .then(res => {
        localStorage.setItem('guest', '');
        this.$store.dispatch('getIsGuest');
        this.$router.push('/');
        // this.$store.dispatch('getIsGuest');
        // console.log(this.$store.getters.guest);
      })
      .catch(error => {
        // console.log(error.response.data.errors);
        this.errors = error.response.data.errors;
      });
    },
  },

  // computed: {
  //     user() {
  //           return this.$store.getters.user;
  //       }
  //   },

}
</script>

<style></style>