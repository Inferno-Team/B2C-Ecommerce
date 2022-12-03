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
        <th>Change Status</th>
      </tr>
      <order-item @changeStatus="changeStatus" v-for="(item, index) in bills" :key="index" :item="item" />
    </table>
    <b-modal ref="change-status" id="change-status" hide-footer>
      <b-card class="text-center">
        <div class="h4 bold">تغيير حالة الفاتورة</div>
        <b-row style="justify-content: space-between">
          <b-col sm="5" class="my-4">
            <b-form-select v-model="changeableItem.status" :options="options"></b-form-select>
          </b-col>
          <b-col sm="3" class="my-4">
            <b-button @click="changeItem" >تغيير</b-button>
          </b-col>
        </b-row>
      </b-card>
    </b-modal>
  </div>
</template>
<script>
import OrderItem from "../components/Order-Item.vue";
export default {
  components: { OrderItem },
  mounted() {
    var token = localStorage.getItem("b2c-user-token");
    var role = localStorage.getItem("b2c-user-type");
    this.isLoggedIn = token != undefined && token != null;
    this.isAdmin = role === "admin";
    if (!this.isAdmin || !this.isLoggedIn) {
      this.$toast.warning("يرجى تسجيل الدخول للوصول إلى هذه الصفحة");
      this.$router.push({ name: "login-page" });
    } else this.loadMyBills();
  },
  data() {
    return {
      isLoggedIn: false,
      isAdmin: false,
      bills: [],
      changeableItem : { },
      options:['denided','approved'],
    };
  },
  methods: {
    loadMyBills() {
      axios
        .post("/api/get-all-orders")
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
    changeStatus(item){
        this.changeableItem= {
            id:item.id,
            status:item.status
        };
        this.$bvModal.show('change-status');
    },
    changeItem(){
        this.bills.forEach((item)=>{
            if(item.id == this.changeableItem.id){
                item.status = this.changeableItem.status;
                axios.post('/api/change-bill-status',{
                    id:item.id,
                    status:item.status
                })
                .then((response)=>{
                    let data= response.data;
                    console.log(data);
                    this.$toast.success(data.msg);
                }).catch((error)=>{
                    console.log(error);
                    this.$toast.error('حدث خطأ ما');
                });
            }
        });
        this.$bvModal.hide('change-status');
    }
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