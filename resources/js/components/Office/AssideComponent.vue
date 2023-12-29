<template>
<div class="sidebar" :style="{ width: sidebarWidth }">
    <h1>
        <span v-if="collapsed">
            <div>H</div>
            <div>P</div>
        </span>
        <span v-else>Hotel Planer</span>
    </h1>

    <SidebarLincComponent to="/" icon="fas fa-home">{{ $t('Home') }}</SidebarLincComponent>
    <SidebarLincComponent v-if="!guest" to="/my_profile" icon="fas fa-user">{{ $t('MyOffice') }}</SidebarLincComponent>
    <SidebarLincComponent v-if="!guest" to="/my_hotel" icon="fas fa-bookmark">{{ $t('MyHotel') }}</SidebarLincComponent>
    <SidebarLincComponent v-if="!guest" to="/my_rooms" icon="fas fa-shop">{{ $t('MyRooms') }}</SidebarLincComponent>
    <SidebarLincComponent v-if="!guest" to="/reservations" icon="fas fa-book">{{ $t('Reservations') }}</SidebarLincComponent>

    <span class="collapse-icon"
        :class="{ 'rotate-180': collapsed }"
        @click="toggleSidebar">
        <i class="fas fa-angle-double-left"></i>
    </span>
</div>
</template>

<script>
import UserDataComponent from './UserDataComponent.vue';
import SidebarLincComponent from './SidebarLincComponent.vue';
import { collapsed, toggleSidebar, sidebarWidth } from './state'

export default {

  name: "Asside",

  data() {
    return {
    }
  },

  setup(){
    return {collapsed, toggleSidebar, sidebarWidth}
  },

  mounted() {
    this.getData();
  },

  methods: {
    getData() {
    }
  },

  computed: {
      guest() {
            return this.$store.getters.guest;
        },
    },

  components: {
    UserDataComponent,
    SidebarLincComponent,
  }
}
</script>

<style>
:root {
    --sidebar-bg-color: #03b4cf;
    --sidebar-item-hover: #2ae5fa;
    --sidebar-item-active: #2ae5fa;
}
</style>
<style scoped>
.sidebar {
    color:white;
    background-color: var(--sidebar-bg-color);

    float: left;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    bottom: 0;
    padding: 0.5em;

    transition: 0.3s ease;

    display: flex;
    flex-direction: column;
}

.sidebar h1 {
    height: 2.5em;
}
.collapse-icon {
    position: absolute;
    bottom: 0;
    padding: 0.75em;

    color: rgba(255, 255, 255, 0.7);

    transition: 0.2s linear;
}

.rotate-180 {
    transform: rotate(180deg);
    transition: 0.2s linear;
}
</style>