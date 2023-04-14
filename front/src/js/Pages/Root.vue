<template>
   
</template>

<script>

export default {

    created() {
        const token = localStorage.token;
        const isAgency = localStorage.isAgency;
        console.log('token is ',token);
        if (token ){
            this.auth = token;
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        }

        if (!this.auth){
            //this.$router.push({name:'transfer.show', id :1});
            this.$router.push({name:'login'});
        }
        else {
            this.$router.push({name:'panel'});
        } 
        //this.id = this.$route.params.id;

        //this.getResource();
    },

}
</script>
