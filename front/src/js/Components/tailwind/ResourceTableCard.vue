<template>
    <tailwind-card>
        <div class="loading" v-if="loading"></div>

        <slot></slot>

        <tailwind-empty-resource v-if="response.meta.total === 0 && ! loading"></tailwind-empty-resource>

        <tailwind-pagination
                v-if="response.data.length > 0"
                :meta="response.meta"
                @paginate="$emit('paginate', $event)"
        ></tailwind-pagination>
    </tailwind-card>
</template>

<script>
    export default {
        props: {
            loading: { default: false },
            response: { required: true },
        }
    }
</script>
