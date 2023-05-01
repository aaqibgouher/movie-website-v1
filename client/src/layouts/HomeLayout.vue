<template>
    <v-layout>
        <navbar-component></navbar-component>
        <v-main>
            <router-view />
        </v-main>
    </v-layout>
</template>
  
<script>
import NavbarComponent from '@/components/NavbarComponent.vue'

export default {
    name: "HomeLayout",
    components: {
        NavbarComponent
    },
    data() {
        return {
        }
    }
};
</script>

<style>
.sticky {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
}

.overflow-y-auto {
    overflow-y: auto;
}
</style>
  