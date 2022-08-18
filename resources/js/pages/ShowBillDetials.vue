<template>
  <b-container v-if="bill != null">
    <b-col class="center-text m-4">
      <div class="mx-auto max-width h4">Bill Items</div>
      <b-col style="border: 1px dashed #ccc" class="mx-3 my-1 px-4 py-1">
        <b-row
          style="justify-content: space-around"
          v-for="(item, index) in bill.items"
          class="my-3"
          :key="index"
        >
          <div class="h6 w500" style="width: 9rem">
            {{ item.name }}
          </div>
          <div class="h6 w500" style="width: 7rem">{{ item.count }} Piece</div>
          <div class="h6 w500" style="width: 9rem">
            {{ item.count * item.price }} S.P
          </div>
        </b-row>
      </b-col>
      <b-row style="justify-content: space-around; margin-top: 1rem">
        <div class="h6 w500" style="width: 9rem">Total Price</div>
        <div class="h6 w500" style="width: 9rem">
          {{ bill.total_price }} S.P
        </div>
      </b-row>
    </b-col>
  </b-container>
</template>

<script>
export default {
  props: ["id"],
  mounted() {
    this.getBillDetails();
  },
  data() {
    return {
      bill: null,
    };
  },
  methods: {
    getBillDetails() {
      axios
        .get(`/api/get_my_bill_details/${this.id}`)
        .then((response) => {
         
          if (response.data.code == 200) {
            this.bill = response.data.bill;
            let price = 0;
            this.bill.items.forEach((i) => {
              price += i.count * i.price;
            });
            this.bill.total_price = price;
          } else {
            // this.$toast.warning(response.data.msg);
          }
        })
        .catch((error) => {
          console.log(error);
          //   this.$toast.error("something went wrong.");
        });
    },
  },
};
</script>

<style>
</style>