<template>
  <b-container>
    <b-row>
      <b-col>
        <div
          v-if="items != null && items.length > 0"
          class="m-3 b-3 h4 w500 max-width mx-auto"
        >
          Cart Items
        </div>
        <b-col style="height: 67%; overflow-y: auto; direction: rtl">
          <b-row
            v-for="(row, index) in displayedItems"
            :key="index"
            class="max-width mx-auto"
          >
            <b-col v-for="(col, index2) in row" :key="index2">
              <checkout-item :item="col"
            /></b-col>
          </b-row>
        </b-col>
      </b-col>
      <b-col style="height: 67%; overflow-y: auto">
        <div class="max-width b-3 w500 h4 my-3 mx-2">Payment Details</div>
        <div class="max-width h6 my-3 mx-2">
          Complete your purchase by providing your payment details.
        </div>
        <div class="mt-5 mx-2 p-2" style="max-height: 55vh">
          <b-row class="my-4" style="align-items: center">
            <b-col sm="3">
              <label for="email">Your Email</label>
            </b-col>
            <b-col sm="9">
              <b-form-input
                id="email"
                type="email"
                :value="user.email"
              ></b-form-input>
            </b-col>
          </b-row>
          <b-row class="my-4" style="align-items: center">
            <b-col sm="3">
              <label for="fName">First Name</label>
            </b-col>
            <b-col sm="9">
              <b-form-input
                id="fName"
                type="text"
                :value="user.f_name"
              ></b-form-input>
            </b-col>
          </b-row>
          <b-row class="my-4" style="align-items: center">
            <b-col sm="3">
              <label for="lName">Last Name</label>
            </b-col>
            <b-col sm="9">
              <b-form-input
                id="lName"
                type="text"
                :value="user.l_name"
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row class="my-4" style="align-items: center">
            <b-col sm="3">
              <label for="da">Deliver At</label>
            </b-col>
            <b-col sm="9">
              <b-dropdown
                id="da"
                :text="
                  selectedDistrict == null
                    ? 'Select District'
                    : `${selectedDistrict.district.name} - ${selectedDistrict.street_info} | ${selectedDistrict.district.ship_time}`
                "
              >
                <b-dropdown-item
                  v-for="(district, index) in districts"
                  :key="index"
                  @click="selectedDistrict = district"
                  >{{
                    district.district.name +
                    " - " +
                    district.street_info +
                    " | " +
                    district.district.ship_time
                  }}</b-dropdown-item
                >
                <b-dropdown-item @click="newDistictSelected = true"
                  >Add New Place</b-dropdown-item
                >
              </b-dropdown>
            </b-col>
          </b-row>
          <b-row
            class="my-4"
            v-if="newDistictSelected"
            style="align-items: center"
          >
            <b-col sm="3">
              <div class="h5 w500 max-width">New District</div>
            </b-col>
            <b-col sm="3">
              <b-form-select
                v-model="newDistrict.name"
                :options="allDistrict"
              ></b-form-select>
            </b-col>
            <b-col sm="3">
              <b-form-input
                type="text"
                v-model="newDistrict.address"
                placeholder="street info..."
              ></b-form-input>
            </b-col>
            <b-col sm="3">
              <b-button @click="addNewDistrict">Add</b-button>
            </b-col>
          </b-row>
          <b-col class="center-text m-1">
            <div class="mx-auto max-width h4">Bill Items</div>
            <b-col style="border: 1px dashed #ccc" class="mx-3 my-1 px-4 py-1">
              <b-row
                style="justify-content: space-around"
                v-for="(item, index) in items"
                class="my-3"
                :key="index"
              >
                <div class="h6 w500" style="width: 9rem">
                  {{ item.product.name }}
                </div>
                <div class="h6 w500" style="width: 7rem">
                  {{ item.item_count }} Piece
                </div>
                <div class="h6 w500" style="width: 9rem">
                  {{ item.item_count * item.product.price }} S.P
                </div>
              </b-row>
            </b-col>
            <b-row style="justify-content: space-between">
              <div class="h6 w500" style="width: 9rem">Total Price</div>
              <div class="h6 w500" style="width: 7rem">
                {{ totalPrice }} S.P
              </div>
            </b-row>
          </b-col>
          <div class="mx-auto" style="display: flex; width: 15rem">
            <b-button
              style="width: 10rem"
              pill
              variant="info"
              block
              @click="checkout"
              class="mx-auto"
            >
              Pay {{ totalPrice }} S.P</b-button
            >
          </div>
        </div>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import checkoutItem from "../components/checkout-Item.vue";
export default {
  components: { checkoutItem },
  mounted() {
    this.loadCartItems();
    this.loadUserDistricts();
    this.loadAllDistricts();
    this.getUser();
  },
  data() {
    return {
      items: [],
      displayedItems: [],
      districts: [],
      allDistrict: [],
      selectedDistrict: null,
      newDistrict: {},
      newDistictSelected: false,
      totalPrice: 0,
      user: {},
    };
  },
  methods: {
    loadCartItems() {
      axios
        .get("/api/get-user-cart")
        .then((response) => {
          this.items = response.data.cart.items;
          this.reshapeData();
          this.items.forEach((item) => {
            let price = item.product.price * item.item_count;
            this.totalPrice += price;
          });
        })
        .catch((err) =>
          this.$toast.error("something went wrong please try again later.")
        );
    },
    reshapeData() {
      var matrix = [],
        i,
        k,
        list = this.items;

      for (i = 0, k = -1; i < list.length; i++) {
        if (i % 2 === 0) {
          k++;
          matrix[k] = [];
        }

        matrix[k].push(list[i]);
      }
      this.displayedItems = matrix;
    },
    loadUserDistricts() {
      axios
        .get("/api/get-my-district")
        .then((result) => {
          this.districts = result.data.districts;
        })
        .catch((err) => {
          this.$toast.error("something went wrong.");
        });
    },
    loadAllDistricts() {
      axios
        .get("/api/get-all-district")
        .then((result) => {
          result.data.districts.forEach((dis) => {
            this.allDistrict.push({ value: dis, text: dis.name });
          });
        })
        .catch((err) => {});
    },
    addNewDistrict() {
      axios
        .post("/api/add-new-user-distict", {
          id: this.newDistrict.name.id,
          address: this.newDistrict.address,
        })
        .then((result) => {
          if (result.data.code > 200)
            this.$toast.warning("distirct didn't saved");
          else {
            this.$toast.success(result.data.msg);
            console.log(result.data.district);
            this.districts.push({
              ...result.data.district,
              street_info: this.newDistrict.address,
            });
            this.newDistictSelected = false;
            this.newDistrict = {};
          }
        })
        .catch((err) => {
          this.$toast.error("something went wrong .");
        });
    },
    getUser() {
      axios
        .get("/api/get-user")
        .then((result) => (this.user = result.data.user));
    },
    checkout() {
      axios
        .post("/api/convert-cart-to-bill", {
          user_disc_id: this.selectedDistrict.id,
        })
        .then((result) => {
          if (result.data.code > 200) {
            this.$toast.error(result.data.msg);
          } else {
            this.$toast.success(result.data.msg);
            this.$router.push({ name: "home-page" });
          }
        })
        .catch((err) => {
          this.$toast.error("something went wrong.");
          console.log(err);
        });
    },
  },
};
</script>
<style scoped>
.grid-system {
  display: grid;
  gap: 1.5rem;

  grid-template-columns: repeat(2, minmax(100px, max-content));
}
</style>