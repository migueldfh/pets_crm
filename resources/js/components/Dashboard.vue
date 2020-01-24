<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <userList></userList>
            </div>
        </div>
    </div>
</template>
<script>
  import userList from './users-list.vue'
  export default {
    data() {
      return {
        //
      }
    },
    components: {
      userList
    }
  }
</script>
