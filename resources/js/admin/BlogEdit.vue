<template>
    <div class="blogs">
        <v-row>
            <v-col cols="12" md="6" class="d-flex align-center">
                <h2>{{ blog_title }}</h2>
            </v-col>
            <v-col cols="12" md="6" class="text-end">
                <v-btn :to="{name:'blogs'}" density="default" class="text-none me-1" prepend-icon="mdi-arrow-left"
                       color="red" variant="outlined">
                    Back</v-btn>
                <v-btn @click="updateBlogData" color="success" class="text-none me-1">Update</v-btn>
                <v-btn v-if="blog_status === 'active'" :href="domain+ablog.blog_slug" target="_blank"
                       color="success" class="text-none">View</v-btn>
            </v-col>
        </v-row>
        <v-row>
            {{ablog}}
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
                        <!-- Placeholder -->
                        <v-img v-else src="/images/placeholder.jpg"
                            min-width="240" min-height="130"
                            max-width="320" max-height="180" contain></v-img>
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
    props:{
        blog_id:[Number,String]
    },
    data(){
        return{
            domain:'https://www.yourresumewriter.com/blog/',
            ablog:{},
            ablogs:[],
            allstatus:['active','inactive'],
            blog_title:'',
            quillContent:'',
            blog_description:'',
            blog_image: null,                // only holds File object
            imagePreview: null,             // preview of File or existing image
            existingImageName: '',          // filename from DB
            blog_image_url: '',
            tags:[],
            atags:['Resume','CV','New'],
            blog_status:'active',
            meta_title:'',
            meta_desc:'',
        }
    },
    created() {
        this.getBlogtoEdit();
    },
    mounted() {
        this.blog_image_url = `/${this.existingImageName}`;
        this.imagePreview = this.blog_image_url;
    },
    watch: {
        existingImageName(newVal) {
            if (newVal) {
                this.blog_image_url = `/${newVal}`;
                this.imagePreview = this.blog_image_url;
            }
        }
    },
    methods:{
        getBlogtoEdit(){
            axios.get('/api/admin/blog/update/'+this.blog_id)
                .then((resp)=>{
                    this.ablog = resp.data.blog;
                    this.blog_title = resp.data.blog.blog_title;
                    this.blog_status = resp.data.blog.blog_status;
                    this.tags = resp.data.blog.tags;
                    this.existingImageName  = resp.data.blog.blog_image;
                    if (this.existingImageName) {
                        this.blog_image_url = `/${this.existingImageName}`;
                        this.imagePreview = this.blog_image_url;
                    }
                    this.meta_title = resp.data.blog.meta_title;
                    this.meta_desc = resp.data.blog.meta_desc;
                    this.quillContent = resp.data.blog.blog_description;
                    const quill = this.$refs.quillRef.getQuill()
                    if (quill.getLength() <= 1) {
                        quill.clipboard.dangerouslyPasteHTML(this.quillContent);
                        const html = quill.root.innerHTML;
                        this.quillContent = html;
                    }
                })
        },
        onImageChange(event) {
            const file = event?.target?.files?.[0];
            if (file && file instanceof File) {
                this.blog_image = file;
                this.imagePreview = URL.createObjectURL(file);
            } else {
                // Reset preview to original image if cleared
                this.blog_image = null;
                this.imagePreview = this.blog_image_url || null;
            }
        },
        updateBlogData(){
            const uheaders = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            const ndata = new FormData();
            ndata.append('blog_title',this.blog_title);

            if (this.blog_image instanceof File) {
                ndata.append('blog_image', this.blog_image);
            }
            ndata.append('blog_description',this.quillContent);
            this.tags.forEach((tag, index) => {
                ndata.append(`tags[${index}]`, tag);
            });
            ndata.append('blog_status',this.blog_status);
            ndata.append('meta_title',this.meta_title);
            ndata.append('meta_desc',this.meta_desc);

            axios.post('/api/admin/blog/update/'+this.blog_id,ndata,uheaders)
                .then((resp)=>{
                    this.getBlogtoEdit();
                })
                .catch((err)=>{
                    alert(err.message);
                })
            console.log('ndata',ndata);
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
