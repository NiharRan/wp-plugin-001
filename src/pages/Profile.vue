<template>
  <p class="text-2xl" v-if="user">Profile of {{ user.name }}</p>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters(["user"]),
  },
  created: function() {
    const url = window.location.href;
    const url_params = url.split("/");
    const id = url_params[url_params.length - 1];
    this.$store.dispatch("SET_USER", id);
  },
};
</script>
