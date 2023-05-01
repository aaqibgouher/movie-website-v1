<template>
    <v-container>
        <v-container fluid>
            <v-row align="center">
                <v-col cols="12" sm="9" md="9">
                    <v-text-field v-model="search" label="Search" hide-details filled rounded solo-inverted
                        prepend-inner-icon="mdi-magnify" placeholder="Search movies" no-underline></v-text-field>
                </v-col>
                <v-col cols="12" sm="3" md="3">
                    <v-btn rounded style="background-color: #ffb74d;" block size="x-large" class="white--text"
                        @click="submitSearch">Search</v-btn>
                </v-col>
            </v-row>
            <p>Results: {{ getTotal }}</p>
        </v-container>
        <v-container>
            <v-row v-if="movies.length > 0">
                <v-col v-for="(movie, index) in movies" :key="index" cols="12" md="3">
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
        getTotal() {
            return store.state.common.total
        },
    },
    watch: {
        search(search) {
            if (search === "") {
                this.page = 1
                this.movies = []
                this.getMovies()
            }
        }
    },
    methods: {
        onClick() {
            this.loading = true

            setTimeout(() => {
                this.loading = false
                this.loaded = true
            }, 2000)
        },
        async getMovies() {
            try {

                const params = {
                    page: this.page,
                    search: this.search,
                    type: this.type
                }

                await store.dispatch('common/getAllMovies', params);
                this.movies = [...this.movies, ...store.state.common.movies];

            } catch (e) {
                console.log(e, 'from error')
                store.commit('common/SET_SHOW', true)
                store.commit('common/SET_TEXT', e)
                store.commit('common/SET_COLOR', 'red')
            }
        },
        async handleScroll() {
            const isAtBottom =
                window.innerHeight + window.scrollY >= document.documentElement.scrollHeight;
            this.isAtBottom = isAtBottom;
            console.log(this.isAtBottom, 'bottom')

            if (this.isAtBottom) {
                this.page++;
                await this.getMovies()
            }
        },
        async submitSearch() {
            this.movies = []
            this.page = 1
            await this.getMovies()
        }
    },
    async created() {
        await this.getMovies()
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.handleScroll);
    },
}
</script>
  
<style scoped></style>
  