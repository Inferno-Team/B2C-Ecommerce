<template>
  <div class="m-1 p-2 mx-auto max-width">
    <b-row>
      <b-col class="m-4 p-3 mx-auto max-width">
        <b-img
          :src="item.product.images[1].image_url"
          style="width: 80px; height: 120px"
          :style="shadow"
          class="image"
          :id="`image-${item.id}`"
          @click.prevent="openItem"
        />
      </b-col>
      <b-col
        ><div class="text-center h6 w-400">{{ item.product.name }}</div></b-col
      >
    </b-row>
  </div>
</template>
<script>
import ColorThief from "color-thief";

export default {
  props: ["item"],
  methods: {
    applyImageLoading() {
      const image = document.getElementById(`image-${this.item.id}`);
      // var firstItem = document.getElementById(0);
      image.addEventListener("load", () => {
        setTimeout(() => this.getColor(image), 100);
      });
      // images.forEach((image) =>
      //   image.addEventListener("load", () => {
      //     setTimeout(() => this.getColor(image), 100);
      //   })
      // );
    },
    getColor(img) {
      const colorThief = new ColorThief();
      var x = colorThief.getColor(img);
      this.imageColor = x;
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
  mounted() {
    this.applyImageLoading();
  },
  data() {
    return {
      imageColor: [],
    };
  },
  computed: {
    shadow() {
      return {
        "box-shadow": `9px 9px 9px rgba(${this.imageColor},0.75)`,
        cursor: "pointer",
      };
    },
  },
};
</script>
<style scoped>
</style>