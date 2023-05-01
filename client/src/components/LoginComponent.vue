<template>
    <v-card class="mx-auto my-5 px-6 py-8 text-center" max-width="400">
        <h1>LOGIN</h1>
        <br>
        <v-form v-model="form" @submit.prevent="login">
            <v-text-field v-model="email" :readonly="loading" :rules="[required]" class="mb-2" clearable
                label="Email"></v-text-field>

            <v-text-field v-model="password" :readonly="loading" :rules="[required]" clearable label="Password"
                placeholder="Enter your password"></v-text-field>

            <br>

            <v-btn :disabled="!form" :loading="loading" style="background-color: #ffb74d; color: white;" block type="submit"
                variant="elevated">
                Submit
            </v-btn>
            <v-btn variant="plain" to="/register">
                Click to Register
            </v-btn>
            <br>
            <br>
            <v-divider></v-divider>
            <v-btn variant="plain" to="/" icon>
                <v-icon>mdi-home-city</v-icon>
            </v-btn>
        </v-form>
    </v-card>
</template>
  
<script>
import store from '@/store'
import router from '@/router'

export default {
    name: "LoginComponent",
    components: {
    },
    data() {
        return {
            form: false,
            email: null,
            password: null,
            loading: false,
        }
    },
    methods: {
        async login() {
            try {
                this.loading = true

                if (!this.form) return

                let payload = {
                    email: this.email,
                    password: this.password,
                }

                await store.dispatch('common/login', payload);

                // redirecting to home page
                // router.push('/')

                this.loading = false
            } catch (e) {
                console.log(e, 'from register')
                store.commit('common/SET_SHOW', true)
                store.commit('common/SET_TEXT', e)
                store.commit('common/SET_COLOR', 'red')
                this.loading = false
            }
        },
        required(v) {
            return !!v || 'Field is required'
        },
    }
}
</script>

<style>
.full-height {
    height: 100%;
    min-height: 100vh;
}
</style>
  