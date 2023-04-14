<template>
    <div>
        <button class=" mt-6 btn btn-green" @click="book">{{__('common.book')}}</button>
        <resource-table-card :response="response" @paginate="paginate($event)" :loading="loading">
            <booking-list   
               v-if="response.data.length > 0"             
                :response="response.data"
                @show="show($event)"
            ></booking-list>
        </resource-table-card>
    </div>
</template>

<script>

export default {
    data(){
        return {
            response: {
                data: [],
                meta: {
                    from: 1,
                },
            },
            loading:false,
            query: {
                page: 1,
            },
        }
    },
    methods:{
        getItems(){            
            axios.get(route('api.booking.index'))
                .then(response => {
                    this.response.data = response.data;
                })
                .catch(errors => {
                    console.log(errors);
                })
                .finally(() => {
                    this.loading = false;
                })
                 
        },
        book(){
            this.$router.push({name:'transfer.search'});
        },
        show(item){
            this.$router.push({name:'booking.show', params:{id :item.id}});
        },
        paginate(page) {
            this.query.page = page;
            this.$router.push({name: 'index', query: this.query});

        },
    },
    created() {
        _.each(this.$route.query, (query, index) => {
            if (_.has(this.query, index)) {
                this.query[index] = query;
            }
        });

        const {query} = this.$route ;

        this.getItems();
    },
    mounted() {
        this.getItems();

    }
}
</script>
