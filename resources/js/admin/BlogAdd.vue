<template>
    <div class="blogs">
        <v-row>
            <v-col cols="12" md="6" class="d-flex align-center">
                <h2>Blogs List</h2>
            </v-col>
            <v-col cols="12" md="6" class="text-end">
                <v-btn :to="{name:'blogs'}" density="default" class="text-none me-1" prepend-icon="mdi-arrow-left"
                       color="red" variant="outlined">
                    Back</v-btn>
                <v-btn @click="addBlogData" color="success" class="text-none">Save</v-btn>
            </v-col>
        </v-row>
        <v-row class="bg-white mb-4">
            <v-col cols="12" md="8">
                <v-text-field v-model="blog_title" label="Title" variant="underlined"></v-text-field>
            </v-col>
            <v-col cols="12" md="4">
                <v-select v-model="blog_status" label="Status" :items="allstatus" variant="underlined"></v-select>
            </v-col>
            <v-col cols="12" md="12">
                <v-textarea v-model="blog_description" label="Description" variant="underlined"></v-textarea>
            </v-col>
            <v-col cols="12" md="6">
                <v-combobox v-model="tags" label="Tags" :items="atags" multiple chips closable-chips
                            variant="underlined" density="compact"></v-combobox>
            </v-col>
            <v-col cols="12" md="6">
                <v-file-input v-model="blog_image" label="Blog Image" accept="image/*" show-size variant="underlined"></v-file-input>
            </v-col>
            <v-col cols="12" md="12">
                <h4 class="text-h6">Search Engine View</h4>
                <v-text-field v-model="meta_title" label="Meta Title" variant="underlined"></v-text-field>
                <v-textarea v-model="meta_desc" label="Meta Description" variant="underlined"></v-textarea>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default{
    name:"BlogAdd",
    data(){
        return{
            ablogs:[],
            allstatus:['active','inactive'],
            blog_title:'',
            blog_description:'',
            blog_image:null,
            tags:[],
            atags:['Resume','CV','New'],
            blog_status:'active',
            meta_title:'',
            meta_desc:'',
        }
    },
    created() {

    },
    methods:{
        addBlogData(){
            const nblog = {
                blog_title:this.blog_title,
                blog_description:this.blog_description,
                tags:this.tags,
                blog_status:this.blog_status,
                meta_title:this.meta_title,
                meta_desc:this.meta_desc,
            }
            const ndata = new FormData();
            ndata.append('blog_image',this.blog_image);
            ndata.append('blog_title',this.blog_title);
            ndata.append('blog_description',this.blog_description);
            this.tags.forEach((tag, index) => {
                ndata.append(`tags[${index}]`, tag);
            });
            ndata.append('blog_status',this.blog_status);
            ndata.append('meta_title',this.meta_title);
            ndata.append('meta_desc',this.meta_desc);

            axios.post('/api/admin/blog/add',ndata)
                .then((resp)=>{
                    console.log(resp)
                })
                .catch((err)=>{
                    alert(err.message);
                })
            console.log('ndata',ndata);
        }
    }
}

</script>

<style scoped>

</style>
