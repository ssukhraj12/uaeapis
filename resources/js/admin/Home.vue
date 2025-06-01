<template>
    <div>
        <h2>Home Dashbaord Page</h2>
        {{this.$store.state}}
    </div>
</template>
<script>
export default{
    name:"Home",
    data(){
        return{
            email:'',
            password:'',
        }
    },
    methods:{

    }
}

</script>

<style scoped>

</style>
