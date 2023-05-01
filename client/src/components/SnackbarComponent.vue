<template>
    <div class="text-center ma-2">
        <!-- <v-btn @click="snackbar = true">
            Open Snackbar
        </v-btn> -->
        <v-snackbar v-model="snackbar" :color="color">
            {{ text }}

            <template v-slot:actions>
                <v-btn color="black" variant="text" @click="snackbar = false">
                    Close
                </v-btn>
            </template>
        </v-snackbar>
    </div>
</template>
  
<script>
import store from '@/store';


export default {
    name: "SnackbarComponent",
    // props: {
    //     show: {
    //         type: Boolean,
    //         required: true
    //     },
    //     text: {
    //         type: String,
    //         required: true
    //     },
    //     color: {
    //         type: String,
    //         required: true
    //     },
    // },
    data() {
        return {
            snackbar: false,
            color: ''
            // text: `Hello, I'm a snackbar`,
        }
    },
    computed: {
        text() {
            console.log('called computed')
            this.snackbar = store.state.common.show
            this.color = store.state.common.color

            return store.state.common.text
        }
    },
    watch: {
        text(text) {
            console.log('called watch', text)
            this.snackbar = store.state.common.show
            this.color = store.state.common.color

            setTimeout(() => {
                store.commit('common/SET_SHOW', false)
                store.commit('common/SET_TEXT', '')
                store.commit('common/SET_COLOR', '')

                this.snackbar = false
                this.color = ''
            }, 3000);
        }
    },
    async created() { },
    methods: {}
}
</script>
<style></style>