<template>
    
</template>
<script>
export default {
     mounted() {
    var token = localStorage.getItem("b2c-user-token");
    var isLoggedIn = token != undefined && token != null;

    if (!isLoggedIn) {
      this.$toast.warning("You need to log in first", {
        pauseOnHover: true,
        
      });
      this.$router.push({ name: "home-page" });
    }
  },
}
</script>