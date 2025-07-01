<template>
    <div>
        <v-row align="center">
            <v-col cols="12" md="6" class="d-flex align-center">
                <h2>Add New Photo</h2>
            </v-col>
            <v-col cols="12" md="6" class="text-end">
                <v-btn :to="{name:'photos'}" color="success" class="text-none" density="comfortable" prepend-icon="mdi-plus">
                    Photos
                </v-btn>
            </v-col>
        </v-row>
        <v-form v-model="photoform" @submit.prevent="addNewPhoto">
            <v-row>
                <v-col cols="12" md="8">
                    <v-card class="border-sm">
                        <v-card-title>Title</v-card-title>
                        <v-card-text>
                            <div>
                                <v-text-field v-model="photo_title" label="Photo title" variant="underlined"
                                              :rules="titleRule"></v-text-field>
                            </div>
                        </v-card-text>
                    </v-card>
                    <v-card class="border-sm mt-3">
                        <v-card-title>Description</v-card-title>
                        <v-card-text>
                            <div>
                                <v-textarea v-model="photo_description" rows="10" label="Photo Description"  variant="underlined"></v-textarea>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card>
                        <v-card-title>Image</v-card-title>
                        <v-card-text>
                            <v-file-upload v-model="photo_url" title="Add New Photo" icon="mdi-image" browse-text="Browse Photo" density="compact"
                                           clearable :rules="photoRule"></v-file-upload>
                        </v-card-text>
                    </v-card>
                    <v-card>
                        <v-card-text>
                            <v-btn type="submit" :disabled="!photoform" color="success" density="default">Save</v-btn>
                        </v-card-text>
                    </v-card>

                </v-col>
            </v-row>
        </v-form>
    </div>
</template>
<script>
import {VFileUpload} from "vuetify/labs/components";

export default{
    name:"PhotoAdd",
    components:{VFileUpload},
    data(){
        return{
            photoform:false,
            mtitle:"Main Photo",
            photo_title:'',
            photo_description:'',
            photo_url:null,
            photo_status:'active',
            titleRule:[
                (v) => !!v || "Title is required",
                (v) => (v && v.length <= 100) || "Title max 100 characters"
            ],
        }
    },
    methods:{
        addNewPhoto(){
            if (!this.photo_url) {
                Toast.error("Please select a photo");
                return;
            }
            if (this.photo_url.size > 2 * 1024 * 1024) {
                Toast.error("Image must be less than 2MB");
                return;
            }
            const uheaders = {headers: {'Content-Type': 'multipart/form-data'}}
            const pdata = {
                photo_title:this.photo_title,
                photo_description:this.photo_description,
                photo_url:this.photo_url,
                photo_status:this.photo_status,
            }
            console.log('pdata',pdata);
            axios.post('/api/admin/photo/add',pdata,uheaders)
                .then((resp)=>{
                    if(resp.data.status){
                        const photo_id = resp.data.photo.photo_id;
                        this.$router.push({name:'photoedit',params:{photo_id:photo_id}})
                    }
                })
                .catch((error)=>{
                   alert(error.message);
                })

        }
    }
}
</script>

<style scoped>

</style>
