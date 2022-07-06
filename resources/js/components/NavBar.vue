<template>
  <div class="p-1 nav-bar-local me-auto" :style="navBarWidth">
    <b-row style="height: 100%">
      <div
        class="centered-item ms-4"
        :style="brandStyle"
        style="transition: 0.5s"
        @click.prevent="moveToHomePage"
      >
        <b-img src="/storage/images/logo.png" width="64px" />
        <div class="h6 logo-name-text">Syrian E-commerce</div>
      </div>
      <div style="margin-left: 15%; max-width: fit-content" class="h4">
        {{ routeName }}
      </div>
      <div class="ms-auto h4 me-4" style="max-width: fit-content">
        <b-row class="left-items">
          <b-col class="item-container" :class="[isAdmin ? 'displayNone' : '']"
            ><b-icon
              class="fav-btn"
              style="color: var(--button-color); cursor: pointer"
              icon="heart"
              @click.prevent="moveToFav"
            ></b-icon>
            <div class="fav-text">Favorite</div></b-col
          >
          <b-col class="item-container" :class="[isAdmin ? 'displayNone' : '']"
            ><b-icon
              class="search-btn"
              style="color: var(--button-color); cursor: pointer"
              icon="search"
            >
            </b-icon>
            <div class="search-text">Search</div></b-col
          >

          <b-col class="item-container" :class="[isAdmin ? 'displayNone' : '']">
            <b-icon
              class="cart-btn"
              style="color: var(--button-color); cursor: pointer"
              icon="cart"
              @click.prevent="moveToCart"
            >
            </b-icon>
            <div class="cart-text">Cart</div></b-col
          >
          <b-col class="item-container" v-if="isAdmin"
            ><b-icon
              class="add-btn"
              style="color: var(--button-color); cursor: pointer"
              icon="plus-lg"
              @click.prevent="moveToAddProduct"
            ></b-icon>
            <div class="add-text">Add Product</div></b-col
          >
          <b-col v-if="isLoggedIn">
            <b-button
              style="transition: 0.5s"
              class="inline-button"
              @click.prevent="logout"
              >Logout</b-button
            ></b-col
          >
          <b-col v-if="!isLoggedIn">
            <b-button
              style="transition: 0.5s"
              class="inline-button"
              @click.prevent="moveToLoginPage"
              >Login</b-button
            ></b-col
          >
          <b-col v-if="!isLoggedIn"
            ><b-button
              style="transition: 0.5s"
              class="outline-button"
              @click.prevent="moveToSignUpPage"
              >SignUp</b-button
            ></b-col
          >
          <b-col v-if="isLoggedIn"
            ><b-button
              style="transition: 0.5s"
              class="outline-button"
              @click.prevent="moveToSignUpPage"
              >{{ dashboardOrAccount }}</b-button
            ></b-col
          >
        </b-row>
      </div>
    </b-row>
  </div>
</template>

<script>
export default {
  props: ["isCollapsed"],
  mounted() {
    var token = localStorage.getItem("b2c-user-token");
    var role = localStorage.getItem("b2c-user-type");
    this.isLoggedIn = token != undefined && token != null;
    this.dashboardOrAccount = role === "admin" ? "Dashboard" : "Account";
    this.isAdmin = role === "admin";
  },

  computed: {
    navBarWidth() {
      return {
        left: this.isCollapsed ? "4rem" : "8rem",
        width: this.isCollapsed ? "calc(100% - 4rem )" : "calc(100% - 8rem)",
        height: this.isCollapsed ? "4rem" : "8rem",
      };
    },
    brandStyle() {
      return {
        "font-size": this.isCollapsed ? "1.8rem" : "2.2rem",
      };
    },
  },
  methods: {
    moveToLoginPage() {
      this.$router.push({ name: "login-page" });
    },
    moveToSignUpPage() {
      this.$router.push({ name: "signup-page" });
    },
    moveToHomePage() {
      this.$router.push({ name: "home-page" });
    },
    moveToCart() {
      this.$router.push({ name: "cart-page" });
    },
    moveToFav() {
      this.$router.push({ name: "fav-page" });
    },
    moveToAddProduct() {
      this.$router.push({ name: "add-page" });
    },

    logout() {
      localStorage.removeItem("b2c-user-token");
      localStorage.removeItem("b2c-user-type");
      location.reload();
    },
  },
  data() {
    return {
      isLoggedIn: false,
      dashboardOrAccount: "",
      isAdmin: Boolean,
      routeName: "",
    };
  },
  watch: {
    $route(to, from) {
      switch (to.name) {
        case "cart-page":
          this.routeName = "My Shopping Cart";
          break;
        case "section-page":
          this.routeName = "Section";
          break;
        case "fav-page":
          this.routeName = "Favorite";
          break;

        default:
          this.routeName = "";
          break;
      }
      // if (to.name === "cart-page") ";
    },
  },
};
</script>
<style scoped>
.nav-bar-local {
  background: #eee;
  box-shadow: 2px 0px 32px var(--wave-color);
  transition: 0.5s;
  position: absolute;
  top: 0;
  overflow: hidden;
  height: 8rem;
}
.centered-item {
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  max-width: fit-content;
  transition: 0.5s;
  cursor: pointer;
}
.row {
  align-items: center;
}
.left-items {
  width: 450px;
  justify-content: space-evenly;
}

.item-container {
  align-items: center;
  text-align: center;
}
.add-text {
  margin-left: -1rem;
}
.fav-text,
.add-text,
.search-text,
.cart-text {
  opacity: 0;
  transition: 0.5s;

  font-size: 0.8rem;
  margin-top: 0.1rem;
  position: absolute;
  text-align: center;
  width: 65px;
  transform: translateY(20px);
  color: var(--text-color);
}
.fav-btn:hover ~ .fav-text,
.search-btn:hover ~ .search-text,
.add-btn:hover ~ .add-text,
.cart-btn:hover ~ .cart-text {
  opacity: 1;
  transform: translateY(0px);
}
.displayNone {
  visibility: hidden;
}
.logo-name-text {
  transform: translateX(50px);
  opacity: 0;
  transition: 0.5s;
}
.centered-item:hover .logo-name-text {
  transform: translateX(0px);
  opacity: 1;
}
</style>