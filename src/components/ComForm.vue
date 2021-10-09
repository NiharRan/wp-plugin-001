<template>
  <form @submit.prevent="storeOrUpdate">
    <div class="mb-4">
      <label class="mb-2 font-bold" for="name">Name</label>
      <input
        type="text"
        v-model="formData.name"
        class="w-full"
        placeholder="Your Name"
      />
    </div>
    <div class="mb-4">
      <label class="mb-2 font-bold" for="email">E-mail</label>
      <input
        type="email"
        class="w-full"
        v-model="formData.email"
        placeholder="Your E-mail Address"
      />
    </div>
    <div class="mb-4">
      <label class="mb-2 font-bold" for="role">Role</label>
      <select v-model="formData.role" class="w-full min-w-full">
        <option value="">Select ...</option>
        <option value="admin">Admin</option>
        <option value="user">User</option>
      </select>
    </div>
    <div class="mb-4" v-if="this.action === 'update'">
      <label class="mb-2 font-bold" for="status">Status</label>
      <select v-model="formData.status" class="w-full min-w-full">
        <option value="">Select ...</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>
    <div>
      <button
        type="submit"
        class="px-4 py-2 bg-blue-600 text-white font-bold rounded-md hover:text-white hover:bg-blue-500 transition-all delay-300 ease-in-out"
      >
        {{ this.action === "store" ? "Store" : "Update" }}
      </button>
    </div>
  </form>
</template>

<script>
export default {
  props: {
    formData: {
      type: Object,
      default: () => null,
    },
    action: {
      type: String,
      default: "",
    },
  },
  methods: {
    storeOrUpdate: function() {
      if (this.action === "store") {
        this.store();
      } else {
        this.update();
      }
    },
    store: function() {
      this.$store.dispatch("SAVE_DATA", this.formData);
    },
    update: function() {
      this.$store.dispatch("UPDATE_DATA", this.formData);
    },
  },
};
</script>
