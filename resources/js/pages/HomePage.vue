<template>
  <div>
    <b-img src="/storage/images/image1.png" class="image" />
    <div class="title">Winter 21'</div>
    <div class="sub-title">
      Winter layer season is here. Check out our trendy new winter collection to
      stay warm in style.
    </div>
    <div class="price-container mt-5">
      <b-row>
        <b-col>
          <div style="font-family: 'Poppins' ; font-weight: 500;">Price :</div>
          <div class="h4">112$</div>
        </b-col>
        <b-col>
          <div style="font-family: 'Poppins' ; font-weight: 500;">Color :</div>
          <b-row>
            <div
              style="background-color: #4d4c4c"
              class="color-item ms-3"
            ></div>
            <div
              style="background-color: #828282"
              class="color-item ms-3"
            ></div>
            <div
              style="background-color: #d3d3d3"
              class="color-item ms-3"
            ></div>
          </b-row>
        </b-col>
        <b-col>
          <div style="font-family: 'Poppins' ; font-weight: 500;">Size :</div>
          <b-row>
            <div class="size-item ms-3">S</div>
            <div class="size-item ms-1 active">M</div>
            <div class="size-item ms-1">L</div>
            <div class="size-item ms-1">XL</div>
          </b-row>
        </b-col>
      </b-row>
    </div>
  </div>
</template>
<script>
export default {};
</script>
<style scoped>
.image {
  height: 440px;
  position: absolute;
  right: 6rem;
  top: 4rem;
}
.title {
  font-size: 4rem;
  color: rgb(167, 7, 7);
  margin-top: 8rem;
  margin-left: 11rem;
}
.sub-title {
  margin-left: 12rem;
  width: 475px;
  color: #5d5d5d;
  font-family: "Poppins";
}
.price-container {
  margin-left: 12rem;
  width: 500px;
}
.color-item {
  border-radius: 50%;
  height: 22px;
  width: 12px;
}
.size-item {
  color: #929292;
  font-size: 1.1rem;
  width: 25px;

}
.active {
  color: #414141;
  font-weight: 600;
}
</style>