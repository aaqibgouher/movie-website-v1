<template>
    <v-container style="margin-top: 2rem;">
        <h2>Favourites</h2>
        <v-divider></v-divider>
        <v-row v-if="favourites.length > 0" class="mt-5">
            <v-col v-for="(movie, index) in favourites" :key="index" cols="12" md="3">
                <card-component :movie="movie"></card-component>
            </v-col>
        </v-row>
        <v-row class="mt-5" v-else align="center" justify="center">
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
import CardComponent from '@/components/CardComponent.vue';
import store from '@/store';

export default {
    components: {
        CardComponent
    },
    data() {
        return {
            show: false,
            loaded: false,
            loading: false,
            page: 1,
            search: "",
            type: "",
            isAtBottom: false,
            movies: []
        };
    },
    computed: {
        favourites() {
            let movies = store.state.common.movies
            let newArr = []

            if (movies.length) {
                newArr = movies.map(movie => {
                    return {
                        Type: movie.type,
                        Title: movie.title,
                        Year: movie.year,
                        Poster: movie.poster,
                        imdbID: movie.imdb_id
                    };
                });
            }

            return newArr
        },
    },
    methods: {
        async getFavourites() {
            try {

                await store.dispatch('common/getFavourites');
                this.movies = [...store.state.common.movies];

            } catch (e) {
                console.log(e, 'from error favourites page')
            }
        },
    },
    async created() {
        console.log('from fav')
        await this.getFavourites()
    },
}
</script>
  
<style scoped></style>
  