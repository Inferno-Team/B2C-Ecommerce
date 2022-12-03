<template>
    <tr
    :class="[item.status == 'waiting' ? 'waiting' : 
  item.status == 'denided' ? 'denided':'approved']" >
      <td  style="cursor: pointer;" 
      class="item"
    @click.prevent="openBill" >{{ item.date }}</td>
      <td>{{ item.total_count }}</td>
      <td>{{ item.total_price }}</td>
      <td>{{ item.district }}</td>
      <td>{{ item.status }}</td>
      <td>{{ item.street_info }}</td>
      <td
        @click.prevent="changeStatus"
        style="text-decoration:
       underline;
          font-size: 13px;
          color: #000081;
          cursor: pointer;
        "
      >
        Change Status
      </td>
    </tr>
  </template>
  
  <script>
  export default {
    props: ["item"],
    mounted(){
      let price = 0;
      this.item.items.forEach(i => {
        price += i.count * i.price;
      });
      this.item.total_price = price;
    },
    methods: {
      changeStatus() {
       this.$emit('changeStatus',this.$props.item);
      },
      openBill(){
        this.$router.push({
        name: "bill-details-page",
        params: { id: this.item.id },
      });
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
  .approved{
    background-color: #43cd43;
  }
  .waiting{
    background-color: #e5980d;
  }
  .denided{
    background-color: #df3737;
  }
   .waiting:hover{
    opacity: 0.5;
  }
  </style>