<template>
        <router-view></router-view>
</template>

<script>
export default {
    mounted() {
        // console.log('App component.')
    },

    methods: {
        AddReservationSaccess() {
            this.$swal(
                this.$t('AddReservation'),
                this.$t('AddReservationText'),
                'success'
            );
        },
    },
}
</script>