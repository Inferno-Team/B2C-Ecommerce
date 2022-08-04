<template>
  <b-row
    @click.prevent="moveToProductPage"
    class="p-4 m-3 h3"
    style="
      cursor: pointer;
      box-shadow: 9px 9px 9px rgba(216, 216, 216, 0.75);
      border-radius: 1rem;
    "
    :id="prod.id"
  >
    <b-img
      :src="prod.images[0].image_url"
      class="first-image mt-3 image"
      id="product-img"
    />
    <b-col class="h4 b-2 my-3 mx-4" v-if="prod" style="width: 24rem">
      <div class="h3 b-2 my-1 mx-auto">{{ prod.name }}</div>
      <div class="h6 b-2 my-4 mx-auto" style="color: var(--button-color)">
        {{ prod.price }} S.P
      </div>
      <div class="h6 my-5 py-2 w200">{{ prod.dscription }}</div>
    </b-col>
  </b-row>
</template>
<script>
export default {
  props: ["prod"],
  methods: {
    moveToProductPage(event) {
      this.$router.push({
        name: "product-page",
        params: {
          id: this.prod.id,
        },
      });
    },
  },
};
</script>
<style scoped>
.image {
  object-fit: contain;
}
.first-image {
  width: 15rem;
  height: 20rem;
  border-radius: 8px;
}
</style>