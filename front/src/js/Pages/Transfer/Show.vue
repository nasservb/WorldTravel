<template>
<div class="pb-4">
    <div class="card">

        <div class="card-body">

            <div class="flex-none sm:w-full md:w-2/3">
                <transfer-item :multiple="multiple" :resource="resource"></transfer-item>
            </div>
        </div>
    </div>

    <button @click="back()" class="btn btn-gray">{{__('layouts.back')}}</button>
    <button @click="reserve()" class="btn btn-green">{{__('common.reserve')}}</button>

</div>
</template>

<script>
export default {
    data() {
        return {
            id: null,
            resource: {},
            multiple:false 
        }
    },

    methods: {
        getResource() {
            axios.get(route('api.transfer.show', {
                    id: this.id
                }), {
                    params: {
                        id: this.id
                    }
                })
                .then(response => {
                    console.log(response.data);
                    if (response.data && response.data.role){
                        this.resource = response.data.transfer;
                        this.multiple = response.data.role == 'agency';
                    }
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
        },
        reserve() {
            const seats_no = [].filter.call(document.getElementsByName('seat_no[]'), (c) => c.checked).map(c => c.value);
            const transfer_id = this.id;
            const user_id = 0;

            console.log(seats_no);
            if (parseInt(seats_no) == 0) {
                return alert("Please select a seat no!");
            }

            axios.post(route('api.booking.add', ), {
                    transfer_id: this.id,
                    user_id: user_id,
                    seats_no: seats_no
                })
                .then(response => {
                    alert("transfer successfully booked for you!");
                    this.$router.push({
                        name: 'panel'
                    });
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
    },

    created() {
        this.id = this.$route.params.id;

        this.getResource();
    },

}
</script>
