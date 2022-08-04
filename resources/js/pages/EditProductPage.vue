<template>
  <b-container v-if="prod != null">
    <b-row>
      <b-col class="m-4">
        <b-row>
          <b-form-group
            label=" Product Name"
            description="Do not exceed 20 characters when entering the product name"
          >
            <b-form-input v-model="prod.name" autocomplete="off" />
          </b-form-group>
        </b-row>
        <b-row class="mt-3">
          <b-col>
            <b-form-group class="ms-1 my-2" label="Category">
              <b-dropdown
                :text="
                  prod.category == null
                    ? 'Select Category'
                    : prod.category.category_name
                "
                variant="outline-secondary"
              >
                <b-dropdown-item
                  @click="prod.cat_name = cat.category_name"
                  v-for="(cat, index) in categories"
                  :key="index"
                  >{{ cat.category_name }}</b-dropdown-item
                >
              </b-dropdown>
            </b-form-group>
          </b-col>
          <b-col>
            <b-form-group
              class="ms-1 my-2"
              label=" Product Price"
              description="Valid number between [1000 , +∞ ]"
            >
              <b-form-input
                style="-webkit-appearance: none"
                min="1000"
                autocomplete="off"
                type="number"
                v-model="prod.price"
              />
            </b-form-group>
          </b-col>
        </b-row>
        <b-row> </b-row>
        <b-row>
          <b-form-group
            class="mt-3"
            label="Product Description"
            description="Do not exceed 100 characters when entering the product name"
          >
            <b-form-textarea
              id="textarea"
              v-model="prod.dscription"
              placeholder="Product Description..."
              rows="6"
              autocomplete="off"
              max-rows="8"
            ></b-form-textarea>
          </b-form-group>
        </b-row>
      </b-col>
      <b-col>
        <div class="h4 mx-2 my-5 px-3">Product Images</div>
        <b-row class="mx-2 my-4">
          <b-col style="height: 10rem">
            <b-img
              v-if="imagesState[0]"
              :src="prod.images[0].image_url"
              class="inner-image"
            />
            <div class="edit-shadow" v-if="imagesState[0]">
              <b-icon
                class="h1"
                color="white"
                id="edit-1"
                style="cursor: pointer; margin: 3rem; cursor: pointer"
                icon="pencil-fill"
                @click.prevent="editImage"
              ></b-icon>
            </div>
            <vue2Dropzone
              ref="image1"
              id="dropzone"
              v-if="!imagesState[0]"
              :options="dropzoneOptions"
            ></vue2Dropzone>
          </b-col>
          <b-col style="height: 10rem">
            <b-img
              v-if="imagesState[1]"
              :src="prod.images[1].image_url"
              class="inner-image"
            />
            <div v-if="imagesState[1]" class="edit-shadow">
              <b-icon
                class="h1"
                color="white"
                id="edit-2"
                style="cursor: pointer; margin: 3rem; cursor: pointer"
                icon="pencil-fill"
                @click.prevent="editImage"
              ></b-icon>
            </div>
            <vue2Dropzone
              ref="image2"
              id="dropzone"
              v-if="!imagesState[1]"
              :options="dropzoneOptions"
            ></vue2Dropzone>
          </b-col>
          <b-col style="height: 10rem">
            <b-img
              v-if="imagesState[2]"
              :src="prod.images[2].image_url"
              class="inner-image"
            />
            <div v-if="imagesState[2]" class="edit-shadow">
              <b-icon
                class="h1"
                color="white"
                id="edit-3"
                style="cursor: pointer; margin: 3rem; cursor: pointer"
                icon="pencil-fill"
                @click.prevent="editImage"
              ></b-icon>
            </div>
            <vue2Dropzone
              ref="image3"
              id="dropzone"
              v-if="!imagesState[2]"
              :options="dropzoneOptions"
            ></vue2Dropzone>
          </b-col>
        </b-row>
        <div class="h6 my-3 p-2" style="color: gray; font-size: 0.85rem">
          You need to add 3 images. Pay acctention to the quality of the
          pictures you add, comply with the backrgound color standards. Picturs
          must be in certain dimensions, Notice that the product shows all the
          details.
        </div>
        <b-row style="justify-content: space-around" class="mt-4">
          <b-button
            @click.prevent="addProduct"
            style="max-width: fit-content"
            class="inline-button"
            >Edit Product</b-button
          >
          <b-button
            style="max-width: fit-content"
            class="outline-button"
            @click.prevent="clear"
            >Clear All Data</b-button
          >
        </b-row>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import { POSITION } from "vue-toastification";
