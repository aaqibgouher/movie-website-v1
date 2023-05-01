<template>
    <v-container>
        <v-row v-if="movies.length > 0" no-gutters>
            <v-col class="d-flex flex-row flex-nowrap" v-for="(movie, index) in movies" :key="index" cols="12" md="3">
                <card-component :movie="movie"></card-component>
            </v-col>
        </v-row>
        <v-row v-else align="center" justify="center">
            <v-col cols="12" md="6">
                <v-card class="pa-5">
                    <v-row align="center" justify="center">
                        <v-col cols="12" class="text-center">
                            <v-icon size="64" color="grey lighten-1">mdi-file-search-outline</v-icon>
                        </v-col>
                        <v-col cols="12" class="text-center">
                            <h3 class="grey--text text--lighten-1">No Records Found</h3>
                        </v-col>
                        <v-col cols="12" class="text-center">
                            <p>There are no records to display at the moment.</p>
                        </v-col>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
  
<script>
import store from '@/store';
import CardComponent from './CardComponent.vue';

export default {
    name: "SimilarComponent",
    components: {
        CardComponent
    },
    data() {
        return {
            movies: [],
        }
    },
    computed: {
        getSimilar() {
            return store.state.common.similar
        },
    },
    async created() {
        await this.getMovies()
    },
    methods: {
        async getMovies() {
            try {
                await store.dispatch('common/getSimilarMovies', JSON.parse(localStorage.getItem("similar")));
                this.movies = [...this.movies, ...store.state.common.movies];

            } catch (e) {
                console.log(e, 'from error')
            }
        },
    }
}
</script>
<style scoped>
.v-row {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    /* Optional: Enable momentum scrolling */
    padding-bottom: 10px;
    padding-right: 5px;
    /* Optional: Add some spacing between the cards and the bottom edge of the container */
}

.v-col {
    flex: 0 0 auto;
}

.v-card {
    width: 320px;
    margin-right: 10px;
    /* Optional: Add some spacing between the cards */
}
</style>
  