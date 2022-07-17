<template>
  <div>
    <div style="width: 400px" class="my-4 ms-auto me-auto p-3 form-container">
      <b-row class="my-4">
        <div class="mx-auto p-2 h3" style="width: 100px">Log In</div>
      </b-row>
      <b-row class="my-4">
        <b-col sm="3">
          <label for="email">Email :</label>
        </b-col>
        <b-col sm="9">
          <b-form-input
            autocomplete="off"
            id="email"
            type="email"
            v-model="user.email"
            placeholder="Please Enter your email address"
          ></b-form-input>
        </b-col>
      </b-row>
      <b-row class="my-4">
        <b-col sm="3">
          <label for="email">Password:</label>
        </b-col>
        <b-col sm="9">
          <b-form-input
            id="password"
            type="password"
            v-model="user.password"
            placeholder="Please Enter your Password"
          ></b-form-input>
        </b-col>
      </b-row>
      <b-row class="my-4">
        <b-button size="lg" @click.prevent="login" class="inline-button">Log In</b-button>
      </b-row>
      <b-row v-if="isLoading">
        <vue-ellipse-progress
          class="ms-auto me-auto"
          :loading="true"
          :size="60"
          :color="'#fbd66e'"
          :thickness="'10%'"
          :line="'butt'"
        />
      </b-row>
    </div>
    <div class="header">
      <svg
        class="waves"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28"
        preserveAspectRatio="none"
        shape-rendering="auto"
      >
        <defs>
          <path
            id="gentle-wave"
            d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"
          />
        </defs>
        <g class="parallax">
          <use
            xlink:href="#gentle-wave"
            x="48"
            y="0"
            fill="rgba(255,255,255,0.7)"
          />
          <use
            xlink:href="#gentle-wave"
            x="48"
            y="3"
            fill="rgba(255,255,255,0.5)"
          />
          <use
            xlink:href="#gentle-wave"
            x="48"
            y="5"
            fill="rgba(255,255,255,0.3)"
          />
          <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
        </g>
      </svg>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    var token = localStorage.getItem("b2c-user-token");
    var isLoggedIn = token != undefined && token != null;
    if (isLoggedIn) this.$router.push({ name: "home-page" });
  },
  data() {
    return {
      user: {},
      isLoading: false,
      progress: 40,
    };
  },
  methods: {
    login() {
      this.isLoading = true;
      axios
        .post("/api/login", this.user)
        .then((response) => {
          this.isLoading = false;
          if (response.data.code != 200) {
            this.$toast.error(response.data.message);
          } else {
            this.$toast.success(response.data.message);
            var token = response.data.token;
            var type = response.data.type;
            localStorage.setItem("b2c-user-token", token);
            localStorage.setItem("b2c-user-type", type);
            axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
            location.reload();
          }
        })
        .catch((e) => {
          console.log(e);
          this.isLoading = false;
          this.$toast.error(e);
        });
    },
  },
};
</script>
<style scoped>
.form-container {
  box-shadow: 12px 12px 20px var(--wave-color-50per);
  z-index: 3;
  border-radius: 10px;
}
.header {
  position: absolute;
  z-index: -1;
  top: 0;
  left: 0;
  width: 100%;
  background: linear-gradient(
    60deg,
    var(--wave-color) 0%,
    var(--wave-color-2) 100%
  );
  color: white;
}
.logo {
  width: 50px;
  fill: white;
  padding-right: 15px;
  display: inline-block;
  vertical-align: middle;
}

.inner-header {
  height: 65vh;
  width: 100%;
  margin: 0;
  padding: 0;
}

.flex {
  /*Flexbox for containers*/
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.waves {
  position: relative;
  width: 100%;

  margin-bottom: -7px; /*Fix for safari gap*/
  min-height: 100px;
  max-height: 150px;
}

.content {
  position: relative;
  height: 20vh;
  text-align: center;
  background-color: white;
}

/* Animation */

.parallax > use {
  animation: move-forever 25s cubic-bezier(0.55, 0.5, 0.45, 0.5) infinite;
}
.parallax > use:nth-child(1) {
  animation-delay: -2s;
  animation-duration: 7s;
}
.parallax > use:nth-child(2) {
  animation-delay: -3s;
  animation-duration: 10s;
}
.parallax > use:nth-child(3) {
  animation-delay: -4s;
  animation-duration: 13s;
}
.parallax > use:nth-child(4) {
  animation-delay: -5s;
  animation-duration: 20s;
}
@keyframes move-forever {
  0% {
    transform: translate3d(-90px, 0, 0);
  }
  100% {
    transform: translate3d(85px, 0, 0);
  }
}
</style>