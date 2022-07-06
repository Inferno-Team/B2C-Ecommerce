<template>
  <b-col>
    <div
      v-if="!isFirst"
      style="
        width: 50%;
        background: var(--secondary-button-color-50per);
        padding: 1px;
      "
      class="my-4 ms-auto me-auto"
    ></div>
    <b-row
      style="align-items: center; "
      
    >
      <b-img
        :src="item.product.images[0].image_url"
        style="width: 64px; height: 64px;cursor: pointer"
        @click.prevent="openItem"
      />
      <b-col style="max-width: 10rem;cursor: pointer" @click.prevent="openItem">
        <div class="h5 ms-3 my-2 w-500">{{ item.product.name }}</div>
        <div class="h6 ms-3 my-2 w-400">Product ID: #{{ item.product.id }}</div>
        <div class="h6 ms-3 my-2 w-300" style="color: var(--button-color)">
          {{ item.product.category.category_name }}
        </div>
      </b-col>
      <div class="px-2 max-width"></div>
      <b-row class="p-2 max-width m-2 h6">
        <div
          @click.prevent="addItemCount"
          class="max-width plus px-auto py-1 h4"
        >
          +
        </div>
        <div class="max-width number px-auto py-2 h6">
          {{ item.item_count }}
        </div>
        <div
          @click.prevent="minusItemCount"
          class="max-width minus px-auto py-1 h4"
        >
          -
        </div>
      </b-row>
      <div class="mx-5 px-2 max-width"></div>
      <div
        @click.prevent="removeThisItem"
        class="max-width exit px-auto py-1 h4"
      >
        x
      </div>
      <div class="mx-5 px-2 max-width"></div>
      <div class="max-width px-auto py-1 h6">{{ item.product.price }} S.P</div>
    </b-row>
  </b-col>
</template>
<script>
export default {
  props: ["item", "isFirst"],
  methods: {
    addItemCount() {
      axios
        .post("/api/increse-cart-item-count", {
          id: this.$props.item.id,
        })
        .then((response) => {
          if (response.data.code == 200) {
            this.$props.item.item_count++;
          }
        })
        .catch((err) => {
          this.$toast.warning("something went wrong please try again later.");
        });
    },
    minusItemCount() {
      if (this.$props.item.item_count > 1) {
        axios
          .post("/api/reduce-cart-item-count", {
            id: this.$props.item.id,
          })
          .then((response) => {
            if (response.data.code == 200) {
              this.$props.item.item_count--;
            }
          })
          .catch((err) => {
            this.$toast.warning("something went wrong please try again later.");
          });
      }
    },
    removeThisItem() {
      this.$emit("removeItem", this.$props.item);
    },
    openItem() {
      this.$router.push({
        name: "product-page",
        params: {
          id: this.item.product.id,
        },
      });
    },
  },
};
</script>
<style scoped>
.plus,
.exit {
  background: var(--icon-color);
  color: white;
  cursor: pointer;
  user-select: none;
}
.exit {
  background: var(--wave-color-2);
}
.number {
  color: black;
  user-select: none;
}
.minus {
  background: rgb(172, 172, 172);
  color: antiquewhite;
  cursor: pointer;
  user-select: none;
}
</style>