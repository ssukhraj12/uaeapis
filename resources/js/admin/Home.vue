<template>
    <div>
        <h2>Home Dashboard Page</h2>
        <v-row>
             <v-col cols="12" md="6">
                 <v-list>
                     <v-list-item prepend-icon="mdi-web">
                         <a href="https://www.yourresumewriter.com/" target="_blank">yourresumewriter.com</a>
                     </v-list-item>
                     <v-list-item prepend-icon="mdi-react">
                         <v-list-item-title>Framework</v-list-item-title>
                         <v-list-item-subtitle>
                             NextJs
                         </v-list-item-subtitle>
                     </v-list-item>
                     <v-list-item prepend-icon="mdi-web-check">
                         <v-list-item-title>Meta Title</v-list-item-title>
                         <v-list-item-subtitle>
                             Professional Resume Writing Services in Dubai, UAE
                         </v-list-item-subtitle>
                     </v-list-item>
                     <v-list-item prepend-icon="mdi-web-check">
                         <v-list-item-title>Meta Description</v-list-item-title>
                             Looking for top resume writing services in Dubai? Your Resume Writer's expert CV writers create tailored resumes to showcase your skills and help you stand out.
                     </v-list-item>
                 </v-list>
             </v-col>
            <v-col cols="12" md="6">
                <v-card>
                    <v-card-title>Social Image</v-card-title>
                    <v-img src="/images/media.jpeg"></v-img>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card class="border-sm">
                    <v-card-title>Blogs</v-card-title>
                    <v-card-text>
                        Our Blogs
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
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
