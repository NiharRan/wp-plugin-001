<template>
  <div class="bg-white shadow-lg p-4 w-5/12 m-auto">
    <h1 class="mb-4">Create New User</h1>
    <com-form :formData="formData" :action="'store'"></com-form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import ComForm from "../components/ComForm.vue";
export default {
  components: { ComForm },
  computed: {
    ...mapGetters(["formData"]),
  },
  methods: {},
};
</script>
