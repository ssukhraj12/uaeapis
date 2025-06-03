<template>
    <div>
        <v-row align="center">
            <v-col cols="12" md="6" class="d-flex align-center">
                <h2>Gallery</h2>
            </v-col>
            <v-col cols="12" md="6" class="text-end">
                <v-btn color="success" class="text-none" density="comfortable" prepend-icon="mdi-plus" @click="addDialog = true">
                    Add New Image
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="12">
                <v-data-table :items="agalleries" :headers="galleryHeaders" class="border">
                    <template v-slot:item.gallery_image="{item}">
                        <v-img v-if="item.gallery_image" :src="item.gallery_image" class="my-2"
                               min-width="200" width="200" height="200" min-height="200"></v-img>
                        <v-img v-else src="https://dummyimage.com/300x300/000/fff&text=No+Image"></v-img>
                    </template>
                    <template v-slot:item.actions="{item}">
                        <v-btn @click="editItem(item)" color="red" density="default">Delete</v-btn>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>
        <v-dialog max-width="400" v-model="addDialog">
            <v-card>
                <v-card-title>Add Image</v-card-title>
                <v-card-text>
                    <v-file-input v-model="agallery_image" accept="image/*" show-size variant="underlined" rounded></v-file-input>
                    <div class="d-flex mt-2">
                        <v-btn @click="addGallery" color="success">Save</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn @click="cancelAdd" color="red">Cancel</v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog max-width="300" v-model="editDialog">
            <v-card>
                <v-card-text class="text-center">
                    <v-img v-if="editedItem.gallery_image" :src="editedItem.gallery_image"></v-img>
                    <v-img v-else src="https://dummyimage.com/300x300/000/fff&text=No+Image"></v-img>
                  Are you sure to delete this Image
                    <div class="d-flex mt-4">
                        <v-btn @click="deleteGallery" color="success">Yes</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn @click="cancelEdit" color="red">No</v-btn>
                    </div>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
export default{
    name:"Gallery",
    data(){
        return{
            addDialog:false,
            editDialog:false,
            agalleries:[],
            galleryHeaders:[
                {title:"Image",value:'gallery_image',width:200},
                {title:"Status",value:'gallery_status',width: 100},
                {title:"Actions",value:'actions',width: 100}
            ],
            agallery_image:null,
            agallery_status:'active',
            editedIndex:-1,
            editedItem:{
                gallery_id:'',
                gallery_image:null,
                gallery_status:'active',
            }
        }
    },
    created() {
        this.getAllGallery();
    },
    methods:{
        getAllGallery(){
            axios.get('/api/admin/gallery')
                .then((resp)=>{
                    this.agalleries = resp.data.galleries;
                })
        },
        addGallery(){
            const gheaders = {headers: {'Content-Type': 'multipart/form-data'}}
            const agal = new FormData();
            agal.append('gallery_image',this.agallery_image);
            agal.append('gallery_status',this.agallery_status);
            axios.post('/api/admin/gallery/add',agal,gheaders)
                .then((resp)=>{
                    this.addDialog = false;
                    this.agallery_image = null;
                    this.getAllGallery();
                })
                .catch((err)=>{
                    alert('err message',err.message)
                })
        },
        cancelAdd(){
            this.addDialog = false;
            this.agallery_image = null;
        },
        editItem(item){
            this.editedIndex = this.agalleries.indexOf(item);
            this.editedItem = Object.assign({},item);
            this.editDialog = true;
        },
        cancelEdit(){
            this.editDialog = false;
        },
        deleteGallery(){
            const gheaders = {headers: {'Content-Type': 'multipart/form-data'}}
            const dgal = new FormData();
            dgal.append('gallery_image',this.editedItem.gallery_image);
            dgal.append('gallery_id',this.editedItem.gallery_id);
            axios.post('/api/admin/gallery/delete/'+this.editedItem.gallery_id,dgal,gheaders)
                .then((respd)=>{
                    console.log("respo",respd);
                    this.editDialog = false;
                    this.agallery_image = null;
                    this.getAllGallery();
                })
                .catch((errd)=>{
                    alert('err message',errd.message)
                })
        },
    },
}

</script>

<style scoped>

</style>
