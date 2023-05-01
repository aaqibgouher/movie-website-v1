<template>
    <v-card class="mx-auto my-5 px-6 py-8 text-center" max-width=" 400">
        <h1>REGISTER</h1>
        <br>
        <v-form v-model="form" @submit.prevent="register">
            <v-text-field v-model="name" :readonly="loading" :rules="[required]" class="mb-2" clearable
                label="Name"></v-text-field>
            <v-text-field v-model="email" :readonly="loading" :rules="[required]" class="mb-2" clearable
                label="Email"></v-text-field>
            <v-text-field v-model="password" :readonly="loading" :rules="[required]" clearable label="Password"
                placeholder="Enter your password"></v-text-field>
            <v-text-field v-model="confirmPassword" :readonly="loading" :rules="[required, passwordEqualConfirm]" clearable
                label="Confirm password" placeholder="Enter your password"></v-text-field>

            <br>

            <v-btn :disabled="!form" :loading="loading" style="background-color: #ffb74d; color: white;" block type="submit"
                variant="elevated">
                Submit
            </v-btn>
            <v-btn variant="plain" to="/login">
                Click to Login
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
import router from '@/router'
import store from '@/store'

export default {
    name: "RegisterComponent",
    components: {
    },
    data() {
        return {
            name: null,
            form: false,
            email: null,
            password: null,
            confirmPassword: null,
            loading: false,
        }
    },
    methods: {
        async register() {
            try {
                this.loading = true

                if (!this.form) return

                let payload = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    confirm_password: this.confirmPassword
                }

                await store.dispatch('common/register', payload);

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
        passwordEqualConfirm(v) {

            return this.password === this.confirmPassword || 'Password and Confirm should be same'
        },
    }
}
</script>

<style></style>
  