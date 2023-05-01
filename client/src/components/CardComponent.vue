<template>
    <v-card class="mx-2 my-2" max-width="344">
        <v-img :src="movie.Poster" height="200px" cover></v-img>

        <v-card-title>
            {{ movie.Title }}
        </v-card-title>

        <!-- <v-card-subtitle>
            {{ movie.Year }}
        </v-card-subtitle>

        <v-card-subtitle>
            {{ movie.Type }}
        </v-card-subtitle> -->
        <v-row justify-content="space-between" align-items="center">
            <v-col>
                <v-card-subtitle>
                    {{ movie.Year }}
                </v-card-subtitle>
            </v-col>
            <v-col class="text-end">
                <v-card-subtitle>
                    {{ movie.Type }}
                </v-card-subtitle>
            </v-col>
        </v-row>

        <!-- <v-card-actions>
            <v-row justify-content="center">
                <v-btn color="orange-lighten-2" variant="text" :to="`/${movie.imdbID}`" @click="storeMovie(movie)">
                    Explore
                </v-btn>

                <v-spacer></v-spacer>
            </v-row>
        </v-card-actions> -->
        <v-card-actions class="d-flex justify-center">
            <v-btn color="orange-lighten-2" variant="text" :to="`/${movie.imdbID}`" @click="storeMovie(movie)">
                Explore
            </v-btn>
        </v-card-actions>

    </v-card>
</template>
  
<script>
import store from '@/store';

export default {
    name: "CardComponent",
    props: {
        movie: {
            type: Object,
            required: true
        }
    },
    data() {
        return {}
    },
    methods: {
        storeMovie(similarObj = {}) {
            console.log('called', similarObj)
            localStorage.setItem("similar", JSON.stringify(similarObj));
        }
    }
}
</script>
  