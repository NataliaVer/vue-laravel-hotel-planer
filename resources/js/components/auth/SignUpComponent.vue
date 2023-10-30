<template>
  <div class="container text-center col-sm-4">

    <main class="form-signin">
      <form method="POST">
        <h1 class="h3 mb-3 fw-normal mt-3">{{ $t('SignUp') }}</h1>

        <div class="form-floating mb-3">
          <input name="name" type="name" class="form-control" id="floatingName" placeholder="name" v-model="name">
          <label for="floatingName">{{ $t('Name') }}</label>
        </div>
        <div class="form-floating mb-3">
          <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
            v-model="email">
          <label for="floatingInput">Email</label>
        </div>
        <!-- <div class="form-floating mb-3">
          <input name="phone" type="phone" class="form-control" id="floatingPhone" placeholder="+380111111111"
            v-model="phone">
          <label for="floatingPhone">{{ $t('Phone') }}</label>
        </div> -->
        <div class="form-floating mb-3">
          <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password"
            v-model="password">
          <label for="floatingPassword">{{ $t('Pass') }}</label>
        </div>
        <div class="form-floating mb-3">
          <input name="password_confirmation" type="password" class="form-control" id="floatingPasswordConfirm"
            placeholder="Password confirmation" v-model="password_confirmation">
          <label for="floatingPasswordConfirm">{{ $t('PassConfirm') }}</label>
        </div>

        <div class="checkbox mb-3">
        </div>
        <button @click.prevent="Register()" class="w-100 btn btn-lg btn-primary" type="submit">{{ $t('Registr')
        }}</button>
        <p class="mt-5 mb-3 text-muted"><router-link to="/signin">{{ $t('SignIn') }}</router-link></p>
      </form>
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
      name: null,
      email: null,
      // phone: null,
      password: null,
      password_confirmation: null,
      errors: null,
    }
  },

  methods: {
    Register() {
      this.errors = null;
      // axios.get('/sanctum/csrf-cookie')
      //   .then(response => {
          axios.post('/register', {
            name: this.name,
            email: this.email,
            // phone: this.phone,
            password: this.password,
            password_confirmation: this.password_confirmation
          })
            .then(res => {
              // console.log(res);
              this.$router.push('/');
            })
            .catch(error => { 
              console.log(error.response.data.errors);
              this.errors = error.response.data.errors;
            });
        // });
    },
  }
}
</script>