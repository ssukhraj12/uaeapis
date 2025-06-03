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
        <v-row>
            <v-col cols="12" md="8">
                <v-card flat class="border-sm">
                    <v-card-text>
                        <v-text-field v-model="blog_title" label="Blog Title" variant="underlined" persistent-placeholder
                                      placeholder="Create a fresh line for blog"></v-text-field>
                    </v-card-text>
                    <v-card-text>
                        <quill-editor ref="quillRef" v-model="quillContent" @text-change="onEditorChange"></quill-editor>
                    </v-card-text>
                    <v-card-text>
                        <v-text-field v-model="meta_title" :placeholder="blog_title" label="Meta Title"
                                      variant="underlined" persistent-placeholder></v-text-field>
                        <v-textarea v-model="meta_desc" label="Meta Description" variant="underlined"></v-textarea>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card flat class="border-sm">
                    <v-card-text>
                        <v-select v-model="blog_status" label="Status" :items="allstatus" variant="underlined"></v-select>
                    </v-card-text>
                    <v-card-text>
                        <v-combobox v-model="tags" label="Tags" :items="atags" multiple chips closable-chips
                                    variant="underlined" density="compact"></v-combobox>
                    </v-card-text>
                    <v-card-text>
                        <v-img v-if="imagePreview" :src="imagePreview" width="320" height="240" contain></v-img>
                        <v-img v-else src="/blog_image" min-width="240" min-height="130" max-width="320" max-height="180" contain></v-img>
                        <v-file-input v-model="blog_image" label="Blog Image" accept="image/*" show-size
                                      variant="underlined" @change="onImageChange"></v-file-input>
                    </v-card-text>
                </v-card>

            </v-col>
        </v-row>

    </div>
</template>
<script>
export default{
    name:"BlogAdd",
    data(){
        return{
            domain:'https://www.yourresumewriter.com/',
            ablogs:[],
            allstatus:['active','inactive'],
            blog_title:'',
            quillContent:'',
            blog_description:'',
            blog_image:null,
            imagePreview: null,
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
        onImageChange() {
            if (this.blog_image instanceof File) {
                this.imagePreview = URL.createObjectURL(this.blog_image);
            } else {
                this.imagePreview = null;
            }
        },
        addBlogData(){
            const uheaders = {headers: {'Content-Type': 'multipart/form-data'}}
            const adata = new FormData();
            adata.append('blog_title',this.blog_title);
            if (this.blog_image instanceof File) {
                adata.append('blog_image', this.blog_image);
            }
            adata.append('blog_description',this.quillContent);
            this.tags.forEach((tag, index) => {
                adata.append(`tags[${index}]`, tag);
            });
            adata.append('blog_status',this.blog_status);
            adata.append('meta_title',this.meta_title);
            adata.append('meta_desc',this.meta_desc);

            axios.post('/api/admin/blog/add',adata,uheaders)
                .then((resp)=>{
                    if(resp.data.status){
                        const blog_id = resp.data.blog.blog_id;
                        this.$router.push({name:'blogedit',params:{blog_id:blog_id}})
                    }
                })
                .catch((err)=>{
                    alert(err.message);
                })
        },
        onEditorChange(delta, oldDelta, source) {
            const quill = this.$refs.quillRef.getQuill();
            this.quillContent = quill.root.innerHTML;
        },
    },
}

</script>

<style scoped>

</style>
