<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" >
                <div style="margin-top:30px">
                    <p>
                        測試網址為： {{test_url}} 
                        <button style="margin-left:10px" class="btn btn-secondary" @click="copy">複製到下方</button>
                    </p>
                    
                </div>
                <div class="card" style="padding:10px">                    
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-default">請輸入網址</span>
                        <input type="text" class="form-control" v-model="url">
                        <button class="btn btn-primary" @click="submit">送出</button>
                    </div>
                    
                    <v-client-table :columns="columns" :data="tableData" :options="options">
                        <div slot="title" slot-scope="{ row }">
                            <a :href="row.url"> {{ row.title }} </a>
                        </div>
                        <div slot="content" slot-scope="{ row }">
                            <a href="javascript:void(0)" @click="single_page(row)"> {{ row.content }} </a>
                        </div>
                    </v-client-table>
                    
                </div>
            </div>
        </div>
        <el-dialog
            :close-on-click-modal="false"
            
            :visible.sync="dialogForm"
            width="85%"
            v-if="dialogForm"
            >
            <singlePage
                v-if="dialogForm"
                :meta="page_url"
                @close="dialogForm = false"
            ></singlePage>
        </el-dialog>
    </div>
</template>

<script>
import axios from 'axios'
import singlePage from "./singlePage.vue"

    export default {
        components: { singlePage },
        data(){
            return{
                test_url:"https://wealth.businessweekly.com.tw/",
                url:"",
                dialogForm: false,
                page_url:"",
                
                tableData:[],
                columns: [      
                    'title',
                    "content",
                    "created_at",
                ],
                options: {
                    sortable: [
                        "domain",
                        'title',
                        "content",
                        "url",
                        "created_at",
                    ],
                    sortIcon: {
                        base: "fa",
                        is: "fa-sort",
                        up: "fa-sort-up",
                        down: "fa-sort-down",
                    },
                    headings: {
                        title: "文章標題",
                        content:"文章內容",
                        url: "文章網址",
                        created_at: "建立時間",                        
                    },
                    perPage:5,
                },
                
            }
        },
        mounted() {
        },
        methods:{
            submit(){
                let vm = this ; 
                axios.post('api/crawl', {
                    url: vm.url,
                })
                .then(function (response) {
                    vm.tableData = response.data ;                     
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            copy(){
                this.url = this.test_url ; 
            },
            single_page(row){
                this.page_url = row.url;
                this.dialogForm = true;
            }
        }
    }
</script>

<style lang="scss">
@import "~bootstrap/scss/bootstrap";
</style>
