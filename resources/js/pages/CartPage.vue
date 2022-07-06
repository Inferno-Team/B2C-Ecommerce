<template>
  <div
    style="
      background: rgb(235 235 235 / 52%);
      height: 100vh;
      overflow-y: hidden;
    "
  >
    <b-container
      v-if="cart != null && cart.items != null && cart.items.length > 0"
      class="mt-3 ms-auto me-auto"
      style="max-width: fit-content; background: white; border-radius: 8px"
    >
      <b-row>
        <b-col>
          <div class="mx-5 my-2 p-3 h6">Description</div>
        </b-col>
        <b-col>
          <div class="mx-5 my-2 p-3 h6">Quantity</div>
        </b-col>
        <b-col>
          <div class="mx-5 my-2 p-3 h6">Remove</div>
        </b-col>
        <b-col>
          <div class="mx-5 my-2 p-3 h6">Price</div>
        </b-col>
      </b-row>
      <div
        style="width: 85%; background: grey; padding: 1px"
        class="ms-auto me-auto"
      ></div>
      <b-col class="p-3 ms-3 me-3 my-4" style="overflow-y: auto; height: 60%">
        <cart-item
          v-for="(item, index) in cart.items"
          :key="index"
          :item="item"
          :isFirst="index == 0"
          @removeItem="onRemoveItemClicked"
        />
      </b-col>
    </b-container>
    <div
      v-if="cart != null && cart.items != null && cart.items.length > 0"
      class="floating-container"
    >
      <div class="floating-button" @click.prevent="checkout">
        <b-icon stacked icon="check"></b-icon>
      </div>
    </div>
  </div>
</template>
<script>
import CartItem from "../components/CartItem.vue";
export default {
  beforeDestroy() {
    // check if user want to save the update.
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
      this.loadUserCart();
    }
  },
  methods: {
    loadUserCart() {
      axios
        .get("/api/get-user-cart")
        .then((response) => {
          if (response.data.code == 200) {
            this.cart = response.data.cart;
          } else {
            this.$toast.warning("something went wrong.");
            console.log(response.data);
          }
        })
        .catch((e) => {
          this.$toast.error("something went wrong.");
          console.log(e);
        });
    },
    checkout() {
      // convert this user cart to bill & empty this cart
      // axios
      //   .post("/api/convert-cart-to-bill")
      //   .then((response) => {
      //     var r = response.data;
      //     if (r.code == 200) {
      //       this.$toast.success(r.msg);
      //     } else {
      //       this.$toast.warning(r.msg);
      //     }
      //   })
      //   .catch((err) => {
      //     this.$toast.error("something went wrong please try again later.");
      //   });

      this.$router.push({ name: "checkout" });
    },
    onRemoveItemClicked(item) {
      const index = this.cart.items.indexOf(item);
      
      axios
        .post("/api/remove-item-from-cart", {
          id: item.id,
        })
        .then((response) => {
          if (response.data.code == 200) {
            this.cart.items.splice(index, 1);
            this.$toast.success("item removed");
          }
        })
        .catch((err) => {
          this.$toast.warning("something went wrong please try again later.");
        });
    },
  },
  data() {
    return {
      cart: {
        items: [],
      },
    };
  },
  components: { CartItem },
};
</script>
<style scoped>

</style>