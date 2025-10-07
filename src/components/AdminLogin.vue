<template>
  <div style="max-width:400px;margin:50px auto;text-align:center;">
    <h2>Admin Login</h2>

    <input
      v-model="email"
      placeholder="Email"
      type="email"
      style="display:block;width:100%;padding:10px;margin:10px 0;border:1px solid #ccc;border-radius:5px;"
    />
    <input
      v-model="password"
      placeholder="Password"
      type="password"
      style="display:block;width:100%;padding:10px;margin:10px 0;border:1px solid #ccc;border-radius:5px;"
    />
    <button
      @click="login"
      style="padding:10px 20px;background:#007bff;color:#fff;border:none;border-radius:5px;cursor:pointer;"
    >
      Login
    </button>
  </div>
</template>

<script>
import { signInWithEmailAndPassword } from "firebase/auth";
import { auth } from "../firebase";

export default {
  name: "AdminLogin",
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    async login() {
      try {
        await signInWithEmailAndPassword(auth, this.email, this.password);
        alert("✅ Login successful!");
        // ✅ Correct dashboard path
        this.$router.push("/admin/app/dashboard");
      } catch (error) {
        alert("❌ " + error.message);
      }
    },
  },
};
</script>

