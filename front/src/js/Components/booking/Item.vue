<template>
    <table class="table table-striped table-bordered">
        <tr  v-if="item.id"><td>{{ __('common.id') }}</td><td>{{ item.id }}</td></tr>

        <tr>
            <td>{{ __('common.source') }}</td>
            <td>
                
                <label v-if="!edit">{{ item.source }}</label>
            </td>
        </tr>
        
        <tr>
            <td>{{ __('common.destination') }}</td>
            <td>
                
                <label v-if="!edit">{{ item.destination }}</label>
            </td>
        </tr>
        <tr>
            <td>{{ __('common.start_time') }}</td>
            <td>
                <input type="datetime-local"  
                   disabled
                    class="input" :value="item.start_time"   />
               
            </td>
        </tr>
        <tr>
            <td>{{ __('common.end_time') }}</td>
            <td>
                <input type="datetime-local"  
                    disabled
                    class="input" :value="item.end_time"   />
                
            </td>
        </tr>
         <tr>
            <td>{{ __('common.pickup_time') }}</td>
            <td>
                <input type="datetime-local" 
                    disabled
                    class="input" :value="item.pickup_time"   />
                
            </td>
        </tr>
        <tr>
            <td>{{ __('common.price') }}</td>
            <td>
                <label >{{ item.fare }}</label>
            </td>
        </tr>
        <tr>
            <td>{{ __('common.vehicle_class') }}</td>
            <td>
                <label >{{ item.vehicle_class }}</label>
            </td>
        </tr>
        <tr>
            <td>{{ __('common.executing_driver') }}</td>
            <td>
                <label >{{ item.driver }}</label>
            </td>
        </tr>
        <tr>
            <td>{{ __('common.passenger_capacity') }}</td>
            <td>
                <label >{{ item.passenger_capacity }}</label>
            </td>
        </tr>
      
        <tr>
            <td>{{ __('common.seats_booked') }}</td>
            <td>
                <label >{{ item.seats_booked }}</label>
            </td>
        </tr>
    </table>
</template>

<script>
export default {
    props: {
        resource: {
            required: true,
            id:null,
            source_place_id:null,
            destination_place_id:null,
            start_time:null,
            end_time:null,
            price_per_ticket:null,
            vehicle_class:null,
            passenger_capacity:null,
            executing_driver:null,
        },
        edit:false,
    },
    computed: {
        item: {
            get: function() {
                if (this.resource) {
                    return this.resource;
                }
                else {
                    return {
                        id:null,
                        source_place_id:null,
                        destination_place_id:null,
                        start_time:null,
                        end_time:null,
                        price_per_ticket:null,
                        vehicle_class:null,
                        passenger_capacity:null,
                        executing_driver:null,
                    }
                }
                }
            }
        }
}
</script>
