<template>
    My office
</template>

<script>

export default {

  name: "Profile",

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