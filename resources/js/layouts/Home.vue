<template>
  <div>
    <side-bar @collapsed="sideBarCollapsed"></side-bar>
    <nav-bar :isCollapsed="isCollapsed"></nav-bar>
    <router-view :style="onCollapsed" class="inside-home-page"></router-view>
  </div>
</template>
<script>
import NavBar from "../components/NavBar.vue";
import SideBar from "../components/SideBar.vue";
export default {
  components: { SideBar, NavBar },
  methods: {
    sideBarCollapsed(is) {
      this.isCollapsed = is;
    },
  },
  data() {
    return {
      isCollapsed: false,
    };
  },
  computed: {
    onCollapsed() {
      return {
        top: this.isCollapsed ? "4rem" : "8rem",
        left: this.isCollapsed ? "4rem" : "8rem",
        transition: "0.5s",
        width:this.isCollapsed?"calc(100% - 4rem)":"calc(100% - 8rem)"
      };
    },
  },
};
</script>
<style scoped>
.inside-home-page {
  position: absolute;
}
</style>