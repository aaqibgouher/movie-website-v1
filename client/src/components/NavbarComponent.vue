<template>
    <v-app-bar fixed>
        <v-app-bar-title><v-btn variant="plain" to="/">
                <h1 style="color: #ffb74d">MOVIOO</h1>
            </v-btn></v-app-bar-title>

        <v-spacer></v-spacer>
        <span v-if="isLogin">
            <v-btn color="orange-lighten-2" variant="text" to="/favourites">
                <v-badge dot color="success">
                    <v-icon icon="mdi-heart" size="x-large"></v-icon>
                </v-badge>
            </v-btn>
            <v-btn color="orange-lighten-2" variant="text" @click="logout">
                LOGOUT
            </v-btn>
        </span>
        <span v-else>
            <v-btn color="orange-lighten-2" variant="text" to="/login">
                LOGIN
            </v-btn>
            <v-btn color="orange-lighten-2" variant="text" to="register">
                REGISTER
            </v-btn>
        </span>
    </v-app-bar>
</template>
  
<script>
import store from '@/store';
import router from "@/router";

export default {
    data() {
        return {
            items: [
                { title: 'Home', icon: 'mdi-home-city' },
                { title: 'My Account', icon: 'mdi-account' },
                { title: 'Users', icon: 'mdi-account-group-outline' },
            ],
        }
    },
    computed: {
        isLogin() {
            return store.state.common.isLogin
        },
    },
    methods: {
        async logout() {
            try {
                await store.dispatch('common/logout');

                console.log('logout success')
            } catch (e) {
                console.log(e, 'from logout navbar')
                store.commit('common/SET_SHOW', true)
                store.commit('common/SET_TEXT', e)
                store.commit('common/SET_COLOR', 'red')
            }
        },
    }
}
</script>
  