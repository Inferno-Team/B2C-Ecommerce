<template>
  <div class="m-1 p-2 mx-auto max-width">
    <b-row>
      <b-col
        class="m-4 p-3 mx-auto max-width"
        :style="backgroundImage"
        style="background: var(--wave-color-50per); border-radius: 8px"
      >
        <b-img
          :src="item.product.images[0].image_url"
          style="width: 80px; height: 120px"
          id="image"
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
  methods: {},
  mounted() {},
  data() {
    return {};
  },
  computed: {
    backgroundImage() {
       const colorThief = new ColorThief();
     const images = document.getElementById("image");
      var x = colorThief.getColor(img);

    },
  },
};
</script>
<style scoped>
</style>