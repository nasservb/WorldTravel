<template>
    <div class="fixed pin p-y shadow-lg" style="z-index: 1000; background-color: rgba(0,0,0,0.8);">
        <div class="sm:m-8 md:m-16 lg:m-32 bg-white rounded shadow-lg p-6">
            <div class="m-4">
                <a class="text-red text-3xl no-underline hover:no-underline" href="#" @click.prevent="$emit('close')"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
            </div>
            <div class="bg-white">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: { default: 'modal' },
        },

        data() {
            return {

            }
        },

        methods: {

        }
    }
</script>