<template>
    <div class="container text-center col-sm-4">
    
    <main class="form-signin">
      <form method="POST">
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
          <!-- <label>
            <input type="checkbox" value="remember-me"> Запам'ятати мене
          </label> -->
        </div>
        <button @click.prevent="SignIn()" class="w-100 btn btn-lg btn-primary" type="submit">{{ $t('SignIn') }}</button>
        <p class="mt-5 mb-3 text-muted"></p>
      </form>
    </main>
    
    <!-- <template>
        <div class="alert alert-danger">
            <ul>
                <template>
                    <li>{{ $error }}</li>
                </template>
            </ul>
        </div>
    </template> -->
    
    </div>
</template>

<script>

export default {

  data() {
    return {
      email: null,
      password: null,
      errors: null,
    }
  },

  methods: {
    SignIn() {
      axios.post('/api/signin/login', {email: this.email, password: this.password})
      .then(res => {
        console.log(res.data);
      })
      .catch(error => {
        console.log(error);
      })
    },
  }
}
</script>