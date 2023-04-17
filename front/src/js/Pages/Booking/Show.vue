<template>
<div class="pb-4">
    <div class="card">

        <div class="card-body">

            <div class="flex-none sm:w-full md:w-2/3">
                <booking-item :edit="false" :resource="resource"></booking-item>
            </div>
        </div>
    </div>

    <button @click="back()" class="btn btn-gray">{{__('layouts.back')}}</button>

</div>
</template>

<script>
export default {
    data() {
        return {
            id: null,
            resource: {},
        }
    },

    methods: {
        getResource() {
            axios.get(route('api.booking.show', {
                    id: this.id
                }), {
                    params: {
                        id: this.id
                    }
                })
                .then(response => {
                    this.resource = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                    if(errors.response && errors.response.status == 403){
                        this.$router.push({
                            name: 'login'
                        });
                    }
                });

        },
        back() {
            this.$router.back();
        }
    },

    created() {
        this.id = this.$route.params.id;

        this.getResource();
    },

}
</script>
