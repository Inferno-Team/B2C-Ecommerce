<template>
  <div class="tables" v-if="bills.length > 0">
    <table>
      <tr>
        <th>Date</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Destrict</th>
        <th>Status</th>
        <th>Street Info</th>
        <th>Detials</th>
      </tr>
      <bill-item v-for="(item, index) in bills" :key="index" :item="item" />
    </table>
  </div>
</template>

<script>
import BillItem from "../components/Bill-Item.vue";
export default {
  components: { BillItem },
  mounted() {
    var token = localStorage.getItem("b2c-user-token");
    var role = localStorage.getItem("b2c-user-type");
    this.isLoggedIn = token != undefined && token != null;
    this.isAdmin = role === "admin";
    if (this.isAdmin || !this.isLoggedIn) {
      this.$toast.warning("يرجى تسجيل الدخول للوصول إلى هذه الصفحة");
      this.$router.push({ name: "login-page" });
    } else this.loadMyBills();
  },
  data() {
    return {
      isLoggedIn: false,
      isAdmin: false,
      bills: [],
    };
  },
  methods: {
    loadMyBills() {
      axios
        .get("/api/get_my_bills")
        .then((result) => {
          let data = result.data;
          console.log(data.bills);
          if (data.code == 200) {
            this.bills = data.bills;
          } else {
            this.$toast.warning(data.message);
          }
        })
        .catch((err) => {
          this.$toast.error("حدث خطأ ما");
          console.log(err);
        });
    },
  },
};
</script>

<style scoped>
th,
td,
tr {
  border: 1px solid;
  padding: 0.5rem;
}
th,
td,
tr {
  text-align: center;
  font-weight: 600;
  font-size: 21px;
}
table {
  width: 80%;
  /* display: inline-block; */
  border-collapse: collapse;
}
.tables {
  display: flex;
  justify-content: center;
  height: 79% !important;
  overflow-y: auto;

}
</style>