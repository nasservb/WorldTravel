<template>
<table class="table table-striped table-bordered">
    <tr>
        <td>{{ __('common.source') }}</td>
        <td>
            <select id="source-place" class="input">
                <option v-for="(place, index) in places" :value="place.id">{{ place.name }}</option>
            </select>

        </td>
    </tr>

    <tr>
        <td>{{ __('common.destination') }}</td>
        <td>
            <select id="destination-place" class="input">
                <option v-for="(place, index) in places" :value="place.id">{{ place.name }}</option>
            </select>

        </td>
    </tr>
    <tr>
        <td>{{ __('common.start_time') }}</td>
        <td>
            <input type="date" id="start-time" :min="(new Date()).getDate()" :max=" (new Date((new Date()).setDate((new Date()).getDate() + 30))).getDate() " class="input" />
        </td>
    </tr>
    <tr>
        <transfer-list :response="items" @show='show($event)'></transfer-list>
    </tr>

</table>
</template>

<script>
export default {
    props: {
        items: [],
        edit: false,
    },
    data() {
        return {
            places: [],
            defaultData: {
                required: true,
                id: null,
                source_place_id: null,
                destination_place_id: null,
                start_time: null,
                end_time: null,
            }
        }
    },
    methods: {
        getPlaces() {

            axios.get(route('api.place.list'))
                .then(response => {
                    this.places = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                    if(errors.response && errors.response.status == 403){
                        this.$router.push({
                            name: 'login'
                        });
                    }      
                })
                .finally(() => {
                    this.loading = false;
                })

        },
        show(item) {
            this.$router.push({
                name: 'transfer.show',
                params: {
                    id: item.id
                }
            });
        }
    },
    computed: {
        item: {
            get: function () {
                if (this.resource) {
                    return this.resource;
                } else {
                    return {
                        id: null,
                        source_place_id: null,
                        destination_place_id: null,
                        start_time: null,
                        end_time: null,
                    }
                }
            }
        }
    },
    created() {

        this.getPlaces();
    },
}
</script>
