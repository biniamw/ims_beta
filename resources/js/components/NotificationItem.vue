<template>
<div>
   <li class="scrollable-container media-list mb-0">
      <a class="d-flex" :href="userUrl">
         <div class="media d-flex align-items-start">
               <div class="media-left">
                  <div class="avatar">
                     <img src="app-assets/images/portrait/small/default-profile-pic.jpg" alt="avatar" width="32" height="32">
                  </div>
               </div>
               <div class="media-body">
                  <p class="media-heading"><span class="font-weight-bolder"> {{ unread.data.username }}  </span></p><small class="notification-text"> {{ unread.data.message }}.</small>
               </div>
         </div>
      </a>
   </li>
</div>
</template>

<script>

export default {
   props:['unread'],
   data(){
     return{
        userUrl:""
     }
   },
   mounted(){
       console.log('liis is here');
    this.userUrl = "/admin/user/profile/"+this.unread.id
   }
}
</script>
