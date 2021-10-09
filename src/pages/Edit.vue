<template>
  <div class="bg-white shadow-lg p-4 w-5/12 m-auto">
    <h1 class="mb-4">Edit {{ user.name }} Info</h1>
    <com-form :formData="user" :action="'update'"></com-form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ComForm from "../components/ComForm.vue";
export default {
  components: { ComForm },
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
