<template>
        <router-view></router-view>
</template>

<script>
export default {

    mounted() {
    },

    methods: {
        AddReservationSaccess() {
            this.$swal(
                this.$t('AddReservation'),
                this.$t('AddReservationText'),
                'success'
            );
        },

        OnYourEmailSendTheLetter() {
            this.$swal(
                this.$t('SentTheLetter'),
                this.$t('CheckYourEmail'),
                'success'
            );
        },

        YourPasswordHasBeenReset() {
            this.$swal(
                this.$t('OK'),
                this.$t('YourPasswordHasBeenReset'),
                'success'
            );
        },
 
    },
}
</script>