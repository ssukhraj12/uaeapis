<template>
    <div>
        <v-row align="center">
            <v-col cols="12" md="6" class="d-flex align-center">
                <h2>Rakhee Photos</h2>
            </v-col>
            <v-col cols="12" md="6" class="text-end">
                <v-btn :to="{name:'photoadd'}" color="success" class="text-none" density="comfortable" prepend-icon="mdi-plus">
                    Add New Photo
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-data-table :items="aphotos" :headers="aphotosHeaders">
                <template v-slot:item.photo_url="{item}">
                    <v-img :src="item.photo_url" class="my-2" cover max-width="100" min-height="100" :aspect-ratio="1/1"></v-img>
                </template>
                <template v-slot:item.photo_title="{item}">
                    <div>{{item.photo_title}}</div>
                    <div>{{ truncate(item.photo_description, 80) }}</div>
                </template>
                <template v-slot:item.actions="{item}">
                    <v-btn :href="domain+item.photo_id" target="_blank" size="small"
                           color="primary" class="me-2 mb-2" title="View" prepend-icon="mdi-eye">
                        View
                    </v-btn>
                    <v-btn :to="{name:'photoedit',params:{photo_id:item.photo_id}}" size="small"
                           color="info" variant="elevated" title="edit" prepend-icon="mdi-pencil">
                        Edit
                        </v-btn>
                </template>
            </v-data-table>
        </v-row>
    </div>
</template>
<script>
export default{
    name:"Photos",
    data(){
        return{
            domain:"https://www.rakheemansukhani.com/photo-journal/",
            aphotos:[],
            aphotosHeaders:[
                {title:"Image",value:'photo_url',width:200},
                {title:"Title",value:'photo_title'},
                {title:"Status",value:'photo_status',width: 100},
                {title:"Actions",value:'actions',width: 100}
            ],
        }
    },
    created() {
        this.getAllPhotos();
    },
    methods:{
        truncate(text, length) {
            if (!text) return '';
            return text.length > length ? text.substring(0, length) + '…' : text;
        },
        getAllPhotos(){
            axios.get('/api/admin/photos')
                .then((resp)=>{
                    this.aphotos = resp.data.photos;
                    console.log('this.aphotos',this.aphotos)
                })
        }
    }
}
</script>

<style scoped>

</style>
