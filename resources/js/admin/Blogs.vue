<template>
    <div class="blogs">
        <v-row>
            <v-col cols="12" md="6">
               <h2>Blogs List</h2>
            </v-col>
            <v-col cols="12" md="6" class="text-end">
                <v-btn :to="{name:'blogadd'}" color="primary" density="default" class="text-none" prepend-icon="mdi-plus">Add Blog</v-btn>
            </v-col>
            <v-col cols="12" md="12">
                <v-data-table :items="ablogs"></v-data-table>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default{
    name:"Blogs",
    data(){
        return{
            ablogs:[],
        }
    },
    created() {
        this.getBlogsList();
    },
    methods:{
        getBlogsList(){
            axios.get('/api/admin/blogs')
                .then((resp)=>{
                    this.ablogs = resp.data.blogs;
                    console.log('resp',resp);
                })
        }
    }
}

</script>

<style scoped>

</style>
