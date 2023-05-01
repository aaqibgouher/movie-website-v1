<template>
    <v-container>
        <v-row>
            <v-col cols="12" md="12">
                <detail-component></detail-component>
            </v-col>
        </v-row>
        <br>
        <v-divider></v-divider>
        <h1 style="margin-top: 2rem;">Similar Movies</h1>
    </v-container>
    <similar-component></similar-component>
</template>
  
<script>
import CardComponent from '@/components/CardComponent.vue';
import DetailComponent from '@/components/DetailComponent.vue';
import SimilarComponent from '@/components/SimilarComponent.vue'

export default {
    components: {
        CardComponent,
        DetailComponent,
        SimilarComponent
    },
    data() {
        return {
            show: false,
            loaded: false,
            loading: false,
        };
    },
    methods: {
        onClick() {
            this.loading = true

            setTimeout(() => {
                this.loading = false
                this.loaded = true
            }, 2000)
        },
    },
}
</script>
  
<style scoped>
.overflow-auto {
    overflow-y: auto;
}
</style>
  