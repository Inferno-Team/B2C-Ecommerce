<template>
  <div class="side-bar" :class="[sideBarIsCollapsed ? 'collapsed' : '']">
    <b-col>
      <div
        
        :style="isCollapsedStyle"
        class="menu-item-container p-4"
      >
        <div
          @click="collapseSideBar"
          class="m-auto menu-item"
          :class="[sideBarIsCollapsed ? 'h4' : 'h1']"
        >
          <b-icon style="color: white" icon="menu-button-wide"></b-icon>
        </div>
      </div>
      <b-col class="menu-items mt-5">
        <b-col :style="onCollapse" class="p-1 sidebar-menu-item">
          <b-img src="/storage/images/man.svg"/>
          <div
            id="Men"
            @click.prevent="moveToSectionPage"
            :style="hiddenOnCollapse"
            class="h6 ms-1 name"
          >
            Men
          </div></b-col
        >
        <b-col :style="onCollapse" class="p-1 sidebar-menu-item">
          <b-img src="/storage/images/woman.svg" alt="woman image" />

          <div
            id="Woman"
            @click.prevent="moveToSectionPage"
            :style="hiddenOnCollapse"
            class="h6 ms-1 name"
          >
            Woman
          </div>
        </b-col>
        <b-col :style="onCollapse" class="p-1 sidebar-menu-item">
          <b-img src="/storage/images/children.svg" alt="Children image" />
          <div
            id="Children"
            @click.prevent="moveToSectionPage"
            :style="hiddenOnCollapse"
            class="h6 ms-1 name"
          >
            Children
          </div>
        </b-col>
      </b-col>
    </b-col>
  </div>
</template>
<script>

export default {
  methods: {
    collapseSideBar() {
      this.sideBarIsCollapsed = !this.sideBarIsCollapsed;
      this.$emit("collapsed", this.sideBarIsCollapsed);
    },
    moveToSectionPage(event) {
      var name = event.target.id;
      this.$router.push({
        name: "section-page",
        params: {
          secName: name,
        },
      });
    },
  },
  data() {
    return {
      sideBarIsCollapsed: false,
    };
  },
  computed: {
    isCollapsedStyle() {
      return {
        height: this.sideBarIsCollapsed ? "4rem" : "8rem",
      };
    },
    hiddenOnCollapse() {
      return {
        opacity: this.sideBarIsCollapsed ? "0" : "1",
        // visibility: this.sideBarIsCollapsed ? "hidden" : "visible",
        // display: this.sideBarIsCollapsed ? "none" : "block",
        transform: this.sideBarIsCollapsed
          ? "translateY(10px)"
          : "translateY(0px)",
        transition: "0.5s",
        color:"var(--text-color)"
      };
    },
    onCollapse() {
      return {
        "flex-direction": this.sideBarIsCollapsed ? "column" : "row",
        transition: "0.5s",
      };
    },
  },
};
</script>
<style scoped>
.side-bar {
  height: 100%;
  background: #eee;
  box-shadow: 2px 0px 32px var(--wave-color);
  width: 8rem;
  transition: 0.5s;
}
.collapsed {
  width: 4rem;
}
.menu-item {
  max-width: fit-content;
  cursor: pointer;
  transition: 0.5s;
}
.menu-item-container {
  display: flex;
  justify-content: center;
  background: var(--text-color);
  transition: 0.5s;
}
.menu-items {
  text-align: center;
  display: flex;
  flex-direction: column;
  height: 20rem; /* ~ 320 px */
  justify-content: space-around;
  align-items: center;
}
.sidebar-menu-item {
  cursor: pointer;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 80px;
}
.name {
  opacity: 1;
  transform: translateY(0px);
}
.sidebar-menu-item:hover .name {
  opacity: 1 !important;
  transform: translateY(0px) !important;
}
.sidebar-menu-item img {
  width: 2rem;
}
</style>