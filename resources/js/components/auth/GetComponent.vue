<template>
    <div>
        Get       
    </div>
</template>

<script>
import axios from 'axios';


export default {

  name: "Get",

  data() {
    return {
    }
  },

  mounted() {
    this.getData();
  },

  methods: {
    getData() {
      axios.get('/api/get')
      .then( res => {
        console.log(res);
      })
    }
  }
}
</script>