<template>
  <b-container>
    <product-item v-for="(prod, index) in prods" :key="index" :prod="prod" />
  </b-container>
</template>
<script>
import ProductItem from "../components/ProductItem.vue";
export default {
  components: { ProductItem },
  props: ["secName"],

  watch: {
    secName: function (nV, oV) {
      var token = localStorage.getItem("b2c-user-token");
      var isLoggedIn = token != undefined && token != null;

      if (!isLoggedIn) {
        this.$toast.warning("You need to log in first", {
          pauseOnHover: true,
        });
        this.$router.push({ name: "home-page" });
      } else {
        this.loadSectionProducts();
      }
    },
  },

  data() {
    return {
      prods: [],
    };
  },
  mounted() {
    var token = localStorage.getItem("b2c-user-token");
    var isLoggedIn = token != undefined && token != null;

    if (!isLoggedIn) {
      this.$toast.warning("You need to log in first", {
        pauseOnHover: true,
      });
      this.$router.push({ name: "home-page" });
    } else {
      this.loadSectionProducts();
    }
  },
  methods: {
    loadSectionProducts() {
      axios
        .get(`/api/get-section-product/${this.$props.secName}`)
        .then((response) => {
          if (response.data.code == 200) {
            this.prods = response.data.prods;
          } else {
            this.$toast.error(response.data.msg);
          }
        })
        .catch((err) => {
          this.$toast.error(err);
        });
    },
  },
};
</script>