export default {
  props: ["id"],
  components: { vue2Dropzone },
  mounted() {
    var token = localStorage.getItem("b2c-user-token");
    var isLoggedIn = token != undefined && token != null;
    if (!isLoggedIn) this.$router.push({ name: "home-page" });
    else {
      this.loadAllCats();
      this.loadProduct();
    }
  },
  data() {
    return {
      imagesState: [true, true, true],
      prod: null,
      categories: [],
      dropzoneOptions: {
        url: "https://httpbin.org/post",
        autoProcessQueue: false,
        maxFilesize: 0.5,
        addRemoveLinks: true,
        thumbnailWidth: 100,
        thumbnailHeight: 100,
        maxFiles: 1,
        thumbnailMethod: "contain",
      },
    };
  },
  methods: {
    loadAllCats() {
      axios
        .get("/api/get-all-categories")
        .then((response) => {
          if (response.data.code == 200)
            this.categories = response.data.categories;
          else {
            this.$toast.warning("sonething went wrong.");
            console.log(response.data);
          }
        })
        .catch((err) => {
          this.$toast.warning("sonething went wrong.");
          console.log(err);
        });
    },
    addProduct() {
      if (
        this.$refs.image1.getQueuedFiles()[0] == null ||
        this.$refs.image2.getQueuedFiles()[0] == null ||
        this.$refs.image3.getQueuedFiles()[0] == null
      ) {
        this.$toast.warning("you need to choose 3 images please try again.");
      }
      var image1Base64Data = this.$refs.image1.getQueuedFiles()[0].dataURL;
      var image2Base64Data = this.$refs.image2.getQueuedFiles()[0].dataURL;
      var image3Base64Data = this.$refs.image3.getQueuedFiles()[0].dataURL;
      axios
        .post("/api/add-product", {
          ...this.prod,
          images: [image1Base64Data, image2Base64Data, image3Base64Data],
        })
        .then((response) => {
          if (response.data.code == 200) {
            this.clear();
          }

          this.$toast.success(response.data.msg, {
            position: POSITION.BOTTOM_RIGHT,
          });
        })
        .catch((err) => {
          this.$toast.error(err);
        });
    },
    clear() {
      this.$refs.image1.removeAllFiles();
      this.$refs.image2.removeAllFiles();
      this.$refs.image3.removeAllFiles();
      this.prod = {};
    },
    loadProduct() {
      axios
        .get(`/api/get-product-by-id/${this.$props.id}`)
        .then((result) => {
          let response = result.data;
          if (response.code > 200) {
            //throw expection
          } else {
            this.prod = response.product;
          }
        })
        .catch((err) => {});
    },
    editImage(event) {
      var id = parseInt(event.target.id.split("-")[1]);
      console.log(event.target.id);
      console.log(id);
      console.log(id-1);
      this.imagesState[id - 1] = false;
      console.log(this.imagesState);
    },
  },
};
</script>
<style scoped>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.dropzone {
  /* width: 30% !important; */
  height: 100% !important;
  margin: 0.5rem !important;
}
.inner-image {
  max-height: -webkit-fill-available;
}
.edit-shadow {
  opacity: 0;
  transition: 0.5s;
  height: 10rem;
  width: 7rem;

  margin-top: -10rem;
  background: var(--secondary-text-color);
}
.edit-shadow:hover {
  opacity: 0.3;
}
</style>