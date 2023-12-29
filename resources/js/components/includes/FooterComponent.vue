<template>
    <div class="container border-top">
  <footer class="py-5">
    <div class="row">
      <div class="col-6 col-md-3 mb-3">
        <h5>{{ $t('Contacts') }}</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2">{{ $t('ContactEmail') }}</li>
          <li class="nav-item mb-2">test-test01@gmail.com</li>
        </ul>
      </div>

      <div class="col-6 col-md-2 mb-3">
        <h5>{{ $t('Phone') }}</h5>
        <ul class="nav flex-column">
          <li class="nav-item mb-2">+38(095)-00-00-000</li>
          <li class="nav-item mb-2">+38(096)-00-00-000</li>
        </ul>
      </div>

      <div class="col-md-5 offset-md-1 mb-3">
        <form>
          <h5>{{ $t('TestProject') }}</h5>
          <p>{{ $t('FoterText') }}</p>
          <!-- <div class="d-flex flex-column flex-sm-row w-100 gap-2">
            <a href="#" class="nav-link px-2 text-muted">API</a>
          </div> -->
        </form>
      </div>
    </div>
    </footer>
    </div>
</template>

<script>
export default {
  name: "FooterComponent"
}
</script>