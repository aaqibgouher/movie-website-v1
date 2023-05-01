<template>
    <v-container>
        <v-row class="sticky-top">
            <v-col cols="12" md="6" lg="4">
                <v-img :src="getMovieDetail.Poster" aspect-ratio="2/3"></v-img>
            </v-col>
            <v-col cols="12" md="6" lg="8">
                <v-card class="pa-3" style="height: 520px;">
                    <v-card-title class="headline mb-3">{{ getMovieDetail.Title }} ( {{ getMovieDetail.Year }}
                        )</v-card-title>
                    <v-card-text class="body-2">
                        <p><strong class="mr-2">Release Date:</strong>{{ getMovieDetail.Released }}</p>
                        <p><strong class="mr-2">Directed By:</strong>{{ getMovieDetail.Director }}</p>
                        <p><strong class="mr-2">Starring:</strong>{{ getMovieDetail.Actors }}</p>
                        <p><strong class="mr-2">Plot:</strong>{{ getMovieDetail.Plot }}</p>
                        <p><strong class="mr-2">Rated:</strong>{{ getMovieDetail.Rated }}</p>
                        <p><strong class="mr-2">Runtime:</strong>{{ getMovieDetail.Runtime }}</p>
                        <p><strong class="mr-2">Genre:</strong>{{ getMovieDetail.Genre }}</p>
                        <p><strong class="mr-2">Language:</strong>{{ getMovieDetail.Language }}</p>
                        <p><strong class="mr-2">Country:</strong>{{ getMovieDetail.Country }}</p>
                        <p><strong class="mr-2">Awards:</strong>{{ getMovieDetail.Awards }}</p>
                        <div v-if="getMovieDetail?.Ratings?.length > 0">
                            <span v-for="(rating, index) in getMovieDetail.Ratings" :key="index"><strong class="mr-2">{{
                                rating.Source }}: {{ rating.Value }}</strong></span>
                        </div>
                        <p><strong class="mr-2">Box Office:</strong>{{ getMovieDetail.BoxOffice }}</p>
                        <p><strong class="mr-2">IMDB Rating:</strong>{{ getMovieDetail.imdbRating }}</p>
                        <p><strong class="mr-2">IMDB Votes:</strong>{{ getMovieDetail.imdbVotes }}</p>
                        <p><strong class="mr-2">Type:</strong>{{ getMovieDetail.Type }}</p>
                    </v-card-text>
                    <v-card-actions v-if="isLogin">
                        <v-btn class="mr-2" color="primary" @click="addFavourite">Add to Favourties</v-btn>
                        <v-btn color="secondary" @click="removeFavourite">Remove from Favourties</v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
  
<script>
import store from '@/store';

export default {
    name: "DetailComponent",
    data() {
        return {

        }
    },
    computed: {
        getMovieDetail() {
            return store.state.common.movie
        },
        isLogin() {
            return store.state.common.isLogin
        },
    },
    async created() {
        await this.getMovieByIMDBId()
    },
    methods: {
        async getMovieByIMDBId() {
            try {
                store.commit('common/SET_MOVIE', {})
                await store.dispatch('common/getMovieByIMDBId', this.$route.params.imdbId);
            } catch (e) {
                console.log(e, 'from detail error')
                store.commit('common/SET_SHOW', true)
                store.commit('common/SET_TEXT', e)
                store.commit('common/SET_COLOR', 'red')
            }
        },

        async addFavourite() {
            try {
                await store.dispatch('common/addFavourite', this.$route.params.imdbId);
                console.log('added')
            } catch (e) {
                console.log(e, 'from add favrourite compo')
                store.commit('common/SET_SHOW', true)
                store.commit('common/SET_TEXT', e)
                store.commit('common/SET_COLOR', 'red')
            }
        },

        async removeFavourite() {
            try {
                await store.dispatch('common/removeFavourite', this.$route.params.imdbId);
                console.log('removed')
            } catch (e) {
                console.log(e, 'from delete favrourite compo')
                store.commit('common/SET_SHOW', true)
                store.commit('common/SET_TEXT', e)
                store.commit('common/SET_COLOR', 'red')
            }
        }
    }
}
</script>
<style>
.headline {
    color: #FF9800;
}

.mr-2 {
    margin-right: 10px;
}

.sticky-top {
    position: sticky;
    top: 0;
}
</style>
  