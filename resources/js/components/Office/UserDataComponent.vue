<template>
  <template v-if="user">
    <div>
      <h6 class="mt-3">{{ $t('Hello') }}, {{ user.name }}! {{ $t('OfficeDescription') }}.</h6>

      <div class="table-responsive table-lg mt-3">
        <table class="table table-bordered" id="users-table">
          <thead>
            <tr>
              <th>{{ $t('Title') }}</th>
              <th>{{ $t('Rules') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-nowrap align-middle">{{ $t('Phone') }}</td>
              <td v-if="!change" class="text-nowrap align-middle">{{ phone }}</td>
              <td v-if="change" class="text-nowrap align-middle">
                <input type="text" v-model="phone" class="form-control">
              </td>
            </tr>
            <tr>
              <td class="text-nowrap align-middle">{{ $t('Email') }}</td>
              <td v-if="!change" class="text-nowrap align-middle">{{ email }}</td>
              <td v-if="change" class="text-nowrap align-middle">
                <input type="email" v-model="email" class="form-control">
              </td>
            </tr>
          </tbody>
        </table>

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
      <button v-if="!change" type="button" class="btn btn-primary m-2" @click="changeData(true)">{{ $t('ChangeData')
      }}</button>
      <button v-if="!change" type="button" class="btn btn-info" @click="changePassword()">{{ $t('ChangePass') }}</button>
      <button v-if="change" type="button" class="btn btn-primary m-2" @click="sentData()">{{ $t('Send') }}</button>
      <button v-if="change" type="button" class="btn btn-secondary" @click="changeData(false)">{{ $t('Close') }}</button>
    </div>
  </template>
</template>
  
<script>
import axios from 'axios';


export default {

  name: "UserData",

  data() {
    return {
      user: null,
      change: null,
      phone: null,
      email: null,
      errors: null,
    }
  },

  mounted() {
    // console.log('UserDataComponent');
    this.getUser();
  },

  methods: {
    getUser() {
      axios.get('/api/getUser')
        .then(res => {
          // console.log(res.data);
          this.user = res.data;
          this.phone = res.data.phone;
          this.email = res.data.email;
        })
        .catch(err => { })
    },

    changeData(change) {
      this.change = change;
      this.errors = null;
    },

    sentData() {
      this.errors = null;
      axios.put(`/api/updateUser`, {
        email: this.email,
        phone: this.phone
      })
        .then(res => {
          console.log(res.data);
          this.change = false;
          this.getUser();
          this.$parent.$parent.YourDataHasBeenReset();
        })
        .catch(err => {
          this.errors = err.response.data.errors;
        })
    },

    changePassword() {
      this.errors = this.$parent.$parent.DoYouWantChangePass(this.email);
    },
  },
}
</script>