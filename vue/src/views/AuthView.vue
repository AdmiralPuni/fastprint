<template>
    <div class="d-flex justify-content-start align-items-center background" style="height: 100vh;">
        <div class="flex-fill d-md-block d-none h-100">
            <div class="d-flex flex-column justify-content-center align-items-start p-5 h-100 gap-2">
                <div class="p-3 py-1 pt-0 fs-2 text-dark bg-warning">
                    INTELLIGENCE UPDATE
                </div>
                <div class="p-3 py-1 pt-0 fs-2 text-light w-75">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3 h-100 bg-light shadow">
            <div class="d-flex flex-column justify-content-center align-items-center h-100">
                <div class="card shadow-sm w-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="fs-3">
                                <i class="bi bi-grid"></i> Login
                            </div>
                            <router-link class="btn btn-outline-dark" to="/">
                                <i class="bi bi-house"></i> Home
                            </router-link>
                        </div>
                        <form action="#" method="post" @submit.prevent="submit">
                            <div class="mb-2">
                                <label class="form-label mb-1">Username</label>
                                <input type="text" class="form-control fs-5" v-model="username" required>
                            </div>
                            <div class="mb-5">
                                <label class="form-label mb-1">Password</label>
                                <input type="password" class="form-control fs-5" v-model="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.background {
    background-image: url('/DOI.png');
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
}
</style>
<script>
export default {
    data() {
        return {
            username: '',
            password: ''
        }
    },
    methods: {
        submit() {
            console.log(this.username, this.password)
            //set cookie
            this.$cookies.set('isAuth', true, '1d')

            //redirect to /dashboard
            this.$router.push('/dashboard')
        }
    }
}
</script>