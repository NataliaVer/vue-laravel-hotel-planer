<template>
    <AssideComponent></AssideComponent>
    <div :style="{ 'margin-left': sidebarWidth }">
        <HeaderComponent></HeaderComponent>
        <router-view></router-view>
        <FooterComponent></FooterComponent>
    </div>
</template>

<script>
import HeaderComponent from './includes/HeaderComponent.vue';
import FooterComponent from './includes/FooterComponent.vue';
import AssideComponent from './Office/AssideComponent.vue';
import { sidebarWidth, collapsed, toggleSidebar } from './Office/state';
import { getActiveLanguage } from 'laravel-vue-i18n';
import axios from 'axios';

export default {

    data() {
    return {
      langs: null,
    };
  },

    setup() {
        return { sidebarWidth, collapsed }
    },

    mounted() {
        if(collapsed) {
            toggleSidebar();
        }
        this.getLangs();
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
            this.$swal({
                position: 'top-end',
                icon: 'success',
                title: this.$t('SentTheLetter'),
                text: this.$t('CheckYourEmail'),
                showConfirmButton: false,
                timer: 3000
            });
        },

        YourPasswordHasBeenReset() {
            this.$swal(
                this.$t('OK'),
                this.$t('YourPasswordHasBeenReset'),
                'success'
            );
        },

        YourDataHasBeenReset() {
            this.$swal(
                this.$t('OK'),
                this.$t('YourDataHasBeenReset'),
                'success'
            );
        },

        DoYouWantChangePass(email) {
            this.$swal({
                title: this.$t('DoYouWantChangePass'),
                text: this.$t('WeSendTheLetter'),
                showCancelButton: true,
                cancelButtonText: this.$t('Close'),
                confirmButtonText: this.$t('SendTheLetterOnEmail'),
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('/api/forgot-password', { email: email })
                        .then(res => {
                            this.OnYourEmailSendTheLetter();
                            return null;
                        })
                        .catch(error => {
                            return error.response.data.errors;
                        });
                } else {
                    return null;
                }
            });
        },

        translater(id, table, translated) {
            if(table == 'h') {
                axios.get(`/api/translate_hotel/${id}/${getActiveLanguage()}`)
                .then(res => {
                    // console.log(res.data.name);
                    translated = res.data.name;
                    // return res.data.name;
                })
                .catch(err => {
                    console.log(err);
                })
            }
            // return getActiveLanguage() + ' ' + id + ' ' + table;
        },

        getLangs(){
            axios.get('/api/all_languages')
            .then(res => {
              this.langs = res.data;
            })
        },

        langId() {
            if(this.langs){
            this.langs.forEach(lang => {
                if(lang.code == getActiveLanguage()) {
                    console.log(lang);
                    // return lang.id;
                }
            });
        }
        },

    },

    components: {
        HeaderComponent,
        FooterComponent,
        AssideComponent,
    }
}
</script>