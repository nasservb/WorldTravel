<template>
<div class="pb-4">
    <div class="card">

        <div class="card-body">

            <div class="flex-none sm:w-full md:w-2/3">
                <transfer-search :items="items" @show="show($event)"></transfer-search>
            </div>
        </div>
    </div>

    <button @click="back()" class="btn btn-gray">{{__('layouts.back')}}</button>
    <button @click="search()" class="btn btn-blue">{{__('common.search')}}</button>

</div>
</template>

<script>
export default {
    data() {
        return {
            id: null,
            items: [],
        }
    },

    methods: {
        back() {
            this.$router.back();
        },
        search() {
            const source = document.getElementById("source-place").value;
            const destination = document.getElementById("destination-place").value;

            const start = document.getElementById("start-time").value;
            const end = document.getElementById("end-time").value;

            axios.get(
                    route('api.transfer.search'), {
                        params: {
                            source_id: source,
                            destination_id: destination,
                            start_time: start,
                            end_time: end
                        }
                    })
                .then(response => {
                    this.items = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                    alert(__('common.the_record_is_not_created') + ':' + errors.message);
                });

        }
    },
}
</script>
