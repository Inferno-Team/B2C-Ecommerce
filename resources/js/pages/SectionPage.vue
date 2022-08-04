<template>
  <b-container class="prod-container">
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
      // var token = localStorage.getItem("b2c-user-token");
      // this.isLoggedIn = token != undefined && token != null;
      this.loadSectionProducts();
    },
  },

  data() {
    return {
      prods: [],
      isLoggedIn: false,
    };
  },
  mounted() {
    // var token = localStorage.getItem("b2c-user-token");
    // this.isLoggedIn= token != undefined && token != null;
    this.loadSectionProducts();
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
<style scoped>
.prod-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  max-width: max-content;
}
</style>