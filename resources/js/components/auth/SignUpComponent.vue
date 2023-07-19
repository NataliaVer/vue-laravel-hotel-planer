<template>
    <div class="container text-center col-sm-4">
    
    <main class="form-signin">
      <form method="POST">
        <h1 class="h3 mb-3 fw-normal mt-3">SingUp</h1>
    
        <div class="form-floating mb-3">
          <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Email</label>
        </div>
        <div class="form-floating">
          <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Пароль</label>
        </div>
    
        <div class="checkbox mb-3">
          <!-- <label>
            <input type="checkbox" value="remember-me"> Запам'ятати мене
          </label> -->
        </div>
        <button @click.prevent="SignIn()" class="w-100 btn btn-lg btn-primary" type="submit">Увійти</button>
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
  methods: {
    SignIn() {
      axios.post()
      .then(res => {})
      .catch(error => {})
    },
  }
}
</script>