<template>
<table class="table table-striped table-bordered">
    <tr v-if="item.id">
        <td>{{ __('common.id') }}</td>
        <td>{{ item.id }}</td>
    </tr>

    <tr>
        <td>{{ __('common.source') }}</td>
        <td>

            <label>{{ item.source }}</label>
        </td>
    </tr>

    <tr>
        <td>{{ __('common.destination') }}</td>
        <td>

            <label>{{ item.destination }}</label>
        </td>
    </tr>
    <tr>
        <td>{{ __('common.start_time') }}</td>
        <td>
            <input type="datetime-local" id="start-time" disabled class="input" :value="item.start_time" />

        </td>
    </tr>
    <tr>
        <td>{{ __('common.end_time') }}</td>
        <td>
            <input type="datetime-local" id="end-time" disabled class="input" :value="item.end_time" />

        </td>
    </tr>
    <tr>
        <td>{{ __('common.price') }}</td>
        <td>
            <label>{{ item.fare }}</label>
        </td>
    </tr>
    <tr>
        <td>{{ __('common.vehicle_class') }}</td>
        <td>
            <label>{{ item.vehicle_class }}</label>
        </td>
    </tr>
    <tr>
        <td>{{ __('common.executing_driver') }}</td>
        <td>
            <label>{{ item.driver }}</label>
        </td>
    </tr>
    <tr>
        <td>{{ __('common.passenger_capacity') }}</td>
        <td>
            <label>{{ item.passenger_capacity }}</label>
        </td>
    </tr>
    <tr>
        <td>{{ __('common.seat_no') }}</td>
        <td>
            <label>{{ __('common.reserved_seats_no') }}:</label>
            <label><span class="tag" v-for="booked in bookedSeats">{{ booked.seats_booked }}</span></label>

            <fieldset id="group3" v-for="seat in getSeat">
                <input :type="seat.type" :disabled='seat.disabled' name="seat_no[]" :value="seat.val">{{ seat.val }}</input>
            </fieldset>

        </td>
    </tr>
</table>
</template>

<script>
export default {
    props: {
        resource: {
            data: {
                required: true,
                id: null,
                source: null,
                destination: null,
                start_time: null,
                end_time: null,
                fare: null,
                vehicle_class: null,
                passenger_capacity: null,
                driver: null,
            },
            seats: [],
        },
        multiple: false,
    },
    computed: {
        getSeat: {
            get: function () {
                let output = [];

                for (let i = 1; i <= this.item.passenger_capacity; i++) {
                    let found = false;

                    for (let j = 0; j < this.bookedSeats.length; j++) {
                        const element = this.bookedSeats[j];
                        if (parseInt(element.seats_booked) == i) {
                            found = true;
                        }
                    }
                    output.push({
                        'type': this.multiple ? 'checkbox' : 'radio',
                        'disabled': found,
                        'val': i
                    });
                }
                return output;
            }
        },
        bookedSeats: {
            get: function () {
                if (this.resource) {
                    return this.resource.seats;
                } else {
                    return [];
                }
            },
        },
        item: {
            get: function () {
                if (this.resource) {
                    return this.resource.data;
                } else {
                    return {
                        id: null,
                        source: null,
                        destination: null,
                        start_time: null,
                        end_time: null,
                        fare: null,
                        vehicle_class: null,
                        passenger_capacity: null,
                        driver: null,
                    }
                }
            }
        }
    }
}
</script>
