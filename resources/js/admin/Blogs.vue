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
                <v-data-table :items="ablogs" :headers="ablogsHeaders" density="comfortable">
                    <template v-slot:item.blog_image="{item}">
                        <v-img v-if="item.blog_image" :src="item.blog_image"></v-img>
                        <v-img v-else src="https://dummyimage.com/120x63/000/fff&text=No+Image"></v-img>
                    </template>
                    <template v-slot:item.blog_title="{item}">
                        <router-link :to="{name:'blogedit',params:{blog_id:item.blog_id}}">{{item.blog_title}}</router-link>
                    </template>
                    <template v-slot:item.tags="{item}">
                       <div v-if="item.tags.length > 0">
                           <v-chip color="primary" density="compact" class="me-1 mb-1"
                                   v-for="(tag,tidx) in item.tags" :key="tidx">{{tag}}</v-chip>
                       </div>
                    </template>
                    <template v-slot:item.meta_title="{item}">
                        <div>{{item.meta_title}}</div>
                        <div>{{item.meta_desc}}</div>
                    </template>
                    <template v-slot:item.blog_status="{item}">
                        <v-btn v-if="item.blog_status === 'active'" color="success" density="compact" class="text-capitalize">{{item.blog_status}}</v-btn>
                        <v-btn v-else color="red" density="compact" class="text-capitalize">{{item.blog_status}}</v-btn>
                    </template>
                </v-data-table>
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
            ablogsHeaders:[
                {title:"Image",value:'blog_image'},
                {title:"Title",value:'blog_title'},
                {title:"Tags",value:'tags'},
                {title:"Meta",value:'meta_title'},
                {title:"Status",value:'blog_status'},
            ],
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
                })
        }
    }
}

</script>

<style scoped>

</style>
