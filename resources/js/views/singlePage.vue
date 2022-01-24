<template>
  <div>
    <div class="big-newstitlebox">
      <div class="newstitle">
        <h4 v-if="!screen_shot">螢幕截圖需要等一段時間才會出來</h4>
        <h1><a :href="url">{{title}}</a>  </h1>
        <img :src="screen_shot" alt="">
      </div>
    </div>
    <div class="dotline"></div>
    <div class="newscontain">
      <p v-html="content" >
        {{ content }}
      </p>
    </div>
    <div class="browse">
      <p>作者: {{creator}} </p>
      <p>發布時間: {{created_at}} </p>
      <p>瀏覽次數: {{number}} </p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    meta: {},
  },
  data(){
    return{
      title:"",
      content:"",
      url:"",
      number:"",
      creator:"",
      created_at:"",
      screen_shot:"",
    }
  },
  created() {
    let vm = this ; 
    axios.post('api/crawl/single', {
        url: vm.meta,
    })
    .then(function (response) {
        vm.setData(response.data);                 
    })
    .catch(function (error) {
        console.log(error);
    });

    axios.post('api/crawl/ScreenShot', {
        url: vm.meta,
    })
    .then(function (response) {
        vm.screen_shot = response.data ;                  
    })
    .catch(function (error) {
        console.log(error);
    });
  },
  methods:{
    setData(data){
      this.title = data.title ; 
      this.content = this.setContent(data.content);
      this.creator = data.created_at[0];
      this.created_at = data.created_at[1];
      this.number = data.created_at[2];
      this.url = data.url ; 
    },
    setContent(data){
      let content = "" ; 
      data.forEach(function(item){
        if(item !=""){
          content += item
        }
      })
      return content ; 
    }
  },
}
</script>

<style>

</style>