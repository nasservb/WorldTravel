<template>
    <table class="table table-striped table-bordered">
        <tr  v-if="item.id"><td>{{ __('common.id') }}</td><td>{{ item.id }}</td></tr>
        <tr>
            <td>{{ __('common.title') }}</td>
            <td>
                <input type="text" id="title" class="input" :value="item.title"  v-if="edit">
                <label v-if="!edit">{{ item.title }}</label>
            </td>
        </tr>
        <tr>
            <td>{{ __('common.description') }}</td>
            <td>
                <textarea id="description" :value="item.description"  v-if="edit"></textarea>
                <label v-if="!edit">{{ item.description }}</label>
            </td>
        </tr>
        <tr v-if="item.id"><td>{{ __('common.created_at') }}</td><td>{{ item.created_at }}</td></tr>
        <tr v-if="item.id"><td>{{ __('common.updated_at') }}</td><td>{{ item.updated_at }}</td></tr>
    </table>
</template>

<script>
export default {
    props: {
        resource: {
            required: true,
            id:null,
            title:null,
            description:null,
            created_at:null,
            updated_at:null,
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
                        title:null,
                        description:null,
                        created_at:null,
                        updated_at:null,
                    }
                }
                }
            }
        }
}
</script>
