<template>
    <div class="card">
        <table class="table table-striped table-hovered">
            <thead>
                <th>#</th>
                <th>{{__('common.path')}}</th>
                <th>{{__('common.start_time')}}</th>
                <th>{{__('common.price')}}</th>
                <th>{{__('common.vehicle_class')}}</th>
                <th>{{__('common.action')}}</th>
            </thead>
            <tr v-for="item in response">
               <td>{{item.id}}</td>
               <td>{{item.source + ' => '+ item.destination}}</td>
               <td>{{ item.start_time }}</td>
               <td>{{ item.fare }}</td>
               <td>{{ item.vehicle_class }}</td>
                <td>
                    <button class="btn btn-light icon" @click="$emit('show', item)">
                        <i class="fe fe-eye" aria-hidden="true"></i>
                    </button>
                </td>
                
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        response:{}
    },
    methods:{

    }

}
</script>
