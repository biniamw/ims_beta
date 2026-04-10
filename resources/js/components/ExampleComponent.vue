<template>
    <li  class="nav-item dropdown dropdown-notification mr-25"><a class="nav-link" href="javascript:void(0);" data-toggle="dropdown"><i class="ficon" data-feather="bell"></i><span class="badge badge-pill badge-danger badge-up">{{unreadNotification.length}}</span></a>
  <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right" role="menu">
     <li class="dropdown-menu-header" >
       <div class="dropdown-header d-flex">
        <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
       <div class="badge badge-pill badge-light-primary"></div>
        </div>
        </li>
          <div style="overflow-y: scroll; height:400px;">
              <li v-if="unreadNotification.length > 0" >  <notification-item v-for="punread in unreadNotification" v-bind:key="punread.id"
                :unread="punread"></notification-item> 
              </li>
              </div>
              <li v-if="unreadNotification.length==0"><a href="">No Notification is available</a></li>
          
          <li class="dropdown-menu-footer" v-if="unreadNotification.length > 0" @click="markNotificationAsRead"><a class="btn btn-primary btn-block" href="/">Read all notifications</a></li>
 </ul>   

    </li>
</template>
<script>
   import NotificationItem from './NotificationItem.vue';
    export default {
        props: ['unreads', 'userid'],
       components: {NotificationItem},
       data() {
          return {
            unreadNotification: this.unreads,
            totalUnreadNotification: this.unreads.length
           }
         },
         methods: {
            markNotificationAsRead() {
            if (this.totalUnreadNotification) {
              axios.get('/markasread');
              this.totalUnreadNotification = 0;
                 }
                },
             showUserProfile(notify) {
      // If it's okay let's create a notification
             var notification = new Notification(notify.username + " "+notify.message);
           notification.onclick = function (event) {
           event.preventDefault(); // prevent the browser from focusing the Notification's tab
            window.open('/approver' , '_blank');
      }

    }
         },
        mounted() { 
           
            console.log('Component mounted.');
            console.log('user id='+this.userid);

              Echo.private('App.Models.User.'+this.userid)
              .notification((notification) => {
              console.log(notification);
               let newUnreadNotifications = {data: {username: notification.username, message: notification.message}};
                this.unreadNotification.push(newUnreadNotifications);
              //alert('ss');
              if (!("Notification" in window)) {
               alert("This browser does not support desktop notification");
              }

              else if (Notification.permission === "granted") {
                 this.showUserProfile(notification);
             }

             else if (Notification.permission !== "denied") {
            Notification.requestPermission(function (permission) {
              // If the user accepts, let's create a notification
              if (permission === "granted") {
                this.showUserProfile(notify);
              }

            });
          }



            });
        }
    }
</script>
