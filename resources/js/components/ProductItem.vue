<template>
  <div
    class="p-4 m-3 h3"
    style="cursor: pointer"
    :id="prod.id"
    @click.prevent="moveToProductPage"
  >
    {{ prod.name }}
  </div>
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