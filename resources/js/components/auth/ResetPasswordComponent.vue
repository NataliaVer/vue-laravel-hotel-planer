<template>
    <div class="container text-center col-sm-4">
    
    <main class="form-fogotpass mt-5">
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
        <button @click.prevent="ResetPassword()" class="w-100 btn btn-lg btn-primary" type="submit">{{ $t('ResetPassword') }}</button>
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

<script>

export default {

  data() {
    return {
      password: null,
      password_confirmation: null,
      email: null,
      token: null,
      errors: null,
    }
  },

  methods: {
    ResetPassword() {
      this.errors = null;
      axios.post('/api/reset-password',{
        password: this.password,
        password_confirmation: this.password_confirmation,
        email: this.$route.query.email,
        token: this.$route.params.token
    })
      .then(res => {
        console.log(res);
        this.$parent.$parent.YourPasswordHasBeenReset();
        this.$router.push('/signin');
      })
      .catch(error => {
        console.log(error);
        this.errors = error.response.data.errors;
      });
        console.log('new password');
    },
  }
}
</script>

<style></style>