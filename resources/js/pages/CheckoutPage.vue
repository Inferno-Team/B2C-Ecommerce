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
              <bill-item :item="col"
            /></b-col>
          </b-row>
        </b-col>
      </b-col>
      <b-col></b-col>
    </b-row>
  </b-container>
</template>
<script>
import BillItem from "../components/Bill-Item.vue";
export default {
  components: { BillItem },
  mounted() {
    this.loadCartItems();
  },
  data() {
    return {
      items: [],
      displayedItems: [],
    };
  },
  methods: {
    loadCartItems() {
      axios
        .get("/api/get-user-cart")
        .then((response) => {
          this.items = response.data.cart.items;

          this.reshapeData();
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