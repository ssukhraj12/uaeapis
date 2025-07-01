<template>
    <div>
        <v-row align="center">
            <v-col cols="12" md="6" class="d-flex align-center">
                <h2>Photo Edit</h2>
            </v-col>
            <v-col cols="12" md="6" class="text-end">
                <v-btn :to="{name:'photos'}" color="success" class="text-none" density="comfortable" prepend-icon="mdi-plus">
                    Photos
                </v-btn>
            </v-col>
        </v-row>
        <v-form v-model="photoform" @submit.prevent="editPhoto">
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
                                <v-textarea v-model="photo_description" rows="10" label="Photo Description"
                                            variant="underlined" auto-grow></v-textarea>
                            </div>
                        </v-card-text>
                    </v-card>
                    <v-card class="border-sm mt-3" v-if="rphotos.length > 0">
                        <v-row>
                            <v-col v-for="(rphoto,index) in rphotos" key="index" cols="12" md="4">
                                <v-img :src="'/'+rphoto.rphoto_url" cover class="mb-3"></v-img>
                            </v-col>
                        </v-row>
                    </v-card>
                    <v-card class="border-sm mt-3" v-else>
                        <v-card-text>
                            <v-file-upload v-model="arphotos" title="Add New Photos" icon="mdi-image"
                                           density="compact" multiple clearable></v-file-upload>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card>
                        <v-card-title>Image</v-card-title>
                        <v-card-text>
                            <v-img v-if="exist_image" :src="'/'+exist_image" cover class="mb-3"></v-img>
                            <v-file-upload v-model="photo_url" title="Add New Photo" icon="mdi-image"
                                           density="compact" clearable></v-file-upload>
                        </v-card-text>
                    </v-card>
                    <v-card>
                        <v-card-text>
                            <v-btn type="submit" :disabled="!photoform" color="success" density="default">Update</v-btn>
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
    name:"PhotoEdit",
    components: {VFileUpload},
    props:{
        photo_id:[Number,String]
    },
    data(){
        return{
            sphoto:[],
            rphotos:[],
            arphotos:[],
            photoform:false,
            mtitle:"Main Photo",
            photo_title:'',
            photo_description:'',
            photo_url:null,
            exist_image:null,
            photo_status:'active',
            titleRule:[
                (v) => !!v || "Title is required",
                (v) => (v && v.length <= 100) || "Title max 100 characters"
            ],
        }
    },
    created() {
        this.getPhotoData();
    },
    methods:{
        getPhotoData(){
            axios.get('/api/admin/photo/update/'+this.photo_id)
                .then((resp)=>{
                    this.sphoto = resp.data.photo;
                    this.photo_title = resp.data.photo.photo_title;
                    this.photo_description = resp.data.photo.photo_description;
                    this.exist_image = resp.data.photo.photo_url;
                    this.rphotos = resp.data.photo.rphotos;
                    console.log(resp.data);
                })
        },
        editPhoto(){
            if (this.photo_url instanceof File && this.photo_url.size > 2 * 1024 * 1024) {
                Toast.error("Image must be less than 2MB");
                return;
            }

            const pdata = new FormData();
            pdata.append('photo_title', this.photo_title);
            pdata.append('photo_description', this.photo_description);
            pdata.append('photo_status', this.photo_status);

            if (this.photo_url instanceof File) {
                pdata.append('photo_url', this.photo_url);
            }
            this.arphotos.forEach((file, index) => {
                pdata.append(`arphotos[]`, file);
            })
            // console.log('pdata',pdata);
            const uheaders = {headers: {'Content-Type': 'multipart/form-data'}}
            axios.post('/api/admin/photo/update/'+this.photo_id,pdata,uheaders)
                .then((resp)=>{
                    if(resp.data.status){
                        Toast.success(resp.data.message);
                        this.getPhotoData();
                        this.photo_url = null;
                    }
                })
                .catch((error)=>{
                    Toast.error(error.message)
                })
        }
    }
}
</script>

<style scoped>

</style>
