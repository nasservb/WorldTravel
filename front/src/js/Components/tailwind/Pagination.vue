<template>
    <div class="row justify-between mt-6" v-if="meta.last_page > 1">
        <div>
            <button class="hover:underline btn btn-light  text-blue font-bold py-2 px-4 rounded" v-if="meta.current_page > 1"
                    @click="$emit('paginate', meta.current_page - 1)">
                {{ __('layouts.previous') }}
            </button>
            <span v-else></span>
        </div>

        <div v-if="meta.total > 1" class="p-2 text-center">
            <span class="text-grey-dark font-bold">{{ __('layouts.total') }}: {{ meta.total.toLocaleString() }}</span>
        </div>

        <div>
            <button class="hover:underline btn btn-light text-blue font-bold py-2 px-4 rounded" v-if="meta.current_page !== meta.last_page"
                    @click="$emit('paginate', meta.current_page + 1)">
                {{ __('layouts.next') }}
            </button>
            <span v-else></span>
        </div>
    </div>


</template>

<script>
    export default {
        props: {
            meta: { required: true },
        }
    }
</script>
