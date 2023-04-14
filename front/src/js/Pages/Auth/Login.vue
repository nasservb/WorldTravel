<template>
<div class="page-single">
    <link href="css/login.css" rel="stylesheet" />
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4 col-sm-9">
                <div>
                    <div>
                        <div id="card" style="height: 270px">
                            <div class="front">
                                <div class="card ">
                                    <div class="card-body  p-5 ">

                                        <div>{{__('auth.throttle')}}</div>
                                        <code>
                                            user: nasser.niazymobsser@gmail.com<br>
                                            password: 12345678<br>
                                        </code>
                                        <div class="pull-right"><a id="togglePage" class="login-btn social-btn .btn i btn btn-blue btn-block text-center mt-2 " href="javascript:void(0)">Go to Login </a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="back" style="position: absolute">
                                <div class="card ">
                                    <div class="card-body  px-5 py-2 ">
                                        <h3 class="text-center">Login with Email and Password</h3>

                                        <div>
                                            <div class=" row">
                                                <label for="name" class="col-12 col-form-label text-left">
                                                    {{ __('auth.E-Mail address') }}
                                                </label>

                                                <div class="col-md-12">
                                                    <input id="email" type="text" class="form-control " name="email" value="nasser.niazymobsser@admin.com" required autocomplete="email" autofocus>

                                                    <span id="errorBox" class="invalid-feedback" v-if="error" role="alert">
                                                        <strong id="message"></strong>
                                                    </span>

                                                </div>
                                            </div>

                                            <div class=" row">
                                                <label for="email" class="col-12 col-form-label text-left">Password

                                                </label>

                                                <div class="col-md-12">
                                                    <input id="password" type="password" class="form-control " name="password" value="12345678" required>
                                                </div>
                                            </div>

                                            <button @click="login()" class="login-btn social-btn .btn i btn btn-green btn-block text-center m-2">Login</button>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-center p-2 ">
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            id: null,
            error: null,
            resource: {},
        }
    },
    methods: {
        login() {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            axios.post(route('auth.login'), {
                    email: email,
                    password: password
                })
                .then(response => {
                    this.auth = response.data;
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token;

                    localStorage.token = response.data.token;
                    localStorage.isAgency = response.data.isAgency;

                    this.$router.push({
                        name: 'panel'
                    });
                })
                .catch(errors => {
                    console.log(errors);
                    alert(__('common.the_record_is_not_deleted'));
                });

        }
    },
    created() {

    },

}
</script>
