<template>
  <v-app>
    <SnackbarComponent />
    <router-view />
  </v-app>
</template>

<script>
import SnackbarComponent from './components/SnackbarComponent.vue';

export default {
  name: "App",
  components: {
    SnackbarComponent
  },
  data() {
    return {

    }
  },
  methods: {

  }
};
</script>
