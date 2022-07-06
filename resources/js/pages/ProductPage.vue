<template>
  <b-container>
    <b-row v-if="product.id">
      <b-col style="max-width: fit-content" class="ms-auto me-auto">
        <b-row>
          <b-img
            :src="firstImageUrl"
            class="first-image mt-3 image"
            id="product-img"
            :style="productImageStyle"
          />
          <b-col class="h4 b-2 my-3 mx-4" v-if="product" style="width: 24rem">
            <div
              class="h6 b-2 mt-3 mx-auto w-500"
              v-if="product.category"
              style="color: var(--wave-color-2)"
            >
              {{ product.category.category_name }}
            </div>
            <div class="h3 b-2 my-1 mx-auto">{{ product.name }}</div>
            <div class="h6 b-2 my-4 mx-auto" style="color: var(--button-color)">
              {{ product.price }} S.P
            </div>
            <div class="h6 my-5 py-2 w200">{{ product.dscription }}</div>
            <b-row style="justify-content: space-evenly">
              <b-button class="fav-button" style="max-width: fit-content">
                <b-icon
                  class="mx-2"
                  style="color: var(--wave-color); cursor: pointer"
                  icon="heart"
                  @click.prevent="moveToAddProduct"
                ></b-icon>
                Add To Favourite</b-button
              >
              <b-button
                @click.prevent="addToCart"
                class="inline-button"
                style="max-width: fit-content"
              >
                <b-icon
                  class="add-btn mx-2"
                  style="color: white; cursor: pointer"
                  icon="cart"
                  @click.prevent="moveToAddProduct"
                ></b-icon>
                Add To Cart</b-button
              >
            </b-row>
          </b-col>
        </b-row>
        <b-row style="width: 17rem">
          <b-img
            v-for="(image, index) in product.images"
            :key="index"
            :style="productImageStyle"
            :src="image.image_url"
            :id="index"
            @click.prevent="onImageClick"
            style="cursor: pointer"
            class="second-image mt-2 ms-auto me-auto image"
          />
        </b-row>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import ColorThief from "color-thief";
export default {
  props: ["id"],
  data() {
    return {
      product: {},
      imageColor: [],
      firstImageUrl: "",
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
      this.loadProduct();
    }
  },
  methods: {
    getColor(img) {
      const colorThief = new ColorThief();
      //   var x = colorThief.getPalette(img, 5);
      var x = colorThief.getColor(img);
      this.imageColor = x;
    },
    loadProduct() {
      axios
        .get(`/api/get-product-by-id/${this.id}`)
        .then((response) => {
          if (response.data.code == 200) {
            this.product = response.data.product;
            this.firstImageUrl = this.product.images[0].image_url;
            setTimeout(() => {
              this.applyImageLoading();
            }, 1);
          } else this.$toast.error(response.dataq.msg);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    applyImageLoading() {
      const images = document.getElementsByClassName("image");
      // var firstItem = document.getElementById(0);

      images.forEach((image) => {
        image.addEventListener("load", () => {
          this.getColor(image);
          if (images[1] === image)
            images[1].style.border = `1px solid rgb(${this.imageColor})`;
        });
      });
    },
    onImageClick(e) {
      const index = e.target.id;
      for (let i = 0; i < this.product.images.length; i++) {
        document.getElementById(i).style.border = "";
      }

      this.firstImageUrl = this.product.images[index].image_url;
      e.target.style.border = `1px solid rgb(${this.imageColor})`;
    },
    addToCart() {
      axios
        .post("/api/add-product-to-cart", { id: this.$props.id })
        .then((response) => {
          let res = response.data;
          if (res.code == 200) {
            this.$toast.success(res.msg);
          } else {
            this.$toast.warning(res.msg);
          }
        })
        .catch((error) => {
          this.$toast.error("something went wrong please try again later.");
        });
    },
  },
  computed: {
    productImageStyle() {
      return {
        "box-shadow": `9px 9px 9px rgba(${this.imageColor},0.75)`,
      };
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
.second-image {
  width: 4rem;
  height: 5rem;
  border-radius: 4px;
}
</style>